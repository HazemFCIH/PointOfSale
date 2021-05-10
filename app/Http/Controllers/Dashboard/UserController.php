<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:users-create'])->only('create');
        $this->middleware(['permission:users-read'])->only('index');
        $this->middleware(['permission:users-update'])->only('edit');
        $this->middleware(['permission:users-delete'])->only('destroy');
    }

    private $models = ['users','products','categories','clients'];
private $maps = ['create','read','update','delete'];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!auth()->user()->hasRole('super_admin')){
            $users = User::whereRoleIs('admin')->when($request->search , function ($query) use ($request){
return $query->where('first_name','like','%'.$request->search.'%')
    ->orWhere('last_name','like','%'.$request->search.'%');
})->latest()->paginate(10);

        }else{
       $users = User::when($request->search , function ($query) use ($request){
           return $query->where('first_name','like','%'.$request->search.'%')
               ->orWhere('last_name','like','%'.$request->search.'%');
       })->latest()->paginate(10);
        }
       return view('dashboard.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $models = $this->models;
        $maps = $this->maps;
        return view('dashboard.users.create',compact('models','maps'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name'=>'required|max:100',
            'last_name'=>'required|max:100',
            'email'=>'required|unique:users|max:256',
            'password'=>'required|confirmed|max:256',
            'permissions'=>'required',
            'image'=>'image',

        ]);
        $request_data = $request->except('password','password_confirmation','permissions','image');
        $request_data['password'] = bcrypt($request->password);
        if($request->image){
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/user_images/'.$request->image->hashName()));
            $request_data['image'] = $request->image->hashName();
        }
        $user = User::create($request_data);
        $user->attachRole('admin');
        // todo: remove create permissions and replace it with permissions seeder
        foreach ($request->permissions as $permission){
        Permission::firstOrCreate([
            'name' => $permission
        ]);
        }
        $user->attachPermissions($request->permissions);
        session()->flash('success',__('site.added_successfully'));
        return redirect()->route('dashboard.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $models = $this->models;
        $maps = $this->maps;
        $user = User::findOrFail($id);
        return view('dashboard.users.edit',compact('user','models','maps'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name'=>'required|max:100',
            'last_name'=>'required|max:100',
            'email'=>'required|unique:users,email,'.$user->id.'|max:256',
            'password'=>'required|confirmed|max:256',
            'image'=>'image',


        ]);
        $request_data = $request->except('password','password_confirmation','permissions','image');
        $request_data['password'] = bcrypt($request->password);
        if($request->image){
           if($user->image != 'default.png'){
               Storage::disk('public_uploads')->delete('/user_images/'.$user->image);

           }
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/user_images/'.$request->image->hashName()));
            $request_data['image'] = $request->image->hashName();
        }

        $user->update($request_data);
        // todo: remove create permissions and replace it with permissions seeder
        if ($request->permissions){
        foreach ($request->permissions as $permission){
            Permission::firstOrCreate([
                'name' => $permission
            ]);
        }
        $user->syncPermissions($request->permissions);
        }else{
            $user->detachPermissions([]);

        }
        session()->flash('success',__('site.edited_successfully'));
        return redirect()->route('dashboard.users.index');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if($user->image != 'default.png')
        {
            Storage::disk('public_uploads')->delete('/user_images/'.$user->image);
        }
        $user->detachRoles([]);
        $user->detachPermissions([]);
        $user->delete();
        session()->flash('success',__('site.deleted_successfully'));
        return redirect()->route('dashboard.users.index');
        // parameter can be a Role object, array, id or the role string name

    }
}

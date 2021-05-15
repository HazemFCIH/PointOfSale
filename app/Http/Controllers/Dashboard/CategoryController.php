<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:categories-create'])->only('create');
        $this->middleware(['permission:categories-read'])->only('index');
        $this->middleware(['permission:categories-update'])->only('edit');
        $this->middleware(['permission:categories-delete'])->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::when($request->search , function ($q) use ($request){
            return $q->whereTranslationLike('name','%'.$request->search.'%');
        })->latest()->paginate(10);
        return view('dashboard.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.categories.create');
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

            'ar.name'=>'required|unique:category_translations,name|max:100',
            'en.name'=>'required|unique:category_translations,name|max:100',



        ]);
        $category = Category::create($request->all());
        session()->flash('success',__('site.added_successfully'));
        return redirect()->route('dashboard.categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('dashboard.categories.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'ar.name'=>'required|unique:category_translations,name,'.$category->id.',category_id|max:100',
            'en.name'=>'required|unique:category_translations,name,'.$category->id.',category_id|max:100',


        ]);
        $category->update($request->all());
        session()->flash('success',__('site.edited_successfully'));
        return redirect()->route('dashboard.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        session()->flash('success',__('site.deleted_successfully'));
        return redirect()->route('dashboard.categories.index');
    }
}

<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:products-create'])->only('create');
        $this->middleware(['permission:products-read'])->only('index');
        $this->middleware(['permission:products-update'])->only('edit');
        $this->middleware(['permission:products-delete'])->only('destroy');
    }

    public function index(Request $request)
    {
        $categories = Category::all();
        $products = Product::when($request->search, function ($q) use ($request){
         return $q->whereTranslationLike('name','%'.$request->search.'%');
        })->when($request->category_id, function ($q) use ($request){
            return $q->where('category_id',$request->category_id);
        })->
        latest()->
        paginate(10);
        return view('dashboard.products.index',compact('products','categories'));
    }// end of index


    public function create()
    {
        $categories = Category::all();
        return view('dashboard.products.create',compact('categories'));
    } // end of create function


    public function store(Request $request)
    {
        $rules = [
            'category_id' => 'required',
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required',
        ];
        foreach (config('translatable.locales') as $locale){

            $rules += [$locale.'.name' => 'required|unique:product_translations,name'];
            $rules += [$locale.'.description' => 'required'];
        }
        $request->validate($rules);
        $request_data = $request->all();
        if($request->image){
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/product_images/'.$request->image->hashName()));
            $request_data['image'] = $request->image->hashName();
        }
        $product = Product::create($request_data);
        session()->flash('success',__('site.added_successfully'));
        return redirect()->route('dashboard.products.index');


    }// end of store function


    public function show(Product $product)
    {
        //
    }


    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('dashboard.products.edit',compact('categories','product'));
    }// end of edit function


    public function update(Request $request, Product $product)
    {
        $rules = [
            'category_id' => 'required',
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required',
        ];
        foreach (config('translatable.locales') as $locale){

            $rules += [$locale.'.name' => 'required|unique:product_translations,name,'.$product->id.',product_id'];
            $rules += [$locale.'.description' => 'required'];
        }
        $request->validate($rules);
        $request_data = $request->all();
        if($request->image){
            if($product->image != 'productDefault.png'){
                Storage::disk('public_uploads')->delete('/product_images/'.$product->image);

            }
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/product_images/'.$request->image->hashName()));
            $request_data['image'] = $request->image->hashName();
        }
        $product->update($request_data);
        session()->flash('success',__('site.edited_successfully'));
        return redirect()->route('dashboard.products.index');

    }// end of update function


    public function destroy(Product $product)
    {
        $product->delete();
        session()->flash('success',__('site.deleted_successfully'));
        return redirect()->route('dashboard.products.index');

    } //end of delete function
}

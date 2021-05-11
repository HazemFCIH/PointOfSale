<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
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
        paginate(5);
        return view('dashboard.products.index',compact('products','categories'));
    }// end of index


    public function create()
    {
        $categories = Category::all();
        return view('dashboard.products.create',compact('categories'));
    }


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


    }


    public function show(Product $product)
    {
        //
    }


    public function edit(Product $product)
    {
        //
    }


    public function update(Request $request, Product $product)
    {
        //
    }


    public function destroy(Product $product)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Dashboard\Client;
use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:orders-create'])->only('create');
        $this->middleware(['permission:orders-read'])->only('index');
        $this->middleware(['permission:orders-update'])->only('edit');
        $this->middleware(['permission:orders-delete'])->only('destroy');
    }

    public function index(Request $request)
    {

    }


    public function create(Client $client)
    {
        $categories = Category::with('products')->get();
        return view('dashboard.clients.orders.create',compact('client','categories'));

    }


    public function store(Request $request , Client $client)
    {
        $request->validate([
            'products' => 'required|array',
        ]);

        $this->attach_order($request,$client);
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.orders.index');

    }


    public function show(Order $order)
    {
        //
    }


    public function edit(Client $client,Order $order )
    {
        $categories = Category::all();
        return view('dashboard.clients.orders.edit',compact('order','client','categories'));
    }


    public function update(Request $request,Client $client, Order $order )
    {
        $request->validate([
            'products' => 'required|array',
        ]);
       $this->detach_order($order);
        $this->attach_order($request , $client);
        session()->flash('success', __('site.edited_successfully'));
        return redirect()->route('dashboard.orders.index');

    }


    public function destroy(Order $order , Client $client)
    {
        //
    }
    private  function attach_order($request , $client){
        $order = $client->orders()->create([]);
        $order->products()->attach($request->products);
        $total_price = 0;
        foreach ($request->products as $id=>$quantity){

            $product = Product::FindOrFail($id);
            if ($product->stock < $quantity['quantity']){
                $order->products()->detach($request->products);
                $order->delete();
                session()->flash('failed', __('site.product_quantity_error').$product->name);
                return back();
            }else{
                $total_price += $product->sale_price * $quantity['quantity'];

                $product->update([
                    'stock' => $product->stock - $quantity['quantity']
                ]);
            }
        }
        $order->update([
            'total_price' => $total_price
        ]);
    }
    private function detach_order($order){
        foreach ($order->products as $product){

            $product->update([
                'stock' => $product->stock + $product->pivot->quantity,
            ]);
        }
        $order->delete();
    }
}

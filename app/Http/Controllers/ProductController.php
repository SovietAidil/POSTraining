<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        confirmDelete('Delete Data', 'Are you sure you want to delete this data?');
        return view('product.index',compact('products'));
    }
    public function store(Request $request)
    {
        $id = $request->id;
        $request->validate([
            'product_name'           => 'required|unique:products,product_name,'. ($id ?: 'NULL') . ',id',
            'sale_price'             => 'required|numeric|min:0',
            'original_purchase_price'=> 'required|numeric|min:0',
            'category_id'            => 'required|exists:categories,id',
            'stock'                  => 'required|numeric|min:0',
            'minimum_stock'          => 'required|numeric|min:0',
            'is_active'              => 'boolean',
       ],[
        'product_name.required'=> 'Product name has to be filled',
        'product_name.unique'=> 'Product name already existed',
        'sale_price.required'=> 'Sale price has to be filled',
        'sale_price.numeric'=> 'Sale price has to be numeric',
        'sale_price.min'=> 'Sale price minimum 0',
        'original_purchase_price.required'=> 'Purchase price has to be filled',
        'original_purchase_price.numeric'=> 'Product name has to be numeric',
        'original_purchase_price.min'=> 'Purchase price minimum 0',
        'category_id.required'=> 'Category has to be filled',
        'category_id.exists'=> 'Category is not valid',
        'stock.required'=> 'Stock has to be filled',
        'stock.numeric'=> 'Stock has to be numeric'
       ]);

    $newRequest = [
            'product_name'=> $request->product_name,
            'sale_price'=> $request->sale_price,
            'original_purchase_price'=> $request->original_purchase_price,
            'category_id'=> $request->category_id,
            'stock'=> $request->stock,
            'minimum_stock'=> $request->minimum_stock,
            'is_active'=> $request->boolean('is_active'),
        
    ];
    if(!$id){
        $newRequest['sku'] = Product::numberSku();
    } else {
        $product = Product::find($id);
        $newRequest['sku'] = $product->sku ?? Product::numberSku();
    }
    Product::updateOrCreate(
        ["id" => $id],
        $newRequest
    
    );
    toast()->success('Data has been successfully stored');
    return redirect()->route('master-data.product.index');
    }
    // public function destroy(string $id){
    //     $product = Product::find($id);
    //     $product->delete();
    //     toast()->success('Data has been successfully deleted');
    //     return redirect()->route('master-data.product.index');
    // }
      public function destroy(string $id){
        $product = Product::findOrFail($id);
        $product->delete();
        toast()->success('Data has been successfully deleted');
        return redirect()->route('master-data.product.index');
    }

    public function getData(){
        $search = request()->query('search');

        $query = Product::query();
        $product = $query->where('product_name','like','%'.$search.'%')
        ->take(20)
        ->get();
        return response()->json($product);
    }

    public function checkStock()
    {
        $id = request()->query('id');
        $stock = Product::find($id)->stock;
        return response()->json($stock);
    }

    public function checkPrice()
    {
        $id = request()->query('id');
        $price = Product::find($id)->sale_price;
        return response()->json($price);
    }


}

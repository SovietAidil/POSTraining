<?php

namespace App\Http\Controllers;

use App\Models\GoodsIssuance;
use Illuminate\Support\Facades\Auth;
use App\Models\GoodsReceipt;
use App\Models\GoodsReceiptItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GoodsReceiptController extends Controller
{
    public function index(){
    return view('goods-receipt.index');
    }

    public function store(Request $request)
    {
  
    $request->validate([
        'distributor'                   => 'required',
        'factory_number'                => 'required',
        'product'                       => 'required',
        ],[
            'distributor.required'      => 'Distributor has to be filled',
            'factory_number.required'   => 'Factory Number has to be filled',
            'product.required'          => 'Product has to be filled',
        ]);


        $newData = GoodsReceipt::create([
            'receipt_number'    => GoodsReceipt::receiptNumber(),
            'distributor'       => $request->distributor,
            'factory_number'    => $request->factory_number,
            'receiving_staff'   => Auth::user()->name,
        ]);


        $product = $request->product;
        foreach ($product as $item) {
            GoodsReceiptItem::create([
                'receipt_number'  => $newData->receipt_number,
                'product_name'    => $item['product_name'],
                'qty'             => $item['qty'],
                'purchase_price'  => $item['purchase_price'],
                'sub_total'       => $item['sub_total'],
            ]);

            Product::where('id', $item['product_id'])->increment('stock' , $item['qty']);


        }

        toast()->success('The data has been successfully added');
        return redirect()->route('goods-receipt.index');


         dd($request->all());

    }

    public function report()
    {
        $goodsReceipt = GoodsReceipt::orderBy('created_at', 'desc')->get()->map(function($item){
            $item->receipt_date = Carbon::parse($item->created_at)->locale('ms')->translatedFormat('l, d F Y, H:i');
            return $item;
        });
        return view('report.goods-receipt.report', compact('goodsReceipt'));
    }

public function detailReport(String $receiptNumber){
    $data = GoodsReceipt::with('items')->where('receipt_number', $receiptNumber)->first();
    $data->receipt_date = Carbon::parse($data->created_at)->locale('ms')->translatedFormat('l, d F Y, H:i');
    $data->total = $data->items->sum('sub_total');
    return view('report.goods-receipt.detail', compact('data'));
}


}

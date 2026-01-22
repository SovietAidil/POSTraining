<?php

namespace App\Http\Controllers;

use App\Models\GoodsIssuance;
use App\Models\GoodsIssuanceItem;
use App\Models\GoodsReceipt;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoodsIssuanceController extends Controller
{
    public function index()
    {
    return view('goods-issuance.index');
    }

            public function store(Request $request)
            {
                if(empty($request->product)) {
                    toast()->error('No product is being selected');
                    return redirect()->back();
            
            }
            $request->validate([
                'product'   => 'required|array|min:1',
                'payment'   => 'required|numeric|min:1',
                ], [
                    'product.required'  =>'Product has to be selected',
                    'payment.required'  =>'Payment needs to be filled',
                    'payment.numeric'   =>'Payment must be in numbers format',
                    'payment.min'       =>'Minimum payment is 1',

                ]);

                $product    =  collect($request->product);
                $payment    =  floatval($request->payment);
                $total      =  $product->sum('sub_total');
                $change     =  intval($payment) - intval($product->sum('sub_total'));

                if($payment < $total) {
                    toast()->error('Payment Short');
                    return redirect()->back()->withInput([
                        'product'   => $product,
                        'payment'   => $payment,
                        'total'     => $total,
                        'change'    => $change,
                        ]);
                }

                $data = GoodsIssuance::create([
                    'issuance_number'   => GoodsIssuance::issuanceNumber(),
                    'staff_name'        => Auth::user()->name,
                    'total_price'       => $total,
                    'payment'           => $payment,
                    'change'            => $change,
                    ]);

                foreach($product as $item){
                    GoodsIssuanceItem::create([
                        'issuance_number'   => $data->issuance_number,
                        'product_name'      => $item['product_name'],
                        'qty'               => $item['qty'],
                        'price'             => $item['sale_price'],
                        'sub_total'         => $item['sub_total'],
                    ]);

                    Product::where('id', $item['product_id'])->decrement('stock', $item['qty']);
                    
            }

                toast()->success('Transaction saved');
                return redirect()->route('goods-issuance.index');
        }

        public function report()
        {
            $data = GoodsIssuance::orderBy('created_at','desc')->get()->map(function($item){
                $item->transaction_date = Carbon::parse($item->created_at)->locale('ms')->translatedFormat('l, d F Y, H:i');
                return $item;
            });

            return view('goods-issuance.report', compact('data'));
        }

        public function detailReport(String $issuanceNumber)
        {
            $data = GoodsIssuance::with('items')->where('issuance_number', $issuanceNumber)->first();
            $data->total_price = $data->items->sum('sub_total');
            $data->transaction_date = Carbon::parse($data->created_at)->timezone('Asia/Kuala_Lumpur')->locale('ms')->translatedFormat('l, d F Y H:i');
            return view('goods-issuance.detail', compact('data'));

        }


}
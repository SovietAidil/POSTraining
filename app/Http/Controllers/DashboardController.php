<?php

namespace App\Http\Controllers;

use App\Models\GoodsIssuance;
use App\Models\GoodsIssuanceItem;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $thisMonth = Carbon::now()->month;
        $thisYear = Carbon::now()->year;

        $totalUsers = User::count();
        $totalProduct = Product::count();

        $totalOrder = GoodsIssuance::whereMonth('created_at', $thisMonth)
            ->whereYear('created_at', $thisYear)
            ->count();

        $totalIncomeValue = GoodsIssuance::whereMonth('created_at', $thisMonth)
            ->whereYear('created_at', $thisYear)
            ->sum('total_price');

        $totalIncome = "RM " . number_format($totalIncomeValue,2);

        $latestOrder = GoodsIssuance::latest()->take(5)->get()->map(function($item){
            $item->transaction_date = Carbon::parse($item->created_at)
                ->timezone('Asia/Kuala_Lumpur')
                ->locale('ms')
                ->translatedFormat('l, d-m-Y, H:i');
            return $item;
        });

        $bestSeller = GoodsIssuanceItem::select('product_name')
            ->selectRaw('SUM(qty) as total_sold')
            ->whereMonth('created_at', $thisMonth)
            ->whereYear('created_at', $thisYear)
            ->groupBy('product_name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // ===============================
        // Top Product Revenue Chart
        // ===============================
        // Make sure 'unit_price' exists in goods_issuance_items
        $topProductsRevenue = GoodsIssuanceItem::select('product_name')
            ->selectRaw('SUM(qty * price) as total_revenue')
            ->groupBy('product_name')
            ->orderByDesc('total_revenue')
            ->limit(5)
            ->get();

        $chartProducts = $topProductsRevenue->pluck('product_name');       // X-axis
        $chartTotalRevenue = $topProductsRevenue->pluck('total_revenue');  // Y-axis

        return view('dashboard.index', compact(
            'totalUsers',
            'totalProduct',
            'totalOrder',
            'totalIncome',
            'latestOrder',
            'bestSeller',
            'chartProducts',
            'chartTotalRevenue',
            'thisMonth'
        ));
    }
}

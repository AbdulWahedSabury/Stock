<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\customer;
use App\Models\productInventory;
use App\Models\Provider;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $usersCount = User::count();
        $customersCount = customer::count();
        $providersCount = Provider::count();
        $stocksCount = Stock::count();
        $totalPurchase = Purchase::sum('total_price');
        $totalSale = Sale::sum('total_price');
        $totalInventory = productInventory::sum('quantity');
        return view('admin.dashboard',
                    ['usersCount'=>$usersCount,
                    'customersCount'=> $customersCount,
                    'providersCount'=> $providersCount,
                    'stocksCount'=> $stocksCount,
                    'totalPurchase'=> $totalPurchase,
                    'totalSale'=> $totalSale,
                    'totalInventory'=> $totalInventory,
                ]);
    }
}

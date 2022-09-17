<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Admin\Users\UsersLists;
use App\Http\Livewire\admin\product\ProductList;
use App\Http\Livewire\Admin\Profile\ProfileUpdate;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Livewire\Admin\Customers\CustomersList;
use App\Http\Livewire\Admin\ProductInventory\ProductInventoryList;
use App\Http\Livewire\Admin\Providers\ProvidersList;
use App\Http\Livewire\Admin\Purchase\PurchaseList;
use App\Http\Livewire\Admin\Sales\SalesList;
use App\Http\Livewire\Admin\Stock\StochList;

    Route::get('dashboard',DashboardController::class)->name('admin.dashboard');
    Route::get('users',UsersLists::class)->name('admin.users');
    Route::get('customers',CustomersList::class)->name('admin.customers');
    Route::get('providers',ProvidersList::class)->name('admin.providers');
    Route::get('products',ProductList::class)->name('admin.products');
    Route::get('stocks',StochList::class)->name('admin.stocks');
    Route::get('inventories',ProductInventoryList::class)->name('admin.inventory');
    Route::get('purchase',PurchaseList::class)->name('admin.purchase');
    Route::get('sales',SalesList::class)->name('admin.sales');
    Route::get('profile/edit',ProfileUpdate::class)->name('admin.profile.edit');
?>

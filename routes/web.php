<?php

use App\Http\Controllers\CreditController;
use App\Livewire\Cart;
use App\Livewire\Admin\Sale;
use App\Livewire\Admin\Order;
use App\Livewire\Installment;
use App\Livewire\LandingPage;
use App\Livewire\Transaction;
use App\Livewire\Admin\Credit;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Password;
use App\Livewire\Admin\Product\Index;
use App\Livewire\Settings\Appearance;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Product\Create;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SaleReportController;

Route::get('/', LandingPage::class)->name('home');
Route::get('/keranjang', Cart::class)->name('cart');
Route::get('/transaksi', Transaction::class)->name('transaction');
Route::get('/invoice/{orderId}', [InvoiceController::class, 'streamUserInvoice'])
    ->name('user.invoice.stream');
Route::get('/cicilan', Installment::class)->name('installment');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', Dashboard::class)->name('dashboard');

    // Product Route
    Route::get('/produk', Index::class)->name('product.index');
    Route::get('/produk/tambah-produk', Create::class)->name('product.create');

    Route::get('/penjualan', Sale::class)->name('sale');
    Route::get('/pesanan', Order::class)->name('order');
    Route::get('/tagihan', Credit::class)->name('credit');

    Route::get('penjualan/stream', [SaleReportController::class, 'streamSalesReport'])
        ->name('reports.sales.stream');
    Route::get('tagihan/stream', [CreditController::class, 'streamCreditReport'])
        ->name('credit.stream');
});


// Route::middleware(['auth'])->group(function () {
//     Route::redirect('settings', 'settings/profile');

//     Route::get('settings/profile', Profile::class)->name('settings.profile');
//     Route::get('settings/password', Password::class)->name('settings.password');
//     Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
// });

require __DIR__ . '/auth.php';

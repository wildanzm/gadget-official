<?php

use App\Livewire\LandingPage;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Product\Create;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Password;
use App\Livewire\Admin\Product\Index;
use App\Livewire\Settings\Appearance;
use Illuminate\Support\Facades\Route;

Route::get('/', LandingPage::class)->name('home');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', Dashboard::class)->name('dashboard');

    // Product Route
    Route::get('/produk', Index::class)->name('product.index');
    Route::get('/produk/tambah-produk', Create::class)->name('product.create');
});


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__ . '/auth.php';

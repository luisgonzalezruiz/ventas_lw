<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Livewire\Category\Categories;
use App\Http\Livewire\Denomination\Denominations;
use App\Http\Livewire\Pos\Pos;
use \App\Http\Livewire\Product\Products;
use App\Http\Livewire\Role\Roles;
use App\Http\Livewire\Permiso\Permisos;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/categories', Categories::class)->name('categories');
    Route::get('/products', Products::class)->name('products');
    Route::get('/denominations', Denominations::class)->name('denominations');
    Route::get('/pos', Pos::class)->name('pos');
    Route::get('/roles', Roles::class)->name('roles');
    Route::get('/permissions', Permisos::class)->name('permissions');

    // Route::get('/products', Products::class)->name('products');
/*     Route::get('/denominations', Denominations::class)->name('denominations');
    Route::get('/sales', Sales::class)->name('sales');
    Route::get('/roles', Roles::class)->name('roles');
    Route::get('/users', Users::class)->name('users');
    Route::get('/cashout', Cashout::class)->name('cashout');
    Route::get('/reports', Reports::class)->name('reports');
    Route::get('/reports/pdf/{user}/{from_date?}/{to_date?}', [ExportController::class, 'reportPdf'])
        ->name('reportPdf')
        ->middleware('can:reports,sale');
    Route::get('/reports/excel/{user}/{from_date?}/{to_date?}', [ExportController::class, 'reportExcel'])
        ->name('reportExcel')
        ->middleware('can:reports,sale'); */
});

//Route::redirect('/', '/sales');

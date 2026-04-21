<?php

use App\Http\Controllers\LeadController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SeoController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/diski', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/diski/{brand}', [CatalogController::class, 'brand'])->name('catalog.brand');
Route::get('/diski/{brand}/{vehicleModel}', [CatalogController::class, 'model'])->name('catalog.model');
Route::view('/services', 'services.index')->name('services.index');
Route::view('/services/premium-tire-fitting', 'services.premium-tire-fitting')->name('services.premium-tire-fitting');
Route::view('/services/wheel-restoration', 'services.wheel-restoration')->name('services.wheel-restoration');
Route::view('/services/vin-selection', 'services.vin-selection')->name('services.vin-selection');
Route::redirect('/contacts', '/about.html', 301)->name('contacts');
Route::view('/delivery', 'pages.delivery')->name('delivery');
Route::view('/warranty', 'pages.warranty')->name('warranty');
Route::view('/privacy', 'pages.privacy')->name('privacy');
Route::view('/about.html', 'pages.about')->name('about');
Route::get('/product/{product:slug}', [CatalogController::class, 'product'])->name('products.show');
Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('seo.sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('seo.robots');

Route::post('/leads', [LeadController::class, 'store'])->name('leads.store');

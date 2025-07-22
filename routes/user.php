<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\WhyChooseUsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReferController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AriadhakaController;
use App\Http\Controllers\VariantController;
use App\Http\Controllers\IndexController;

Route::get('/add-user-product', [IndexController::class, 'addUserProduct']);

Route::group(['middleware' => 'prevent-back-history'],function(){

	//sliders

    Route::resource('sliders', SliderController::class);

  //expenses

    Route::resource('expenses', ExpenseController::class);

  //units

    Route::resource('units', UnitController::class);

  //products

    Route::resource('products', ProductController::class);
    Route::get('/redirect-demo-url', [ProductController::class, 'redirectDemoUrl'])->name('redirect-demo-url');

  //variants

    Route::get('/add-variant/{id}', [VariantController::class, 'addVariant']);
    Route::post('store-variants', [VariantController::class, 'storeVariants']);

  //revieews

    Route::resource('reviews', ReviewController::class);

  //areas

    Route::resource('ariadhakas', AriadhakaController::class);

    Route::get('/get-districts/{division_id}', [AriadhakaController::class, 'getDistricts']);


    //video

    Route::get('/add-video', [VideoController::class, 'addVideo']);

    Route::post('save-video', [VideoController::class, 'saveVideo']);

  //report

    Route::get('/sales-report', [ReportController::class, 'salesReport']);
    Route::get('/finance-report', [ReportController::class, 'financeReport']);

  //orders

    Route::get('/orders', [OrderController::class, 'orders'])->name('my.orders');

    Route::delete('/delete-order/{id}', [OrderController::class, 'deleteOrder']);

    Route::get('/show-invoice/{id}', [OrderController::class, 'showInvoice']);

    Route::get('/print-invoice/{id}', [OrderController::class, 'printInvoice']);

    Route::get('/search-courier-order', [OrderController::class, 'searchCourierOrder']);



  //settings

    Route::get('/refer-settings', [ReferController::class, 'referSettings']);
    Route::post('settings-refer', [ReferController::class, 'settingsRefer']);
    Route::get('/info-settings', [InfoController::class, 'infoSettings']);
    Route::post('settings-info', [InfoController::class, 'settingsInfo']);
    Route::get('/meta-pixel-settings', [SettingController::class, 'metaPixelSettings']);
    Route::get('/set-delivery-charge', [SettingController::class, 'setDelveryCharge']);
    Route::get('/app-settings', [SettingController::class, 'appSettings']);
    Route::post('settings-app', [SettingController::class, 'settingApp']);
    Route::get('/password-change', [SettingController::class, 'passwordChange']);
    Route::post('change-password', [SettingController::class, 'changePassword']);
    Route::get('/social-media-settings', [SettingController::class, 'socialMediaSettings']);
    Route::get('/terms-conditions', [SettingController::class, 'termsCondition']);
    Route::get('/refund-policy', [SettingController::class, 'refundPolicy']);

    Route::get('/payment-info', [SettingController::class, 'paymentInfo'])->name('payment-info.index');
    Route::get('/create-payment-info', [SettingController::class, 'createPaymentInfo'])->name('payment-info.create');
    Route::post('/store-payment-info', [SettingController::class, 'StorePaymentInfo'])->name('payment-info.store');
    Route::get('/edit-payment-info/{id}', [SettingController::class, 'EditPaymentInfo'])->name('payment-info.edit');
    Route::post('/update-payment-info/{paymentInfo}', [SettingController::class, 'UpdatePaymentInfo'])->name('payment-info.update');

    Route::get('/purchase-history', [SettingController::class, 'purchaseHistory'])->name('purchase-history');
    Route::post('/purchase-status-update', [SettingController::class, 'userStatusUpdate']);
    Route::get('/view-purchase-history/{id}', [SettingController::class, 'viewPurchaseHistory'])->name('view-purchase-history');

    // Why Choose Us
    Route::get('/why-choose-us', [WhyChooseUsController::class, 'index'])->name('why_choose_us.index');
    Route::get('/why-choose-us/create', [WhyChooseUsController::class, 'create'])->name('why_choose_us.create');
    Route::post('/why-choose-us', [WhyChooseUsController::class, 'store'])->name('why_choose_us.store');
    Route::get('/why-choose-us/{id}/edit', [WhyChooseUsController::class, 'edit'])->name('why_choose_us.edit');
    Route::post('/why-choose-us/{whyChooseUs}', [WhyChooseUsController::class, 'update'])->name('why_choose_us.update');
    Route::post('/delete/why-choose-us/{whyChooseUs}', [WhyChooseUsController::class, 'destroy'])->name('why_choose_us.destroy');

    // Banner
    Route::get('/banner', [BannerController::class, 'index'])->name('banner.index');
    Route::get('/banner/create', [BannerController::class, 'create'])->name('banner.create');
    Route::post('/banner', [BannerController::class, 'store'])->name('banner.store');
    Route::get('/banner/{id}/edit', [BannerController::class, 'edit'])->name('banner.edit');
    Route::post('/banner/{banner}', [BannerController::class, 'update'])->name('banner.update');
    Route::post('/delete/banner/{banner}', [BannerController::class, 'destroy'])->name('banner.destroy');
});

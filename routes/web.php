<?php

use Illuminate\Support\Facades\Route;


Route::as('admin.')->middleware([])->group(function (){

    Route::prefix('/')->middleware([])->group(function (){
        Route::get('/login',[\App\Http\Controllers\V1\Web\AuthController::class,'index'])->name('login.index');
        Route::post('/login',[\App\Http\Controllers\V1\Web\AuthController::class,'login'])->name('login');
        Route::post('/logout',[\App\Http\Controllers\V1\Web\AuthController::class,'logout'])->name('logout');
    });

    Route::prefix('admin')->middleware(['authCheck'])->group(function (){
        Route::get('/',[\App\Http\Controllers\V1\Web\DashboardController::class,'index'])->name('index');
        Route::post('/clear-cache', [\App\Http\Controllers\V1\Web\DashboardController::class, 'clearCache'])->name('clearCache');


        Route::get('/settings',[\App\Http\Controllers\V1\Web\Setting\SettingController::class,'index'])->name('settings.index');
        Route::post('/settings',[\App\Http\Controllers\V1\Web\Setting\SettingController::class,'update'])->name('settings.update');
        Route::get('/settings/about',[\App\Http\Controllers\V1\Web\Setting\SettingAboutController::class,'aboutIndex'])->name('settings.about.index');
        Route::post('/settings/about',[\App\Http\Controllers\V1\Web\Setting\SettingAboutController::class,'aboutUpdate'])->name('settings.about.update');
        Route::get('/settings/ai',[\App\Http\Controllers\V1\Web\Setting\SettingAiController::class,'aiIndex'])->name('settings.ai.index');
        Route::post('/settings/ai',[\App\Http\Controllers\V1\Web\Setting\SettingAiController::class,'aiUpdate'])->name('settings.ai.update');
        Route::get('/settings/payment',[\App\Http\Controllers\V1\Web\Setting\SettingPaymentController::class,'paymentIndex'])->name('settings.payment.index');
        Route::post('/settings/payment',[\App\Http\Controllers\V1\Web\Setting\SettingPaymentController::class,'paymentUpdate'])->name('settings.payment.update');
        Route::get('/settings/rule',[\App\Http\Controllers\V1\Web\Setting\SettingRuleController::class,'ruleIndex'])->name('settings.rule.index');
        Route::post('/settings/rule',[\App\Http\Controllers\V1\Web\Setting\SettingRuleController::class,'ruleUpdate'])->name('settings.rule.update');
        Route::get('/settings/sms',[\App\Http\Controllers\V1\Web\Setting\SettingSmsController::class,'smsIndex'])->name('settings.sms.index');
        Route::post('/settings/sms',[\App\Http\Controllers\V1\Web\Setting\SettingSmsController::class,'smsUpdate'])->name('settings.sms.update');
        Route::get('/settings/social',[\App\Http\Controllers\V1\Web\Setting\SettingSocialController::class,'socialIndex'])->name('settings.social.index');
        Route::post('/settings/social',[\App\Http\Controllers\V1\Web\Setting\SettingSocialController::class,'socialUpdate'])->name('settings.social.update');
        Route::get('/settings/watermark',[\App\Http\Controllers\V1\Web\Setting\SettingWatermarkController::class,'watermarkIndex'])->name('settings.watermark.index');
        Route::post('/settings/watermark',[\App\Http\Controllers\V1\Web\Setting\SettingWatermarkController::class,'watermarkUpdate'])->name('settings.watermark.update');


        Route::resource('users',\App\Http\Controllers\V1\Web\UserController::class);
        Route::resource('admins',\App\Http\Controllers\V1\Web\AdminController::class);
        Route::resource('roles',\App\Http\Controllers\V1\Web\RoleController::class);
        Route::resource('provinces',\App\Http\Controllers\V1\Web\ProvinceController::class);
        Route::resource('cities',\App\Http\Controllers\V1\Web\CityController::class);
        Route::resource('questions',\App\Http\Controllers\V1\Web\QuestionController::class);
        Route::resource('sliders',\App\Http\Controllers\V1\Web\SliderController::class);

        Route::resource('notifications',\App\Http\Controllers\V1\Web\NotificationController::class);
        Route::post('notifications/destroyAll',[\App\Http\Controllers\V1\Web\NotificationController::class,'destroyAll'])->name('notifications.destroyAll');

        Route::get('whatsapp-chats',[\App\Http\Controllers\V1\Web\MessengerController::class,'index'])->name('whatsapp-chats.index');
        Route::get('whatsapp-chats/{phone}/messages',[\App\Http\Controllers\V1\Web\MessengerController::class,'show'])->name('whatsapp-chats.show');
        Route::post('whatsapp-chats/send',[\App\Http\Controllers\V1\Web\MessengerController::class,'store'])->name('whatsapp-chats.store');
        Route::get('whatsapp/status', [\App\Http\Controllers\V1\Web\MessengerController::class,'status'])->name('whatsapp.status');
        Route::post('whatsapp/connect', [\App\Http\Controllers\V1\Web\MessengerController::class,'connect'])->name('whatsapp.connect');
        Route::post('whatsapp/disconnect', [\App\Http\Controllers\V1\Web\MessengerController::class,'disconnect'])->name('whatsapp.disconnect');

    });

});

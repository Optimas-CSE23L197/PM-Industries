<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{ AuthCntlr, CompanyCntlr };
use App\Http\Controllers\production\{DashboardProductionCntlr};


Route::controller(AuthCntlr::class)->group(function(){
    Route::get('/', 'userLogin')->name('userLogin');
    Route::post('/user-verify', 'userVerify')->name('userVerify');
});

Route::middleware(['checksession'])->group(function () {

    Route::controller(AuthCntlr::class)->group(function(){
        Route::get('/company-login', 'companyLogin')->name('companyLogin');
        Route::post('/company-selection', 'selectComp')->name('selectComp');
        Route::get('/logout', 'logout')->name('logout');
    });

    Route::view('choose-department', 'choose_department')->name('chooseDept');

    // ========================= COMPANY =======================================
    Route::prefix('/company')->controller(CompanyCntlr::class)->group(function(){
        Route::get('/company-list', 'getCompany')->name('compList');
        Route::get('/company-details/{mode}/{code?}', 'getdetails')->name('compDetails');
        Route::post('/save-company', 'saveComp')->name('saveComp');
        Route::get('/company-stat-change/{code}/{aedl}', 'statComp')->name('statComp');
    });
    // ========================= COMPANY =======================================

    // ========================= PRODUCTION DASHBOARD ====================================
    Route::prefix('/dashboard')->controller(DashboardProductionCntlr::class)->group(function () {
        Route::get('/production', 'production')->name('production');
    });
    // ========================= PRODUCTION DASHBOARD ====================================
});
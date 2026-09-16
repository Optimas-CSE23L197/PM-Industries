<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{ AuthCntlr, CompanyCntlr };
use App\Http\Controllers\RawMaterialsInventory\{ DashboardCntlr, RawItemTypeCntlr, RawItemCntlr };


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

    Route::prefix('/company')->controller(CompanyCntlr::class)->group(function(){
        Route::get('/company-list', 'getCompany')->name('compList');
        Route::get('/company-details/{mode}/{code?}', 'getdetails')->name('compDetails');
        Route::post('/save-company', 'saveComp')->name('saveComp');
        Route::get('/company-stat-change/{code}/{aedl}', 'statComp')->name('statComp');
    });

    /* ============== || Raw Materials Inventory || ================ */
    Route::prefix('/raw-materials-inventory')->group(function(){
        Route::get('/dashboard', [DashboardCntlr::class, 'dashboard'])->name('rawMaterialsInventory.dashboard');
        /* ============== || Raw Item Type || ================ */
        Route::controller(RawItemTypeCntlr::class)->group(function(){
            Route::get('/raw-item-type', 'index')->name('rawMaterialsInventory.rawMaterialTypeList');
            Route::get('/print-raw-item-type-list', 'getprint')->name('rawMaterialsInventory.printRawItemTypeList');
            Route::get('/raw-item-type-details/{mode}/{code?}', 'getDetails')->name('rawMaterialsInventory.rawMaterialTypeDetails');
            Route::post('/save-raw-item-type', 'saveRawMaterialType')->name('rawMaterialsInventory.rawMaterialTypeSave');
            Route::get('/raw-item-type-stat-change/{code}/{aedl}', 'statRawMaterialType')->name('rawMaterialsInventory.rawMaterialTypeStatChange');
        });
        /* ============== || Raw Item Type || ================ */

        /* ============== || Raw Item || ================ */
        Route::controller(RawItemCntlr::class)->group(function(){
            Route::get('/raw-item', 'getList')->name('rawMaterialsInventory.rawItemList');
            Route::get('/print-raw-item-list', 'getprint')->name('rawMaterialsInventory.printRawItemList');
            Route::get('/raw-item-details/{mode}/{code?}', 'getDetails')->name('rawMaterialsInventory.rawItemDetails');
            Route::post('/save-raw-item', 'saveRawItem')->name('rawMaterialsInventory.rawItemSave');
            Route::get('/raw-item-stat-change/{code}/{aedl}', 'statRawItem')->name('rawMaterialsInventory.rawItemStatChange');
        });
        /* ============== || Raw Item || ================ */
    });
    /* ============== || Raw Materials Inventory || ================ */
});
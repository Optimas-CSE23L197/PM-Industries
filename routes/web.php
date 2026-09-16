<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{ AuthCntlr, CompanyCntlr };
use App\Http\Controllers\Production\{DashboardProductionCntlr, FinishedItemTypeCntlr,FinishedItemCntlr, ItemSizeCntlr, BomCntlr, MachineCntlr, MaintenanceTypeCntlr};
use App\Http\Controllers\RawMaterialsInventory\{ DashboardCntlr, RawItemTypeCntlr, RawItemCntlr };
use PHPUnit\Event\Test\Finished;

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

    /* ============== || PRODUCTION || ================ */
    Route::prefix('/production')->group(function () {
        /* ============== || DASHBOARD || ================ */
        Route::get('/dashboard', [DashboardProductionCntlr::class, 'production'])
            ->name('production.dashboard');
        /* ============== || FINISHED ITEM TYPE || ================ */
        Route::controller(FinishedItemTypeCntlr::class)->group(function () {
            Route::get('/finished-item-type', 'finishedItemType')
                ->name('finishedItemType');
            Route::get('/finished-item-type-details/{vwedt?}/{code?}', 'finishedItemTypeDetails')
                ->name('finishedItemTypeDetails');
            Route::post('/save-finished-item-type', 'saveFinishedItemType')
                ->name('saveFinishedItemType');
            Route::get('/finished-item-type-stat/{code}/{actyn}', 'statFinishedItemType')
                ->name('finishedItemType.stat');
        });
        /* ============== || FINISHED ITEM || ================ */
        Route::controller(FinishedItemCntlr::class)->group(function () {
            Route::get('/finished-item', 'finishedItem')
                ->name('finishedItem');
            Route::get('/finished-item-details/{vwedt?}/{code?}', 'finishedItemDetails')
                ->name('finishedItemDetails');
            Route::post('/save-finished-item', 'saveFinishedItem')
                ->name('saveFinishedItem');
            Route::get('/finished-item-stat/{code}/{actyn}', 'statFinishedItem')
                ->name('finishedItem.stat');
        });
        /* ============== || ITEM SIZE || ================ */
        Route::controller(ItemSizeCntlr::class)->group(function () {
            Route::get('/item-size', 'itemSize')
                ->name('itemSize');
            Route::get('/item-size-details/{vwedt?}/{code?}', 'itemSizeDetails')
                ->name('itemSizeDetails');
            Route::post('/save-item-size', 'saveItemSize')
                ->name('saveItemSize');
            Route::get('/item-size-stat/{code}/{actyn}', 'statItemSize')
                ->name('itemSize.stat');
        });
        /* ============== || BOM || ================ */
        Route::controller(BomCntlr::class)->group(function () {
            Route::get('/bom', 'bom')
                ->name('bom');
            Route::get('/bom/{vwedt?}/{code?}', 'bomDetails')
                ->name('bomDetails');
            Route::post('/save-bom', 'saveBom')
                ->name('saveBom');
            Route::get('/bom-stat/{code}/{aedl}', 'statBom')
                ->name('bom.stat');
        });
        /* ============== || MACHINE || ================ */
        Route::controller(MachineCntlr::class)->group(function () {
            Route::get('/machine', 'machine')
                ->name('machine');
            Route::get('/machine-details/{vwedt?}/{code?}', 'machineDetails')
                ->name('machineDetails');
            Route::post('/save-machine', 'saveMachine')
                ->name('saveMachine');
            Route::get('/machine-stat/{code}/{actyn}', 'statMachine')
                ->name('machine.stat');
        });
        /* ============== || MAINTENANCE TYPE || ================ */
        Route::controller(MaintenanceTypeCntlr::class)->group(function () {
            Route::get('/maintenance-type', 'maintenanceType')
                ->name('maintenanceType');
            Route::get('/maintenance-type-details/{vwedt?}/{code?}', 'maintenanceTypeDetails')
                ->name('maintenanceTypeDetails');
            Route::post('/save-maintenance-type', 'saveMaintenanceType')
                ->name('saveMaintenanceType');
            Route::get('/maintenance-type-stat/{code}/{actyn}', 'statMaintenanceType')
                ->name('maintenanceType.stat');
        });
    });
    /* ============== || PRODUCTION || ================ */


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
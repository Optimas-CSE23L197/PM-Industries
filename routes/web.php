<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{ AuthCntlr, CompanyCntlr };
use App\Http\Controllers\RawMaterialsInventory\{ DashboardCntlr, RawItemTypeCntlr, RawItemCntlr, StoreCntlr, SupplierCntlr, DepartmentCntlr, OpeningStkCntlr, PurchaseOrderCntlr };


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


        /* =====================================================================
                                    Masters
        ========================================================================= */
        Route::prefix('/masters')->group(function(){
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

            /* ============== || Store || =============== */
            Route::controller(StoreCntlr::class)->group(function(){
                Route::get('/get-store-list', 'getList')->name('rawMaterialsInventory.storeList');
                Route::get('/print-store-list', 'getPrint')->name('rawMaterialsInventory.printStoreList');
                Route::get('/store-details/{mode}/{code?}', 'getDetails')->name('rawMaterialsInventory.storeDetails');
                Route::post('/save-store', 'saveStore')->name('rawMaterialsInventory.saveStore');
                Route::get('/store-stat-change', 'statStore')->name('rawMaterialsInventory.storeStatChange');
            });
            /* ============== || Store || =============== */

            /* ================ || Supplier || ================== */
            Route::controller(SupplierCntlr::class)->group(function(){
                Route::get('/supplier', 'getList')->name('rawMaterialsInventory.supplierList');
                Route::get('/print-supplier-list', 'getprint')->name('rawMaterialsInventory.printSupplierList');
                Route::get('/supplier-details/{mode}/{code?}', 'getDetails')->name('rawMaterialsInventory.supplierDetails');
                Route::post('/save-supplier', 'saveSupplier')->name('rawMaterialsInventory.supplierSave');
                Route::get('/supplier-stat-change/{code}/{aedl}', 'statSupplier')->name('rawMaterialsInventory.supplierStatChange');
            });
            /* ================ || Supplier || ================== */

            /* ================ || Department || ================== */
            Route::controller(DepartmentCntlr::class)->group(function(){
                Route::get('/department', 'getList')->name('rawMaterialsInventory.departmentList');
                Route::get('/print-department-list', 'getPrint')->name('rawMaterialsInventory.printDepartmentList');
                Route::get('/department-details/{mode}/{code?}', 'getDetails')->name('rawMaterialsInventory.departmentDetails');
                Route::post('/save-department', 'saveDepartment')->name('rawMaterialsInventory.Savedepartment');
                Route::get('/department-stat-change/{code}/{aedl}', 'statDepartment')->name('rawMaterialsInventory.departmentStatChange');
            });
            /* ================ || Department || ================== */

            /* ================ || Opening Stock || ================== */
            Route::controller(OpeningStkCntlr::class)->group(function(){
                Route::get('/get-opening-stock', 'getList')->name('rawMaterialsInventory.opStkList');
                Route::get('/print-opening-stock', 'getPrint')->name('rawMaterialsInventory.printOpStkList');
                Route::get('/opening-stock-details/{mode}/{code?}', 'getDetails')->name('rawMaterialsInventory.opStkDetails');
                Route::post('/save-opening-stock', 'saveOpStk')->name('rawMaterialsInventory.saveOpStk');
                Route::get('/opening-stock-stat-change/{code}/{aedl}', 'statOpStk')->name('rawMaterialsInventory.opStkStatChange');
            });
            /* ================ || Opening Stock || ================== */
        });
        /* =====================================================================
                                    Masters
        ========================================================================= */


        /* =====================================================================
                                    Transactions
        ========================================================================= */
        Route::prefix('/transactions')->group(function(){
            Route::controller(PurchaseOrderCntlr::class)->group(function(){
                Route::get('/get-purchase-list', 'getList')->name('rawMaterialsInventory.purchaseOrderList');
                Route::get('/print-purchase-order-list', 'getPrint')->name('rawMaterialsInventory.printPurchaseOrderList');
                Route::get('/purchase-order-details/{mode}/{code?}', 'getDetails')->name('rawMaterialsInventory.purchaseOrderDetails');
                Route::post('/save-Purchase-order', 'savePurchaseOrder')->name('rawMaterialsInventory.savePurchsaeOrder');
                Route::get('purchase-order-stat-change/{code}/{aedl}', 'sataPurchaseOrder')->name('rawMaterialsInventory.sataPurchaseOrder');
            });
        });
        /* =====================================================================
                                    Transactions
        ========================================================================= */
    });
    /* ============== || Raw Materials Inventory || ================ */
});
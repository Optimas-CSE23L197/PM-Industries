<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{ AuthCntlr, CompanyCntlr };
use App\Http\Controllers\Production\{DashboardProductionCntlr, FinishedItemTypeCntlr,FinishedItemCntlr, ItemSizeCntlr, BomCntlr, MachineCntlr, MaintenanceTypeCntlr};
use App\Http\Controllers\CRM\{DashboardCrmCntlr, CustomerCntlr,LeadSourceCntlr,TermsConditionsCntlr,PriceListCntlr, EnquiryCntlr, EnquiryFollowupCntlr, QuotationCntlr, QuotationFollowupCntlr, SalesOrderCntlr, SalesCntlr, SalesReturnCntlr, ReceiptCntlr, ReceiptFollowupCntlr};
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
            /* PRINT */
            Route::get('/print-finished-item-type-list', 'printFinishedItemTypeList')
                ->name('production.printFinishedItemTypeList');
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
            /* PRINT */
            Route::get('/print-finished-item-list', 'printFinishedItemList')
                ->name('production.printFinishedItemList');
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
            /* PRINT */
            Route::get('/print-item-size-list', 'printItemSizeList')
                ->name('production.printItemSizeList');
        });

        /* ============== || BOM || ================ */
        Route::controller(BomCntlr::class)->group(function () {
            Route::get('/bom', 'bom')
                ->name('bom');
            Route::get('/bom-details/{vwedt?}/{code?}', 'bomDetails')
                ->name('bomDetails');
            Route::post('/save-bom', 'saveBom')
                ->name('saveBom');
            Route::get('/bom-stat/{code}/{actyn}', 'statBom')
                ->name('bom.stat');
            /* PRINT */
            Route::get('/print-bom-list', 'printBomList')
                ->name('production.printBomList');
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
            /* PRINT */
            Route::get('/print-machine-list', 'printMachineList')
                ->name('production.printMachineList');
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
            /* PRINT */
            Route::get('/print-maintenance-type-list', 'printMaintenanceTypeList')
                ->name('production.printMaintenanceTypeList');
        });

    });
    /* ============== || PRODUCTION || ================ */


    /* ============== || CRM || ================ */
    Route::prefix('/crm')->group(function () {

        /* ============== || DASHBOARD || ================ */
        Route::get('/dashboard', [DashboardCrmCntlr::class, 'crm'])
            ->name('crm.dashboard');

        /* ============== || MASTERS || ================ */

        /* Customer */
        Route::controller(CustomerCntlr::class)->group(function () {
            Route::get('/customer', 'customer')->name('customer');
            Route::get('/customer-details/{vwedt?}/{code?}', 'customerDetails')->name('customerDetails');
            Route::post('/save-customer', 'saveCustomer')->name('saveCustomer');
            Route::get('/customer-stat/{code}/{actyn}', 'statCustomer')->name('customer.stat');
            Route::get('/print-customer-list', 'printCustomerList')->name('crm.printCustomerList');
        });

        /* Lead Source */
        Route::controller(LeadSourceCntlr::class)->group(function () {
            Route::get('/lead-source', 'leadSource')->name('leadSource');
            Route::get('/lead-source-details/{vwedt?}/{code?}', 'leadSourceDetails')->name('leadSourceDetails');
            Route::post('/save-lead-source', 'saveLeadSource')->name('saveLeadSource');
            Route::get('/lead-source-stat/{code}/{actyn}', 'statLeadSource')->name('leadSource.stat');
            Route::get('/print-lead-source-list', 'printLeadSourceList')->name('crm.printLeadSourceList');
        });

        /* Price List */
        Route::controller(PriceListCntlr::class)->group(function () {
            Route::get('/price-list', 'priceList')->name('priceList');
            Route::get('/price-list-details/{vwedt?}/{code?}', 'priceListDetails')->name('priceListDetails');
            Route::post('/save-price-list', 'savePriceList')->name('savePriceList');
            Route::get('/price-list-stat/{code}/{actyn}', 'statPriceList')->name('priceList.stat');
            Route::get('/print-price-list', 'printPriceList')->name('crm.printPriceList');
        });

        /* Terms & Conditions */
        Route::controller(TermsConditionsCntlr::class)->group(function () {
            Route::get('/terms-conditions', 'termsConditions')->name('termsConditions');
            Route::post('/save-terms-conditions', 'saveTermsConditions')->name('saveTermsConditions');
        });

        /* ============== || TRANSACTIONS || ================ */

        /* Enquiry */
        Route::controller(EnquiryCntlr::class)->group(function () {
            Route::get('/enquiry', 'enquiry')->name('enquiry');
            Route::get('/enquiry-details/{vwedt?}/{intno?}', 'enquiryDetails')->name('enquiryDetails');
            Route::post('/save-enquiry', 'saveEnquiry')->name('saveEnquiry');
            Route::get('/enquiry-stat/{intno}/{actyn}', 'statEnquiry')->name('enquiry.stat');
            Route::get('/print-enquiry-list', 'printEnquiryList')->name('crm.printEnquiryList');
        });

        /* Enquiry Followup */
        Route::controller(EnquiryFollowupCntlr::class)->group(function () {
            Route::get('/enquiry-followup', 'enquiryFollowup')->name('enquiryFollowup');
            Route::get('/enquiry-followup-details/{vwedt?}/{intno?}', 'enquiryFollowupDetails')->name('enquiryFollowupDetails');
            Route::post('/save-enquiry-followup', 'saveEnquiryFollowup')->name('saveEnquiryFollowup');
            Route::get('/enquiry-followup-stat/{intno}/{actyn}', 'statEnquiryFollowup')->name('enquiryFollowup.stat');
            Route::get('/print-enquiry-followup-list', 'printEnquiryFollowupList')->name('crm.printEnquiryFollowupList');
        });

        /* Quotation */
        Route::controller(QuotationCntlr::class)->group(function () {
            Route::get('/quotation', 'quotation')->name('quotation');
            Route::get('/quotation-details/{vwedt?}/{intno?}', 'quotationDetails')->name('quotationDetails');
            Route::post('/save-quotation', 'saveQuotation')->name('saveQuotation');
            Route::get('/quotation-stat/{intno}/{actyn}', 'statQuotation')->name('quotation.stat');
            Route::get('/print-quotation-list', 'printQuotationList')->name('crm.printQuotationList');
        });

        /* Quotation Followup */
        Route::controller(QuotationFollowupCntlr::class)->group(function () {
            Route::get('/quotation-followup', 'quotationFollowup')->name('quotationFollowup');
            Route::get('/quotation-followup-details/{vwedt?}/{intno?}', 'quotationFollowupDetails')->name('quotationFollowupDetails');
            Route::post('/save-quotation-followup', 'saveQuotationFollowup')->name('saveQuotationFollowup');
            Route::get('/quotation-followup-stat/{intno}/{actyn}', 'statQuotationFollowup')->name('quotationFollowup.stat');
            Route::get('/print-quotation-followup-list', 'printQuotationFollowupList')->name('crm.printQuotationFollowupList');
        });

        /* Sales Order */
        Route::controller(SalesOrderCntlr::class)->group(function () {
            Route::get('/sales-order', 'salesOrder')->name('salesOrder');
            Route::get('/sales-order-details/{vwedt?}/{intno?}', 'salesOrderDetails')->name('salesOrderDetails');
            Route::post('/save-sales-order', 'saveSalesOrder')->name('saveSalesOrder');
            Route::get('/sales-order-stat/{intno}/{actyn}', 'statSalesOrder')->name('salesOrder.stat');
            Route::get('/print-sales-order-list', 'printSalesOrderList')->name('crm.printSalesOrderList');
        });

        /* Sales */
        Route::controller(SalesCntlr::class)->group(function () {
            Route::get('/sales', 'sales')->name('sales');
            Route::get('/sales-details/{vwedt?}/{intno?}', 'salesDetails')->name('salesDetails');
            Route::post('/save-sales', 'saveSales')->name('saveSales');
            Route::get('/sales-stat/{intno}/{actyn}', 'statSales')->name('sales.stat');
            Route::get('/print-sales-list', 'printSalesList')->name('crm.printSalesList');
        });

        /* Sales Return */
        Route::controller(SalesReturnCntlr::class)->group(function () {
            Route::get('/sales-return', 'salesReturn')->name('salesReturn');
            Route::get('/sales-return-details/{vwedt?}/{intno?}', 'salesReturnDetails')->name('salesReturnDetails');
            Route::post('/save-sales-return', 'saveSalesReturn')->name('saveSalesReturn');
            Route::get('/sales-return-stat/{intno}/{actyn}', 'statSalesReturn')->name('salesReturn.stat');
            Route::get('/print-sales-return-list', 'printSalesReturnList')->name('crm.printSalesReturnList');
        });

        /* Receipt */
        Route::controller(ReceiptCntlr::class)->group(function () {
            Route::get('/receipt', 'receipt')->name('receipt');
            Route::get('/receipt-details/{vwedt?}/{intno?}', 'receiptDetails')->name('receiptDetails');
            Route::post('/save-receipt', 'saveReceipt')->name('saveReceipt');
            Route::get('/receipt-stat/{intno}/{actyn}', 'statReceipt')->name('receipt.stat');
            Route::get('/print-receipt-list', 'printReceiptList')->name('crm.printReceiptList');
        });

        /* Receipt Followup */
        Route::controller(ReceiptFollowupCntlr::class)->group(function () {
            Route::get('/receipt-followup', 'receiptFollowup')->name('receiptFollowup');
            Route::get('/receipt-followup-details/{vwedt?}/{intno?}', 'receiptFollowupDetails')->name('receiptFollowupDetails');
            Route::post('/save-receipt-followup', 'saveReceiptFollowup')->name('saveReceiptFollowup');
            Route::get('/receipt-followup-stat/{intno}/{actyn}', 'statReceiptFollowup')->name('receiptFollowup.stat');
            Route::get('/print-receipt-followup-list', 'printReceiptFollowupList')->name('crm.printReceiptFollowupList');
        });

    });
    /* ============== || CRM || ================ */



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
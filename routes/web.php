<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{ AuthCntlr, CompanyCntlr };

use App\Http\Controllers\RawMaterialsInventory\{ DashboardCntlr, RawItemTypeCntlr, RawItemCntlr, StoreCntlr, SupplierCntlr, DepartmentCntlr, OpeningStkCntlr, PurchaseOrderCntlr, PurchaseCntlr, PurchaseReturnCntlr, IssueToDeptCntlr, ReturnFrmDeptCntlr, StockAdjCntlr };

use App\Http\Controllers\Production\{DashboardProductionCntlr, FinishedItemTypeCntlr,FinishedItemCntlr, ItemSizeCntlr, BomCntlr, MachineCntlr, MaintenanceTypeCntlr};

use App\Http\Controllers\CRM\{DashboardCrmCntlr, CustomerCntlr,LeadSourceCntlr,TermsConditionsCntlr,PriceListCntlr, EnquiryCntlr, EnquiryFollowupCntlr, QuotationCntlr, QuotationFollowupCntlr, SalesOrderCntlr, SalesCntlr, SalesReturnCntlr, ReceiptCntlr, ReceiptFollowupCntlr};

use App\Http\Controllers\Payroll\{ PayrollDashboardCntlr, ContractorCntlr, WorkerAdvanceCntlr, WorkerCntlr, ContractorBillCntlr };


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

        Route::get('/dashboard', [DashboardProductionCntlr::class, 'production'])
            ->name('production.dashboard');

        Route::controller(FinishedItemTypeCntlr::class)->group(function () {
            Route::get('/finished-item-type', 'finishedItemType')->name('finishedItemType');
            Route::get('/finished-item-type-details/{vwedt?}/{code?}', 'finishedItemTypeDetails')->name('finishedItemTypeDetails');
            Route::post('/save-finished-item-type', 'saveFinishedItemType')->name('saveFinishedItemType');
            Route::get('/finished-item-type-stat/{code}/{actyn}', 'statFinishedItemType')->name('finishedItemType.stat');
            Route::get('/print-finished-item-type-list', 'printFinishedItemTypeList')->name('production.printFinishedItemTypeList');
        });

        Route::controller(FinishedItemCntlr::class)->group(function () {
            Route::get('/finished-item', 'finishedItem')->name('finishedItem');
            Route::get('/finished-item-details/{vwedt?}/{code?}', 'finishedItemDetails')->name('finishedItemDetails');
            Route::post('/save-finished-item', 'saveFinishedItem')->name('saveFinishedItem');
            Route::get('/finished-item-stat/{code}/{actyn}', 'statFinishedItem')->name('finishedItem.stat');
            Route::get('/print-finished-item-list', 'printFinishedItemList')->name('production.printFinishedItemList');
        });

        Route::controller(ItemSizeCntlr::class)->group(function () {
            Route::get('/item-size', 'itemSize')->name('itemSize');
            Route::get('/item-size-details/{vwedt?}/{code?}', 'itemSizeDetails')->name('itemSizeDetails');
            Route::post('/save-item-size', 'saveItemSize')->name('saveItemSize');
            Route::get('/item-size-stat/{code}/{actyn}', 'statItemSize')->name('itemSize.stat');
            Route::get('/print-item-size-list', 'printItemSizeList')->name('production.printItemSizeList');
        });

        Route::controller(BomCntlr::class)->group(function () {
            Route::get('/bom', 'bom')->name('bom');
            Route::get('/bom-details/{vwedt?}/{code?}', 'bomDetails')->name('bomDetails');
            Route::post('/save-bom', 'saveBom')->name('saveBom');
            Route::get('/bom-stat/{code}/{actyn}', 'statBom')->name('bom.stat');
            Route::get('/print-bom-list', 'printBomList')->name('production.printBomList');
        });

        Route::controller(MachineCntlr::class)->group(function () {
            Route::get('/machine', 'machine')->name('machine');
            Route::get('/machine-details/{vwedt?}/{code?}', 'machineDetails')->name('machineDetails');
            Route::post('/save-machine', 'saveMachine')->name('saveMachine');
            Route::get('/machine-stat/{code}/{actyn}', 'statMachine')->name('machine.stat');
            Route::get('/print-machine-list', 'printMachineList')->name('production.printMachineList');
        });

        Route::controller(MaintenanceTypeCntlr::class)->group(function () {
            Route::get('/maintenance-type', 'maintenanceType')->name('maintenanceType');
            Route::get('/maintenance-type-details/{vwedt?}/{code?}', 'maintenanceTypeDetails')->name('maintenanceTypeDetails');
            Route::post('/save-maintenance-type', 'saveMaintenanceType')->name('saveMaintenanceType');
            Route::get('/maintenance-type-stat/{code}/{actyn}', 'statMaintenanceType')->name('maintenanceType.stat');
            Route::get('/print-maintenance-type-list', 'printMaintenanceTypeList')->name('production.printMaintenanceTypeList');
        });

    });
    /* ============== || PRODUCTION || ================ */


    /* ============== || CRM || ================ */
    Route::prefix('/crm')->group(function () {

        Route::get('/dashboard', [DashboardCrmCntlr::class, 'crm'])->name('crm.dashboard');

        Route::controller(CustomerCntlr::class)->group(function () {
            Route::get('/customer', 'customer')->name('customer');
            Route::get('/customer-details/{vwedt?}/{code?}', 'customerDetails')->name('customerDetails');
            Route::post('/save-customer', 'saveCustomer')->name('saveCustomer');
            Route::get('/customer-stat/{code}/{actyn}', 'statCustomer')->name('customer.stat');
            Route::get('/print-customer-list', 'printCustomerList')->name('crm.printCustomerList');
        });

        Route::controller(LeadSourceCntlr::class)->group(function () {
            Route::get('/lead-source', 'leadSource')->name('leadSource');
            Route::get('/lead-source-details/{vwedt?}/{code?}', 'leadSourceDetails')->name('leadSourceDetails');
            Route::post('/save-lead-source', 'saveLeadSource')->name('saveLeadSource');
            Route::get('/lead-source-stat/{code}/{actyn}', 'statLeadSource')->name('leadSource.stat');
            Route::get('/print-lead-source-list', 'printLeadSourceList')->name('crm.printLeadSourceList');
        });

        Route::controller(PriceListCntlr::class)->group(function () {
            Route::get('/price-list', 'priceList')->name('priceList');
            Route::get('/price-list-details/{vwedt?}/{code?}', 'priceListDetails')->name('priceListDetails');
            Route::post('/save-price-list', 'savePriceList')->name('savePriceList');
            Route::get('/price-list-stat/{code}/{actyn}', 'statPriceList')->name('priceList.stat');
            Route::get('/print-price-list', 'printPriceList')->name('crm.printPriceList');
        });

        Route::controller(TermsConditionsCntlr::class)->group(function () {
            Route::get('/terms-conditions', 'termsConditions')->name('termsConditions');
            Route::post('/save-terms-conditions', 'saveTermsConditions')->name('saveTermsConditions');
        });

        Route::controller(EnquiryCntlr::class)->group(function () {
            Route::get('/enquiry', 'enquiry')->name('enquiry');
            Route::get('/enquiry-details/{vwedt?}/{intno?}', 'enquiryDetails')->name('enquiryDetails');
            Route::post('/save-enquiry', 'saveEnquiry')->name('saveEnquiry');
            Route::get('/enquiry-stat/{intno}/{actyn}', 'statEnquiry')->name('enquiry.stat');
            Route::get('/print-enquiry-list', 'printEnquiryList')->name('crm.printEnquiryList');
        });

        Route::controller(EnquiryFollowupCntlr::class)->group(function () {
            Route::get('/enquiry-followup', 'enquiryFollowup')->name('enquiryFollowup');
            Route::get('/enquiry-followup-details/{vwedt?}/{intno?}', 'enquiryFollowupDetails')->name('enquiryFollowupDetails');
            Route::post('/save-enquiry-followup', 'saveEnquiryFollowup')->name('saveEnquiryFollowup');
            Route::get('/enquiry-followup-stat/{intno}/{actyn}', 'statEnquiryFollowup')->name('enquiryFollowup.stat');
            Route::get('/print-enquiry-followup-list', 'printEnquiryFollowupList')->name('crm.printEnquiryFollowupList');
        });

        Route::controller(QuotationCntlr::class)->group(function () {
            Route::get('/quotation', 'quotation')->name('quotation');
            Route::get('/quotation-details/{vwedt?}/{intno?}', 'quotationDetails')->name('quotationDetails');
            Route::post('/save-quotation', 'saveQuotation')->name('saveQuotation');
            Route::get('/quotation-stat/{intno}/{actyn}', 'statQuotation')->name('quotation.stat');
            Route::get('/print-quotation-list', 'printQuotationList')->name('crm.printQuotationList');
        });

        Route::controller(QuotationFollowupCntlr::class)->group(function () {
            Route::get('/quotation-followup', 'quotationFollowup')->name('quotationFollowup');
            Route::get('/quotation-followup-details/{vwedt?}/{intno?}', 'quotationFollowupDetails')->name('quotationFollowupDetails');
            Route::post('/save-quotation-followup', 'saveQuotationFollowup')->name('saveQuotationFollowup');
            Route::get('/quotation-followup-stat/{intno}/{actyn}', 'statQuotationFollowup')->name('quotationFollowup.stat');
            Route::get('/print-quotation-followup-list', 'printQuotationFollowupList')->name('crm.printQuotationFollowupList');
        });

        Route::controller(SalesOrderCntlr::class)->group(function () {
            Route::get('/sales-order', 'salesOrder')->name('salesOrder');
            Route::get('/sales-order-details/{vwedt?}/{intno?}', 'salesOrderDetails')->name('salesOrderDetails');
            Route::post('/save-sales-order', 'saveSalesOrder')->name('saveSalesOrder');
            Route::get('/sales-order-stat/{intno}/{actyn}', 'statSalesOrder')->name('salesOrder.stat');
            Route::get('/print-sales-order-list', 'printSalesOrderList')->name('crm.printSalesOrderList');
        });

        Route::controller(SalesCntlr::class)->group(function () {
            Route::get('/sales', 'sales')->name('sales');
            Route::get('/sales-details/{vwedt?}/{intno?}', 'salesDetails')->name('salesDetails');
            Route::post('/save-sales', 'saveSales')->name('saveSales');
            Route::get('/sales-stat/{intno}/{actyn}', 'statSales')->name('sales.stat');
            Route::get('/print-sales-list', 'printSalesList')->name('crm.printSalesList');
        });

        Route::controller(SalesReturnCntlr::class)->group(function () {
            Route::get('/sales-return', 'salesReturn')->name('salesReturn');
            Route::get('/sales-return-details/{vwedt?}/{intno?}', 'salesReturnDetails')->name('salesReturnDetails');
            Route::post('/save-sales-return', 'saveSalesReturn')->name('saveSalesReturn');
            Route::get('/sales-return-stat/{intno}/{actyn}', 'statSalesReturn')->name('salesReturn.stat');
            Route::get('/print-sales-return-list', 'printSalesReturnList')->name('crm.printSalesReturnList');
        });

        Route::controller(ReceiptCntlr::class)->group(function () {
            Route::get('/receipt', 'receipt')->name('receipt');
            Route::get('/receipt-details/{vwedt?}/{intno?}', 'receiptDetails')->name('receiptDetails');
            Route::post('/save-receipt', 'saveReceipt')->name('saveReceipt');
            Route::get('/receipt-stat/{intno}/{actyn}', 'statReceipt')->name('receipt.stat');
            Route::get('/print-receipt-list', 'printReceiptList')->name('crm.printReceiptList');
        });

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

        Route::prefix('/masters')->group(function(){
            Route::controller(RawItemTypeCntlr::class)->group(function(){
                Route::get('/raw-item-type', 'index')->name('rawMaterialsInventory.rawMaterialTypeList');
                Route::get('/print-raw-item-type-list', 'getprint')->name('rawMaterialsInventory.printRawItemTypeList');
                Route::get('/raw-item-type-details/{mode}/{code?}', 'getDetails')->name('rawMaterialsInventory.rawMaterialTypeDetails');
                Route::post('/save-raw-item-type', 'saveRawMaterialType')->name('rawMaterialsInventory.rawMaterialTypeSave');
                Route::get('/raw-item-type-stat-change/{code}/{aedl}', 'statRawMaterialType')->name('rawMaterialsInventory.rawMaterialTypeStatChange');
            });

            Route::controller(RawItemCntlr::class)->group(function(){
                Route::get('/raw-item', 'getList')->name('rawMaterialsInventory.rawItemList');
                Route::get('/print-raw-item-list', 'getprint')->name('rawMaterialsInventory.printRawItemList');
                Route::get('/raw-item-details/{mode}/{code?}', 'getDetails')->name('rawMaterialsInventory.rawItemDetails');
                Route::post('/save-raw-item', 'saveRawItem')->name('rawMaterialsInventory.rawItemSave');
                Route::get('/raw-item-stat-change/{code}/{aedl}', 'statRawItem')->name('rawMaterialsInventory.rawItemStatChange');
            });

            Route::controller(StoreCntlr::class)->group(function(){
                Route::get('/get-store-list', 'getList')->name('rawMaterialsInventory.storeList');
                Route::get('/print-store-list', 'getPrint')->name('rawMaterialsInventory.printStoreList');
                Route::get('/store-details/{mode}/{code?}', 'getDetails')->name('rawMaterialsInventory.storeDetails');
                Route::post('/save-store', 'saveStore')->name('rawMaterialsInventory.saveStore');
                Route::get('/store-stat-change', 'statStore')->name('rawMaterialsInventory.storeStatChange');
            });

            Route::controller(SupplierCntlr::class)->group(function(){
                Route::get('/supplier', 'getList')->name('rawMaterialsInventory.supplierList');
                Route::get('/print-supplier-list', 'getprint')->name('rawMaterialsInventory.printSupplierList');
                Route::get('/supplier-details/{mode}/{code?}', 'getDetails')->name('rawMaterialsInventory.supplierDetails');
                Route::post('/save-supplier', 'saveSupplier')->name('rawMaterialsInventory.supplierSave');
                Route::get('/supplier-stat-change/{code}/{aedl}', 'statSupplier')->name('rawMaterialsInventory.supplierStatChange');
            });

            Route::controller(DepartmentCntlr::class)->group(function(){
                Route::get('/department', 'getList')->name('rawMaterialsInventory.departmentList');
                Route::get('/print-department-list', 'getPrint')->name('rawMaterialsInventory.printDepartmentList');
                Route::get('/department-details/{mode}/{code?}', 'getDetails')->name('rawMaterialsInventory.departmentDetails');
                Route::post('/save-department', 'saveDepartment')->name('rawMaterialsInventory.Savedepartment');
                Route::get('/department-stat-change/{code}/{aedl}', 'statDepartment')->name('rawMaterialsInventory.departmentStatChange');
            });

            Route::controller(OpeningStkCntlr::class)->group(function(){
                Route::get('/get-opening-stock', 'getList')->name('rawMaterialsInventory.opStkList');
                Route::get('/print-opening-stock', 'getPrint')->name('rawMaterialsInventory.printOpStkList');
                Route::get('/opening-stock-details/{mode}/{code?}', 'getDetails')->name('rawMaterialsInventory.opStkDetails');
                Route::post('/save-opening-stock', 'saveOpStk')->name('rawMaterialsInventory.saveOpStk');
                Route::get('/opening-stock-stat-change/{code}/{aedl}', 'statOpStk')->name('rawMaterialsInventory.opStkStatChange');
            });
        });

        Route::prefix('/transactions')->group(function(){
            Route::controller(PurchaseOrderCntlr::class)->group(function(){
                Route::get('/get-purchase-order-list', 'getList')->name('rawMaterialsInventory.purchaseOrderList');
                Route::get('/print-purchase-order-list', 'getPrint')->name('rawMaterialsInventory.printPurchaseOrderList');
                Route::get('/purchase-order-details/{mode}/{code?}', 'getDetails')->name('rawMaterialsInventory.purchaseOrderDetails');
                Route::post('/save-Purchase-order', 'savePurchaseOrder')->name('rawMaterialsInventory.savePurchsaeOrder');
                Route::get('purchase-order-stat-change/{code}/{aedl}', 'statPurchaseOrder')->name('rawMaterialsInventory.statPurchaseOrder');
            });

            Route::controller(PurchaseCntlr::class)->group(function(){
                Route::get('/get-purchase-list', 'getList')->name('rawMaterialsInventory.purchaseList');
                Route::get('/print-purchase-list', 'getPrint')->name('rawMaterialsInventory.printPurchaseList');
                Route::get('/purchase-details/{mode}/{code?}', 'getDetails')->name('rawMaterialsInventory.purchaseDetails');
                Route::post('/save-purchase', 'savePurchase')->name('rawMaterialsInventory.savePurchase');
                Route::get('/purchase-stat-change/{code}/{aedl}', 'statPurchase')->name('rawMaterialsInventory.statPurchase');
            });

            Route::controller(PurchaseReturnCntlr::class)->group(function(){
                Route::get('/get-purchase-return-list', 'getList')->name('rawMaterialsInventory.purchaseRtnList');
                Route::get('/print-purchase-return-list', 'getPrint')->name('rawMaterialsInventory.printPurchaseRtnList');
                Route::get('/purchase-return-details/{mode}/{code?}', 'getDetails')->name('rawMaterialsInventory.purchaseRtnDetails');
            });

            Route::controller(IssueToDeptCntlr::class)->group(function(){
                Route::get('/get-issue-to-department-list', 'getList')->name('rawMaterialsInventory.issueToDeptList');
                Route::get('/print-issue-to-department-list', 'getPrint')->name('rawMaterialsInventory.printIssueToDeptList');
                Route::get('/issue-to-department-details/{mode}/{code?}', 'getDetails')->name('rawMaterialsInventory.issueToDeptDetails');
                Route::post('/save-issue-to-department', 'saveIssuetoDept')->name('rawMaterialsInventory.saveIssuetoDept');
                Route::get('/issue-to-department-stat-change/{code}/{aedl}', 'statIssueToDept')->name('rawMaterialsInventory.statIssueToDept');
            });

            Route::controller(ReturnFrmDeptCntlr::class)->group(function(){
                Route::get('/get-return-from-department-list', 'getList')->name('rawMaterialsInventory.rtnFrmDeptList');
                Route::get('/print-return-from-department-list', 'getPrint')->name('rawMaterialsInventory.printRtnFrmDeptList');
                Route::get('/return-from-department-details/{mode}/{code?}', 'getDetails')->name('rawMaterialsInventory.rtnFrmDeptDetails');
                Route::post('/save-return-from-department', 'saveRtnfrmDept')->name('rawMaterialsInventory.saveRtnfrmDept');
                Route::get('/return-from-department-stat-change/{code}/{aedl}', 'statRtnFrmDept')->name('rawMaterialsInventory.statRtnFrmDept');
            });

            Route::controller(StockAdjCntlr::class)->group(function(){
                Route::get('/get-stock-adjustment-list', 'getList')->name('rawMaterialsInventory.stkAdjList');
                Route::get('/print-stock-adjustment-list', 'getPrint')->name('rawMaterialsInventory.printStkAdjList');
                Route::get('/stock-adjustment-details/{mode}/{code?}', 'getDetails')->name('rawMaterialsInventory.stkAdjDetails');
                Route::post('/save-stock-adjustment', 'saveStkAdj')->name('rawMaterialsInventory.saveStkAdj');
                Route::get('/stock-adjustment-stat-change/{code}/{aedl}', 'statStkAdj')->name('rawMaterialsInventory.statStkAdj');
            });
        });
    });
    /* ============== || Raw Materials Inventory || ================ */


        /* ============== || PAYROLL || ================ */
    Route::prefix('/payroll')->group(function () {
        Route::get('/dashboard', [PayrollDashboardCntlr::class, 'payroll'])->name('payroll.dashboard');

        /* ============== || CONTRACTOR || ================ */
        Route::controller(ContractorCntlr::class)->group(function () {
            Route::get('/contractor', 'contractor')
                ->name('payroll.contractor');
            Route::get('/contractor-details/{vwedt?}/{code?}', 'contractorDetails')
                ->name('payroll.contractorDetails');
            Route::post('/save-contractor', 'saveContractor')
                ->name('payroll.saveContractor');
            Route::get('/contractor-stat/{code}/{actyn}', 'statContractor')
                ->name('payroll.contractor.stat');
            /* PRINT */
            Route::get('/print-contractor-list', 'printContractorList')
                ->name('payroll.printContractorList');
        });

        /* ============== || WORKER || ================ */
        Route::controller(WorkerCntlr::class)->group(function () {
            Route::get('/worker', 'worker')
                ->name('payroll.worker');
            Route::get('/worker-details/{vwedt?}/{code?}', 'workerDetails')
                ->name('payroll.workerDetails');
            Route::post('/save-worker', 'saveWorker')
                ->name('payroll.saveWorker');
            Route::get('/worker-stat/{code}/{actyn}', 'statWorker')
                ->name('payroll.worker.stat');
            /* PRINT */
            Route::get('/print-worker-list', 'printWorkerList')
                ->name('payroll.printWorkerList');
        });

        /* ============== || WORKER ADVANCE || ================ */
        Route::controller(WorkerAdvanceCntlr::class)->group(function () {
            Route::get('/worker-advance', 'workerAdvance')
                ->name('payroll.workerAdvance');
            Route::get('/worker-advance-details/{vwedt?}/{intno?}', 'workerAdvanceDetails')
                ->name('payroll.workerAdvanceDetails');
            Route::post('/save-worker-advance', 'saveWorkerAdvance')
                ->name('payroll.saveWorkerAdvance');
            Route::get('/worker-advance-stat/{intno}/{actyn}', 'statWorkerAdvance')
                ->name('payroll.workerAdvance.stat');
            /* PRINT */
            Route::get('/print-worker-advance-list', 'printWorkerAdvanceList')
                ->name('payroll.printWorkerAdvanceList');
        });

        /* ============== || CONTRACTOR BILL || ================ */
        Route::controller(ContractorBillCntlr::class)->group(function () {
            Route::get('/contractor-bill', 'contractorBill')
                ->name('payroll.contractorBill');
            Route::get('/contractor-bill-details/{vwedt?}/{intno?}', 'contractorBillDetails')
                ->name('payroll.contractorBillDetails');
            Route::post('/save-contractor-bill', 'saveContractorBill')
                ->name('payroll.saveContractorBill');
            Route::get('/contractor-bill-stat/{intno}/{actyn}', 'statContractorBill')
                ->name('payroll.contractorBill.stat');
            /* PRINT */
            Route::get('/print-contractor-bill-list', 'printContractorBillList')
                ->name('payroll.printContractorBillList');
        });

    });
    /* ============== || PAYROLL || ================ */

});
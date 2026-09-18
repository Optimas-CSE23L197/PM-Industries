@extends('layout.app', ['dept' => 'Raw Material Inventory'])

@section('page_title_link')
    {{ route('rawMaterialsInventory.purchaseRtnList') }}
@endsection

@section('page_titleH', 'Purchase Return')
@section('page_title', 'Details')

@section('content')

    @push('css')
        <style>
            .form-section-heading {
                display: flex;
                align-items: center;
                gap: 10px;
                margin: 4px 0 18px;
                font-size: 18px;
                font-weight: 600;
            }

            .form-section-heading i {
                font-size: 18px;
                width: 23px;
                text-align: center;
            }

            .form-section-heading span {
                line-height: 1;
            }
        </style>
    @endpush

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form id="purcRtnForm" method="POST">
                        @csrf

                        <!-- Purchase Details -->
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="form-section-heading">
                                    <i class="fa-solid fa-receipt"></i>
                                    <span>Purchase Details</span>
                                </div>
                            </div>

                            <label class="col-md-2">Purchase No.</label>
                            <div class="col-md-4">
                                <select name="" class="form-control form-control-sm select2" id="">
                                    <option value="" selected disabled>Select</option>
                                    <option value="">PURC/26-27/000001 - 01/01/2026 - Someone1</option>
                                    <option value="">PURC/26-27/000002 - 02/01/2026 - Someone2</option>
                                    <option value="">PURC/26-27/000003 - 03/01/2026 - Someone3</option>
                                </select>
                            </div>

                            <label class="col-md-2">Purchase Date</label>
                            <div class="col-md-4">
                                <input type="date" class="form-control form-control-sm date_today" readonly/>
                            </div>

                            <label class="col-md-2">Supplier</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control form-control-sm" readonly/>
                            </div>

                            <label class="col-md-2">Supplier Bill No.</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control form-control-sm" readonly/>
                            </div>

                            <label class="col-md-2">Supplier Bill Date</label>
                            <div class="col-md-4">
                                <input type="date" class="form-control form-control-sm date_today" readonly/>
                            </div>
                        </div>

                        <div class="col-12"><hr></div>

                        <!-- Charges -->
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="form-section-heading">
                                    <i class="fa-solid fa-list"></i>
                                    <span>Charges</span>
                                </div>
                            </div>

                            <label class="col-md-2">Local Conveyance</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control form-control-sm text-right"/>
                            </div>

                            <label class="col-md-2">Other Amount</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control form-control-sm text-right"/>
                            </div>
                        </div>

                        <div class="col-12"><hr></div>

                        <!-- Tax & Amount Details -->
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="form-section-heading">
                                    <i class="fa-solid fa-calculator"></i>
                                    <span>Tax &amp; Amount Details</span>
                                </div>
                            </div>

                            <label class="col-md-2">Gross Amount</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control form-control-sm text-right" disabled>
                            </div>

                            <label class="col-md-2">Discount</label>
                            <div class="col-md-4">
                                <div class="btn-group w-100">
                                    <input type="text" class="form-control form-control-sm text-right" placeholder="%">
                                    <input type="text" class="form-control form-control-sm text-right" placeholder="₹">
                                </div>
                            </div>

                            <label class="col-md-2">CGST</label>
                            <div class="col-md-4">
                                <div class="btn-group w-100">
                                    <input type="text" class="form-control form-control-sm text-right" placeholder="%"/>
                                    <input type="text" class="form-control form-control-sm text-right" placeholder="₹"/>
                                </div>
                            </div>

                            <label class="col-md-2">SGST</label>
                            <div class="col-md-4">
                                <div class="btn-group w-100">
                                    <input type="text" class="form-control form-control-sm text-right" placeholder="%"/>
                                    <input type="text" class="form-control form-control-sm text-right" placeholder="₹"/>
                                </div>
                            </div>

                            <label class="col-md-2">IGST</label>
                            <div class="col-md-4">
                                <div class="btn-group w-100">
                                    <input type="text" class="form-control form-control-sm text-right" placeholder="%"/>
                                    <input type="text" class="form-control form-control-sm text-right" placeholder="₹"/>
                                </div>
                            </div>

                            <label class="col-md-2">Others</label>
                            <div class="col-md-4">
                                <div class="btn-group w-100">
                                    <input type="text" class="form-control form-control-sm text-right" placeholder="%"/>
                                    <input type="text" class="form-control form-control-sm text-right" placeholder="₹"/>
                                </div>
                            </div>

                            <label class="col-md-2">Round Off</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control form-control-sm text-right"/>
                            </div>

                            <label class="col-md-2">Net Amount</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control form-control-sm text-right" readonly/>
                            </div>
                        </div>

                        <div class="col-12"><hr></div>

                        <!-- Payment Details -->
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="form-section-heading">
                                    <i class="fa-regular fa-credit-card"></i>
                                    <span>Payment Details</span>
                                </div>
                            </div>

                            <label class="col-md-2">Pay Mode</label>
                            <div class="col-md-4">
                                <select name="" class="form-control form-control-sm" id="">
                                    <option value="">Cash</option>
                                    <option value="">UPI</option>
                                    <option value="">Card</option>
                                </select>
                            </div>

                            <label class="col-md-2">Bank</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control form-control-sm">
                            </div>
                        </div>

                        <div class="col-12"><hr></div>

                        <!-- Remarks -->
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="form-section-heading">
                                    <i class="fa-solid fa-align-left"></i>
                                    <span>Remarks</span>
                                </div>
                            </div>

                            <label class="col-md-2">Narration</label>
                            <div class="col-md-4">
                                <textarea name="" class="form-control form-control-sm" rows="3" id=""></textarea>
                            </div>
                        </div>

                        <div class="col-12"><hr></div>

                        <!-- Item List -->
                        <div class="col-md-12 form-group" style="overflow: auto;">
                            <table class="table table-sm table-bordered text-xs">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width:30%">Item</th>
                                        <th style="width:10%">Serial No</th>
                                        <th style="width:10%;text-align:right;">Rate</th>
                                        <th style="width:10%;text-align:right;">P.Qty</th>
                                        <th style="width:10%;text-align:right;">R.Qty</th>
                                        <th style="width:10%;text-align:right;">Discount</th>
                                        <th style="width:10%;text-align:right;">GST</th>
                                        <th style="width:10%;text-align:right;">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Item 1</td>
                                        <td>012345</td>
                                        <td style="text-align:right;">1000.00</td>
                                        <td style="text-align:right;">10</td>
                                        <td><input type="text" class="form-control form-control-sm text-right"></td>
                                        <td style="text-align:right;">1000.00 (10%)</td>
                                        <td style="text-align:right;">1000.00 (18%)</td>
                                        <td style="text-align:right;">1000.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </form>
                    <button id="saveBtn" class="btn btn-sm btn-dark float-right"><i class="fas fa-save"></i> Save</button> 
                </div>
            </div>
        </div>
    </section>

@endsection
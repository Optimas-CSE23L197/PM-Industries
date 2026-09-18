@extends('layout.app', ['dept' => 'Raw Material Inventory'])

@section('page_title_link')
    {{ route('rawMaterialsInventory.purchaseList') }}
@endsection

@section('page_titleH', 'Purchase')
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
                    <form id="purchaseForm" method="POST">
                        @csrf

                        <input type="hidden" name="intno" id="intno" value="{{ $purc['intno'] }}"/>
                        <input type="hidden" name="activeyn" id="activeyn" value="{{ $purc['activeyn'] }}"/>

                        <!-- Purchase Details -->
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="form-section-heading">
                                    <i class="fa-solid fa-receipt"></i>
                                    <span>Purchase Details</span>
                                </div>
                            </div>

                            <label class="col-md-2" for="tranno">Purchase No.</label>
                            <div class="col-md-4">
                                <input type="text" name="tranno" id="tranno" class="form-control form-control-sm" value="{{ old('tranno', $purc['tranno'] ?? '') }}" readonly/>
                            </div>

                            <label class="col-md-2 required" for="trandt">Purchase Date</label>
                            <div class="col-md-4">
                                <input type="date" name="trandt" id="trandt" class="form-control form-control-sm {{ ($mode === 'new' || empty($ir['issue_date'])) ? 'date_today' : '' }}" value="{{ old('trandt', $purc['trandt'] ?? '') }}" required/>
                            </div>

                            <label class="col-md-2 required" for="partycd">Supplier</label>
                            <div class="col-md-4">
                                <select name="partycd" class="form-control form-control-sm select2" id="partycd" required>
                                    @if ($mode === 'new')
                                        <option value="" selected disabled>Select</option> 
                                    @elseif (!(collect($splr)->contains('code', $purc['partycd'])))
                                        <option value="" selected disabled>{{ $purc['supplier_name'] ?? '' }} (Supplier deactivated)</option>
                                    @endif

                                    @forelse ( $splr as $s )
                                        <option value="{{ $s['code'] }}" {{ (($purc['partycd'] ?? 0) === ($s['code'] ?? 0)) ? 'selected' : '' }}>{{ $s['name'] }}</option>
                                    @empty
                                        <option value="" selected disabled>No active supplier found</option>
                                    @endforelse
                                </select>
                            </div>

                            <label class="col-md-2 required" for="partybillno">Supplier Bill No.</label>
                            <div class="col-md-4">
                                <input type="text" name="partybillno" id="partybillno" value="{{ old('partybillno', $purc['partybillno'] ?? '') }}" class="form-control form-control-sm" required/>
                            </div>

                            <label class="col-md-2 required" for="partybilldt">Supplier Bill Date</label>
                            <div class="col-md-4">
                                <input type="date" name="partybilldt" id="partybilldt" value="{{ old('partybilldt', $purc['partybilldt'] ?? '') }}" class="form-control form-control-sm {{ ($mode === 'new' || empty($ir['issue_date'])) ? 'date_today' : '' }}" required/>
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

                            <label class="col-md-2" for="localconvamt">Local Conveyance</label>
                            <div class="col-md-4">
                                <input type="text" name="localconvamt" id="localconvamt" value="{{ old('localconvamt', $purc['localconvamt'] ?? '') }}" class="form-control form-control-sm text-right">
                            </div>

                            <label class="col-md-2" for="otheramt">Other Amount</label>
                            <div class="col-md-4">
                                <input type="text" name="otheramt" id="otheramt" value="{{ old('otheramt', $purc['otheramt'] ?? '') }}" class="form-control form-control-sm text-right"/>
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
                                <input type="text" name="" id="" value="{{ old('', $purc[''] ?? '') }}" class="form-control form-control-sm text-right" readonly/>
                            </div>

                            <label class="col-md-2">Discount</label>
                            <div class="col-md-4">
                                <div class="btn-group w-100">
                                    <input type="number" step="0.01" min="0" name="discper" id="discper" value="{{ old('discper', $purc['discper'] ?? '') }}" class="form-control form-control-sm text-right" placeholder="%"/>
                                    <input type="number" step="0.01" min="0" name="discamt" id="discamt" value="{{ old('discamt', $purc['discamt'] ?? '') }}" class="form-control form-control-sm text-right" placeholder="₹"/>
                                </div>
                            </div>

                            <label class="col-md-2">CGST</label>
                            <div class="col-md-4">
                                <div class="btn-group w-100">
                                    <input type="number" step="0.01" min="0"  name="cgstper" id="cgstper" value="{{ old('cgstper', $purc['cgstper'] ?? '') }}" class="form-control form-control-sm text-right" placeholder="%"/>
                                    <input type="number" step="0.01" min="0"  name="cgstamt" id="cgstamt" value="{{ old('cgstamt', $purc['cgstamt'] ?? '') }}" class="form-control form-control-sm text-right" placeholder="₹"/>
                                </div>
                            </div>

                            <label class="col-md-2">SGST</label>
                            <div class="col-md-4">
                                <div class="btn-group w-100">
                                    <input type="number" step="0.01" min="0"  name="sgstper" id="sgstper" value="{{ old('sgstper', $purc['sgstper'] ?? '') }}" class="form-control form-control-sm text-right" placeholder="%"/>
                                    <input type="number" step="0.01" min="0"  name="sgstamt" id="sgstamt" value="{{ old('sgstamt', $purc['sgstamt'] ?? '') }}" class="form-control form-control-sm text-right" placeholder="₹"/>
                                </div>
                            </div>

                            <label class="col-md-2">IGST</label>
                            <div class="col-md-4">
                                <div class="btn-group w-100">
                                    <input type="number" step="0.01" min="0"  name="igstper" id="igstper" value="{{ old('igstper', $purc['igstper'] ?? '') }}" class="form-control form-control-sm text-right" placeholder="%"/>
                                    <input type="number" step="0.01" min="0"  name="igstamt" id="igstamt" value="{{ old('igstamt', $purc['igstamt'] ?? '') }}" class="form-control form-control-sm text-right" placeholder="₹"/>
                                </div>
                            </div>

                            <label class="col-md-2">Others</label>
                            <div class="col-md-4">
                                <div class="btn-group w-100">
                                    <input type="number" step="0.01" min="0"  name="othersper" id="othersper" value="{{ old('othersper', $purc['othersper'] ?? '') }}" class="form-control form-control-sm text-right" placeholder="%"/>
                                    <input type="number" step="0.01" min="0"  name="othersamt" id="othersamt" value="{{ old('othersamt', $purc['othersamt'] ?? '') }}" class="form-control form-control-sm text-right" placeholder="₹"/>
                                </div>
                            </div>

                            <label class="col-md-2">Round Off</label>
                            <div class="col-md-4">
                                <input type="number" min="0" step="0.01" name="rndoff" id="rndoff" value="{{ old('rndoff', $purc['rndoff'] ?? '') }}" class="form-control form-control-sm text-right"/>
                            </div>

                            <label class="col-md-2">Net Amount</label>
                            <div class="col-md-4">
                                <input type="number" min="0" step="0.01" name="" id="" value="{{ old('', $purc[''] ?? '') }}" class="form-control form-control-sm text-right" readonly/>
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
                                <select name="modeofpay" class="form-control form-control-sm" id="modeofpay">
                                    <option value="C" {{ ($purc['modeofpay'] ?? '') === 'C' ? 'selected' : '' }}>Cash</option>
                                    <option value="U" {{ ($purc['modeofpay'] ?? '') === 'U' ? 'selected' : '' }}>UPI</option>
                                    <option value="D" {{ ($purc['modeofpay'] ?? '') === 'D' ? 'selected' : '' }}>Card</option>
                                </select>
                            </div>

                            <label class="col-md-2">Bank</label>
                            <div class="col-md-4">
                                <input type="text"  name="bankcd" id="bankcd" value="{{ old('bankcd', $purc['bankcd'] ?? '') }}" class="form-control form-control-sm"/>
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
                                <textarea name="narration" class="form-control form-control-sm" rows="3" id="narration">{{ old('narration', $purc['narration'] ?? '') }}</textarea>
                            </div>
                        </div>
                        <div class="col-12"><hr></div>
                        <!-- Item List -->
                        <div class="col-md-12 form-group" style="overflow:auto;">
                            <table class="table table-sm table-bordered text-xs">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width:30%">Item</th>
                                        <th style="width:10%">Serial No</th>
                                        <th style="width:10%;text-align:right;">Rate</th>
                                        <th style="width:10%;text-align:right;">Qty</th>
                                        <th style="width:10%;text-align:right;">Discount</th>
                                        <th style="width:10%;text-align:right;">GST</th>
                                        <th style="width:10%;text-align:right;">Amount</th>
                                        <th style="width:10%;text-align:center;" class="actionCol">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td colspan="8">
                                            <button class="btn btn-sm btn-secondary btn-block" data-toggle="modal" data-target="#purchaseModal">
                                                <i class="fas fa-plus-circle"></i> Add Item 
                                            </button>
                                        </td>
                                    </tr>
                                    @forelse ( $purc['items'] as $itm )
                                        <tr>
                                            <td>Item 1</td>
                                            <td>012345</td>
                                            <td style="text-align:right;">1000.00</td>
                                            <td style="text-align:right;">10</td>
                                            <td style="text-align:right;">1000.00 (10%)</td>
                                            <td style="text-align:right;">1000.00 (18%)</td>
                                            <td style="text-align:right;">1000.00</td>
                                            <td class="dropdown text-center actionCol">
                                                <i class="fas fa-bars ml-2 mr-1" data-toggle="dropdown" href="#"
                                                    style="cursor:pointer"></i>
                                                <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                                    <a href="#" class="dropdown-item">
                                                        <div class="media">
                                                            <div class="media-body">
                                                                <p>Edit</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a href="#" class="dropdown-item">
                                                        <div class="media">
                                                            <div class="media-body">
                                                                <p>Delete</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr> 
                                    @empty
                                        <tr></tr>
                                    @endforelse
                                    
                                </tbody>
                            </table>
                        </div>
                        <button id="saveBtn" class="btn btn-sm btn-dark float-right">
                            <i class="fas fa-save"></i> Save 
                        </button> 
                    </form>
                </div>
            </div>
        </div>
    </section>

    @include('rawMaterialsInventory.transactions.purchase.popup.itemDetails', ['item' => $rawItm])

    @push('js')
        <script>
            const mode = @json($mode);
            $(function(){
                if(mode === 'view'){
                    $('input, textarea, select').attr('disabled', true);
                    $('#saveBtn, .actionCol').hide();
                }
            });
        </script>
    @endpush

@endsection
@extends('layout.app', ['dept' => 'CRM'])
@section('page_title_link', route('sales'))
@section('page_titleH', 'Sales')
@section('page_title', 'Details')

@section('content')

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
    </style>

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form id="salesForm" method="post">
                        @csrf
                        <input type="hidden" name="intno" value="{{ $sales['intno'] ?? 0 }}"/>

                        {{-- ============ SALES DETAILS ============ --}}
                        <div class="col-md-12">
                            <div class="form-section-heading">
                                <i class="fa-solid fa-receipt"></i>
                                <span>Sales Details</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2">Sales No.</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control form-control-sm" disabled
                                       value="{{ $sales['tranno'] ?? '' }}">
                            </div>

                            <label for="trandt" class="col-md-2 required">Sales Date</label>
                            <div class="col-md-4">
                                <input type="date" name="trandt" id="trandt"
                                       class="form-control form-control-sm date_today" required autofocus
                                       value="{{ old('trandt', isset($sales['trandt']) && $sales['trandt'] ? date('Y-m-d', strtotime($sales['trandt'])) : date('Y-m-d')) }}"
                                       {{ $vwedt == 1 ? 'readonly' : '' }}/>
                            </div>

                            <label for="qutintno" class="col-md-2 required">Quotation</label>
                            <div class="col-md-4">
                                <select name="qutintno" id="qutintno"
                                        class="form-control form-control-sm select2" required
                                        {{ ($vwedt == 1 || $vwedt == 3) ? 'disabled' : '' }}>
                                    <option value="" selected disabled>Select</option>
                                    @foreach($quotations as $q)
                                        <option value="{{ $q['intno'] }}"
                                            data-partycd="{{ $q['customercd'] ?? '' }}"
                                            data-customer="{{ $q['customer_name'] ?? '' }}"
                                            {{ ($sales['qutintno'] ?? '') == $q['intno'] ? 'selected' : '' }}>
                                            {{ $q['quotation_no'] ?? '' }} - {{ $q['customer_name'] ?? '' }} - {{ $q['quotation_date'] ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @if($vwedt == 1 || $vwedt == 3)
                                    <input type="hidden" name="qutintno" value="{{ $sales['qutintno'] ?? '' }}">
                                @endif
                            </div>

                            <label class="col-md-2">Customer</label>
                            <div class="col-md-4">
                                <input type="text" id="customer_name" class="form-control form-control-sm" disabled
                                       value="{{ $sales['customer_name'] ?? $sales['party_name'] ?? '' }}">
                                <input type="hidden" name="partycd" id="partycd" value="{{ $sales['partycd'] ?? '' }}">
                            </div>
                        </div>

                        <div class="col-12"><hr></div>

                        {{-- ============ CHARGES ============ --}}
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="form-section-heading">
                                    <i class="fa-solid fa-list"></i>
                                    <span>Charges</span>
                                </div>
                            </div>

                            <label class="col-md-2">Local Conveyance</label>
                            <div class="col-md-4">
                                <input type="number" step="0.01" name="localconvamt" id="localconvamt"
                                       class="form-control form-control-sm text-right"
                                       value="{{ old('localconvamt', $sales['localconvamt'] ?? 0) }}"
                                       {{ $vwedt == 1 ? 'readonly' : '' }}/>
                            </div>

                            <label class="col-md-2">Other Amount</label>
                            <div class="col-md-4">
                                <input type="number" step="0.01" name="otheramt" id="otheramt"
                                       class="form-control form-control-sm text-right"
                                       value="{{ old('otheramt', $sales['otheramt'] ?? 0) }}"
                                       {{ $vwedt == 1 ? 'readonly' : '' }}/>
                            </div>
                        </div>

                        <div class="col-12"><hr></div>

                        {{-- ============ TAX & AMOUNT ============ --}}
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="form-section-heading">
                                    <i class="fa-solid fa-calculator"></i>
                                    <span>Tax &amp; Amount Details</span>
                                </div>
                            </div>

                            <label class="col-md-2">Gross Amount</label>
                            <div class="col-md-4">
                                <input type="number" step="0.01" name="basic" id="basic"
                                       class="form-control form-control-sm text-right"
                                       value="{{ old('basic', $sales['basic'] ?? 0) }}"
                                       {{ $vwedt == 1 ? 'readonly' : '' }}/>
                            </div>

                            <label class="col-md-2">Discount</label>
                            <div class="col-md-4">
                                <div class="btn-group w-100">
                                    <input type="number" step="0.01" name="discper" id="discper"
                                           class="form-control form-control-sm text-right" placeholder="%"
                                           value="{{ old('discper', $sales['discper'] ?? 0) }}"
                                           {{ $vwedt == 1 ? 'readonly' : '' }}/>
                                    <input type="number" step="0.01" name="discamt" id="discamt"
                                           class="form-control form-control-sm text-right" placeholder="₹"
                                           value="{{ old('discamt', $sales['discamt'] ?? 0) }}"
                                           {{ $vwedt == 1 ? 'readonly' : '' }}/>
                                </div>
                            </div>

                            <label class="col-md-2">CGST</label>
                            <div class="col-md-4">
                                <div class="btn-group w-100">
                                    <input type="number" step="0.01" name="cgstper" id="cgstper"
                                           class="form-control form-control-sm text-right" placeholder="%"
                                           value="{{ old('cgstper', $sales['cgstper'] ?? 0) }}"
                                           {{ $vwedt == 1 ? 'readonly' : '' }}/>
                                    <input type="number" step="0.01" name="cgstamt" id="cgstamt"
                                           class="form-control form-control-sm text-right" placeholder="₹"
                                           value="{{ old('cgstamt', $sales['cgstamt'] ?? 0) }}"
                                           {{ $vwedt == 1 ? 'readonly' : '' }}/>
                                </div>
                            </div>

                            <label class="col-md-2">SGST</label>
                            <div class="col-md-4">
                                <div class="btn-group w-100">
                                    <input type="number" step="0.01" name="sgstper" id="sgstper"
                                           class="form-control form-control-sm text-right" placeholder="%"
                                           value="{{ old('sgstper', $sales['sgstper'] ?? 0) }}"
                                           {{ $vwedt == 1 ? 'readonly' : '' }}/>
                                    <input type="number" step="0.01" name="sgstamt" id="sgstamt"
                                           class="form-control form-control-sm text-right" placeholder="₹"
                                           value="{{ old('sgstamt', $sales['sgstamt'] ?? 0) }}"
                                           {{ $vwedt == 1 ? 'readonly' : '' }}/>
                                </div>
                            </div>

                            <label class="col-md-2">IGST</label>
                            <div class="col-md-4">
                                <div class="btn-group w-100">
                                    <input type="number" step="0.01" name="igstper" id="igstper"
                                           class="form-control form-control-sm text-right" placeholder="%"
                                           value="{{ old('igstper', $sales['igstper'] ?? 0) }}"
                                           {{ $vwedt == 1 ? 'readonly' : '' }}/>
                                    <input type="number" step="0.01" name="igstamt" id="igstamt"
                                           class="form-control form-control-sm text-right" placeholder="₹"
                                           value="{{ old('igstamt', $sales['igstamt'] ?? 0) }}"
                                           {{ $vwedt == 1 ? 'readonly' : '' }}/>
                                </div>
                            </div>

                            <label class="col-md-2">Others</label>
                            <div class="col-md-4">
                                <div class="btn-group w-100">
                                    <input type="number" step="0.01" name="othersper" id="othersper"
                                           class="form-control form-control-sm text-right" placeholder="%"
                                           value="{{ old('othersper', $sales['othersper'] ?? 0) }}"
                                           {{ $vwedt == 1 ? 'readonly' : '' }}/>
                                    <input type="number" step="0.01" name="othersamt" id="othersamt"
                                           class="form-control form-control-sm text-right" placeholder="₹"
                                           value="{{ old('othersamt', $sales['othersamt'] ?? 0) }}"
                                           {{ $vwedt == 1 ? 'readonly' : '' }}/>
                                </div>
                            </div>

                            <label class="col-md-2">Round Off</label>
                            <div class="col-md-4">
                                <input type="number" step="0.01" name="rndoff" id="rndoff"
                                       class="form-control form-control-sm text-right"
                                       value="{{ old('rndoff', $sales['rndoff'] ?? 0) }}"
                                       {{ $vwedt == 1 ? 'readonly' : '' }}/>
                            </div>

                            <label class="col-md-2">Net Amount</label>
                            <div class="col-md-4">
                                <input type="text" id="net_amount" class="form-control form-control-sm text-right" disabled
                                       value="{{ $sales['basic'] ?? 0 }}"/>
                            </div>
                        </div>

                        <div class="col-12"><hr></div>

                        {{-- ============ PAYMENT DETAILS ============ --}}
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="form-section-heading">
                                    <i class="fa-regular fa-credit-card"></i>
                                    <span>Payment Details</span>
                                </div>
                            </div>

                            <label class="col-md-2">Pay Mode</label>
                            <div class="col-md-4">
                                <select name="modeofpay" id="modeofpay" class="form-control form-control-sm"
                                        {{ $vwedt == 1 ? 'disabled' : '' }}>
                                    <option value="C"  {{ ($sales['modeofpay'] ?? 'C') == 'C'  ? 'selected' : '' }}>Cash</option>
                                    <option value="U"  {{ ($sales['modeofpay'] ?? '') == 'U'  ? 'selected' : '' }}>UPI</option>
                                    <option value="B"  {{ ($sales['modeofpay'] ?? '') == 'B'  ? 'selected' : '' }}>Bank</option>
                                    <option value="CH" {{ ($sales['modeofpay'] ?? '') == 'CH' ? 'selected' : '' }}>Cheque</option>
                                </select>
                                @if($vwedt == 1)
                                    <input type="hidden" name="modeofpay" value="{{ $sales['modeofpay'] ?? 'C' }}">
                                @endif
                            </div>

                            <label class="col-md-2">Bank</label>
                            <div class="col-md-4">
                                <input type="text" name="bankcd" id="bankcd"
                                       class="form-control form-control-sm"
                                       value="{{ old('bankcd', $sales['bankcd'] ?? '') }}"
                                       {{ $vwedt == 1 ? 'readonly' : '' }}/>
                            </div>
                        </div>

                        <div class="col-12"><hr></div>

                        {{-- ============ REMARKS ============ --}}
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="form-section-heading">
                                    <i class="fa-solid fa-align-left"></i>
                                    <span>Remarks</span>
                                </div>
                            </div>

                            <label class="col-md-2">Narration</label>
                            <div class="col-md-4">
                                <textarea name="narration" id="narration" rows="3"
                                          class="form-control form-control-sm"
                                          {{ $vwedt == 1 ? 'readonly' : '' }}>{{ old('narration', $sales['narration'] ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="col-12"><hr></div>

                        {{-- ============ ITEM LIST ============ --}}
                        <div class="col-md-12 form-group" style="overflow:auto;">
                            <table class="table table-sm table-bordered text-xs" id="itemsTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width:30%">Item</th>
                                        <th style="width:10%">Serial No</th>
                                        <th style="width:10%; text-align:right;">Rate</th>
                                        <th style="width:10%; text-align:right;">Qty</th>
                                        <th style="width:10%; text-align:right;">Discount</th>
                                        <th style="width:10%; text-align:right;">GST</th>
                                        <th style="width:10%; text-align:right;">Amount</th>
                                        @if($vwedt != 1)
                                        <th style="width:10%; text-align:center;">Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($vwedt != 1)
                                    <tr>
                                        <td colspan="8">
                                            <button type="button" class="btn btn-sm btn-secondary btn-block" id="addItemBtn"
                                                    data-toggle="modal" data-target="#itemModal">
                                                <i class="fas fa-plus-circle"></i> Add Item
                                            </button>
                                        </td>
                                    </tr>
                                    @endif

                                    @if(isset($sales['items']) && is_array($sales['items']))
                                        @foreach($sales['items'] as $index => $item)
                                            <tr class="item-row">
                                                <td>
                                                    {{ $item['raw_item_name'] ?? $item['finished_item_name'] ?? '' }}
                                                    <input type="hidden" name="items[{{ $index }}][itemcd]" value="{{ $item['itemcd'] ?? '' }}">
                                                </td>
                                                <td>
                                                    {{ $item['serialno'] ?? '' }}
                                                    <input type="hidden" name="items[{{ $index }}][serialno]" value="{{ $item['serialno'] ?? '' }}">
                                                </td>
                                                <td style="text-align:right;">
                                                    {{ number_format((float)($item['rate'] ?? 0), 2) }}
                                                    <input type="hidden" name="items[{{ $index }}][rate]" value="{{ $item['rate'] ?? 0 }}">
                                                </td>
                                                <td style="text-align:right;">
                                                    {{ rtrim(rtrim(number_format((float)($item['qty'] ?? 0), 3, '.', ''), '0'), '.') }}
                                                    <input type="hidden" name="items[{{ $index }}][qty]" value="{{ $item['qty'] ?? 0 }}">
                                                </td>
                                                <td style="text-align:right;">
                                                    {{ number_format((float)($item['discamt'] ?? 0), 2) }}
                                                    ({{ $item['discper'] ?? 0 }}%)
                                                    <input type="hidden" name="items[{{ $index }}][discper]" value="{{ $item['discper'] ?? 0 }}">
                                                    <input type="hidden" name="items[{{ $index }}][discamt]" value="{{ $item['discamt'] ?? 0 }}">
                                                </td>
                                                <td style="text-align:right;">
                                                    {{ number_format((float)($item['cgstamt'] ?? 0) + (float)($item['sgstamt'] ?? 0), 2) }}
                                                    ({{ $item['cgstper'] ?? 0 }}%)
                                                    <input type="hidden" name="items[{{ $index }}][cgstper]" value="{{ $item['cgstper'] ?? 0 }}">
                                                    <input type="hidden" name="items[{{ $index }}][cgstamt]" value="{{ $item['cgstamt'] ?? 0 }}">
                                                    <input type="hidden" name="items[{{ $index }}][sgstper]" value="{{ $item['sgstper'] ?? 0 }}">
                                                    <input type="hidden" name="items[{{ $index }}][sgstamt]" value="{{ $item['sgstamt'] ?? 0 }}">
                                                    <input type="hidden" name="items[{{ $index }}][igstper]" value="{{ $item['igstper'] ?? 0 }}">
                                                    <input type="hidden" name="items[{{ $index }}][igstamt]" value="{{ $item['igstamt'] ?? 0 }}">
                                                </td>
                                                <td style="text-align:right;">
                                                    {{ number_format((float)($item['amount'] ?? 0), 2) }}
                                                    <input type="hidden" name="items[{{ $index }}][amount]" value="{{ $item['amount'] ?? 0 }}">
                                                </td>
                                                @if($vwedt != 1)
                                                <td class="dropdown text-center">
                                                    <i class="fas fa-bars ml-2 mr-1" data-toggle="dropdown" href="#" style="cursor:pointer"></i>
                                                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                                        <a href="#" class="dropdown-item edit-item-row" data-index="{{ $index }}"><p>Edit</p></a>
                                                        <div class="dropdown-divider"></div>
                                                        <a href="#" class="dropdown-item delete-item-row" data-index="{{ $index }}"><p>Delete</p></a>
                                                    </div>
                                                </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <button type="submit" id="saveBtn" class="btn btn-sm btn-dark float-right"
                                {{ $vwedt == 1 ? 'hidden' : '' }}>
                            <i class="fas fa-save mr-1"></i>
                            {{ $vwedt == 2 ? 'Update' : 'Save' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ============ ITEM MODAL ============ --}}
        <div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header py-2 bg-dark text-white">
                        <h6 class="modal-title font-weight-bold">Item Details</h6>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <label class="col-md-2 required">Item</label>
                            <div class="col-md-4">
                                <select id="modal_itemcd" class="form-control form-control-sm select2-modal">
                                    <option value="" selected disabled>Select</option>
                                    @foreach($items as $it)
                                        <option value="{{ $it['code'] }}" data-name="{{ $it['name'] }}">{{ $it['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <label class="col-md-2">Serial No.</label>
                            <div class="col-md-4">
                                <input type="text" id="modal_serialno" class="form-control form-control-sm text-right">
                            </div>

                            <label class="col-md-2 required">Quantity</label>
                            <div class="col-md-4">
                                <input type="number" step="0.01" id="modal_qty" class="form-control form-control-sm text-right" required>
                            </div>

                            <label class="col-md-2 required">Rate</label>
                            <div class="col-md-4">
                                <input type="number" step="0.01" id="modal_rate" class="form-control form-control-sm text-right" required>
                            </div>

                            <label class="col-md-2">Discount</label>
                            <div class="col-md-4">
                                <div class="btn-group w-100">
                                    <input type="number" step="0.01" id="modal_discper" class="form-control form-control-sm text-right" placeholder="%">
                                    <input type="number" step="0.01" id="modal_discamt" class="form-control form-control-sm text-right" placeholder="₹">
                                </div>
                            </div>

                            <label class="col-md-2">SGST</label>
                            <div class="col-md-4">
                                <div class="btn-group w-100">
                                    <input type="number" step="0.01" id="modal_sgstper" class="form-control form-control-sm text-right" placeholder="%">
                                    <input type="number" step="0.01" id="modal_sgstamt" class="form-control form-control-sm text-right" placeholder="₹">
                                </div>
                            </div>

                            <label class="col-md-2">CGST</label>
                            <div class="col-md-4">
                                <div class="btn-group w-100">
                                    <input type="number" step="0.01" id="modal_cgstper" class="form-control form-control-sm text-right" placeholder="%">
                                    <input type="number" step="0.01" id="modal_cgstamt" class="form-control form-control-sm text-right" placeholder="₹">
                                </div>
                            </div>

                            <label class="col-md-2">IGST</label>
                            <div class="col-md-4">
                                <div class="btn-group w-100">
                                    <input type="number" step="0.01" id="modal_igstper" class="form-control form-control-sm text-right" placeholder="%">
                                    <input type="number" step="0.01" id="modal_igstamt" class="form-control form-control-sm text-right" placeholder="₹">
                                </div>
                            </div>

                            <label class="col-md-2">Amount</label>
                            <div class="col-md-4">
                                <input type="text" id="modal_amount" class="form-control form-control-sm text-right" disabled>
                            </div>

                            <label class="col-md-2">Item Description</label>
                            <div class="col-md-4">
                                <textarea id="modal_itemdescr" class="form-control form-control-sm" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer py-1">
                        <button type="button" class="btn btn-sm btn-dark" id="modalSaveBtn">
                            <i class="fas fa-save mr-1"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('js')
<script>
    $(document).ready(function () {
        $('.select2').select2();
        $('.select2-modal').select2({ dropdownParent: $('#itemModal') });

        let rowIndex     = {{ isset($sales['items']) && is_array($sales['items']) ? count($sales['items']) : 0 }};
        let editRowIndex = -1;
        let isManualRndoff = false;

        function toNum(val) {
            var n = parseFloat(val);
            return isNaN(n) ? 0 : n;
        }
        function round2(n) {
            return Math.round((n + Number.EPSILON) * 100) / 100;
        }

        $('#qutintno').on('change', function () {
            var $opt = $(this).find('option:selected');
            $('#customer_name').val($opt.data('customer') || '');
            $('#partycd').val($opt.data('partycd') || '');
        });
        if ($('#qutintno').val()) $('#qutintno').trigger('change');

        // User typed rndoff manually, so don't auto-overwrite it below
        $('#rndoff').on('input', function () { isManualRndoff = true; });

        function calculateTotals() {
            var gross     = toNum($('#basic').val());
            var localConv = toNum($('#localconvamt').val());
            var otherAmt  = toNum($('#otheramt').val());

            // Discount and GST apply on gross only, charges are added after
            var taxableBase = gross;

            var discPer = toNum($('#discper').val());
            var discAmt = toNum($('#discamt').val());

            if (discPer > 0) {
                discAmt = round2((taxableBase * discPer) / 100);
                $('#discamt').val(discAmt);
            } else if (discAmt > 0) {
                discPer = taxableBase > 0 ? round2((discAmt / taxableBase) * 100) : 0;
                $('#discper').val(discPer);
            }

            var afterDiscount = taxableBase - discAmt;

            function applyTax(perId, amtId) {
                var per = toNum($(perId).val());
                var amt = toNum($(amtId).val());
                if (per > 0) {
                    amt = round2((afterDiscount * per) / 100);
                    $(amtId).val(amt);
                } else if (amt > 0) {
                    per = afterDiscount > 0 ? round2((amt / afterDiscount) * 100) : 0;
                    $(perId).val(per);
                }
                return amt;
            }

            var cgstAmt   = applyTax('#cgstper',   '#cgstamt');
            var sgstAmt   = applyTax('#sgstper',   '#sgstamt');
            var igstAmt   = applyTax('#igstper',   '#igstamt');
            var othersAmt = applyTax('#othersper', '#othersamt');

            // Local conveyance and other charges added after tax, not part of taxable base
            var subTotal = afterDiscount + cgstAmt + sgstAmt + igstAmt + othersAmt + localConv + otherAmt;

            var manualRnd = toNum($('#rndoff').val());
            var rndoff, roundedTotal;
            if (isManualRndoff && manualRnd !== 0) {
                rndoff = manualRnd;
                roundedTotal = subTotal + rndoff;
            } else {
                roundedTotal = Math.round(subTotal);
                rndoff = round2(roundedTotal - subTotal);
                $('#rndoff').val(rndoff);
            }

            var netAmount = round2(roundedTotal);
            $('#net_amount').val(netAmount.toFixed(2));
            return netAmount;
        }

        var calcInputs = [
            '#basic', '#localconvamt', '#otheramt',
            '#discper', '#discamt',
            '#cgstper', '#cgstamt',
            '#sgstper', '#sgstamt',
            '#igstper', '#igstamt',
            '#othersper', '#othersamt',
            '#rndoff'
        ];
        $(calcInputs.join(',')).on('input change', calculateTotals);

        $('#discper').on('input', function () { if (toNum($(this).val()) > 0) $('#discamt').val(0); });
        $('#discamt').on('input', function () { if (toNum($(this).val()) > 0) $('#discper').val(0); });

        ['cgst', 'sgst', 'igst', 'others'].forEach(function (tax) {
            $('#' + tax + 'per').on('input', function () { if (toNum($(this).val()) > 0) $('#' + tax + 'amt').val(0); });
            $('#' + tax + 'amt').on('input', function () { if (toNum($(this).val()) > 0) $('#' + tax + 'per').val(0); });
        });

        calculateTotals();

        function recalcModal() {
            var qty  = toNum($('#modal_qty').val());
            var rate = toNum($('#modal_rate').val());

            var amount = round2(qty * rate);

            var discper = toNum($('#modal_discper').val());
            var discamt = toNum($('#modal_discamt').val());
            if (discper > 0) {
                discamt = round2((amount * discper) / 100);
                $('#modal_discamt').val(discamt);
            } else if (discamt > 0) {
                discper = amount > 0 ? round2((discamt / amount) * 100) : 0;
                $('#modal_discper').val(discper);
            }

            var afterDiscount = amount - discamt;

            var cgstper = toNum($('#modal_cgstper').val());
            var cgstamt = toNum($('#modal_cgstamt').val());
            if (cgstper > 0) {
                cgstamt = round2((afterDiscount * cgstper) / 100);
                $('#modal_cgstamt').val(cgstamt);
            } else if (cgstamt > 0) {
                cgstper = afterDiscount > 0 ? round2((cgstamt / afterDiscount) * 100) : 0;
                $('#modal_cgstper').val(cgstper);
            }

            var sgstper = toNum($('#modal_sgstper').val());
            var sgstamt = toNum($('#modal_sgstamt').val());
            if (sgstper > 0) {
                sgstamt = round2((afterDiscount * sgstper) / 100);
                $('#modal_sgstamt').val(sgstamt);
            } else if (sgstamt > 0) {
                sgstper = afterDiscount > 0 ? round2((sgstamt / afterDiscount) * 100) : 0;
                $('#modal_sgstper').val(sgstper);
            }

            var igstper = toNum($('#modal_igstper').val());
            var igstamt = toNum($('#modal_igstamt').val());
            if (igstper > 0) {
                igstamt = round2((afterDiscount * igstper) / 100);
                $('#modal_igstamt').val(igstamt);
            } else if (igstamt > 0) {
                igstper = afterDiscount > 0 ? round2((igstamt / afterDiscount) * 100) : 0;
                $('#modal_igstper').val(igstper);
            }

            var finalAmount = afterDiscount + cgstamt + sgstamt + igstamt;
            $('#modal_amount').val(round2(finalAmount).toFixed(2));

            return round2(finalAmount);
        }

        $('#modal_qty, #modal_rate, #modal_discper, #modal_discamt, ' +
          '#modal_cgstper, #modal_cgstamt, #modal_sgstper, #modal_sgstamt, ' +
          '#modal_igstper, #modal_igstamt').on('input', recalcModal);

        $('#modal_discper').on('input', function () { if (toNum($(this).val()) > 0) $('#modal_discamt').val(0); });
        $('#modal_discamt').on('input', function () { if (toNum($(this).val()) > 0) $('#modal_discper').val(0); });
        ['cgst', 'sgst', 'igst'].forEach(function (tax) {
            $('#modal_' + tax + 'per').on('input', function () { if (toNum($(this).val()) > 0) $('#modal_' + tax + 'amt').val(0); });
            $('#modal_' + tax + 'amt').on('input', function () { if (toNum($(this).val()) > 0) $('#modal_' + tax + 'per').val(0); });
        });

        // Force fresh Add whenever the Add Item button itself is clicked
        $('#addItemBtn').on('click', function () {
            editRowIndex = -1;
        });

        function resetModalFields() {
            $('#itemModal').find('input, textarea').val('');
            $('#modal_itemcd').val(null).trigger('change');
        }

        // Reset edit state whenever the modal closes, saved or not
        $('#itemModal').on('hidden.bs.modal', function () {
            editRowIndex = -1;
            resetModalFields();
        });

        $('#modalSaveBtn').click(function () {
            var itemcd   = $('#modal_itemcd').val();
            var itemName = $('#modal_itemcd option:selected').data('name');
            var serialno = $('#modal_serialno').val();
            var qty      = $('#modal_qty').val();
            var rate     = $('#modal_rate').val();

            if (!itemcd || !qty || !rate) {
                alert('Please fill Item, Qty, Rate.');
                return;
            }

            recalcModal();

            var rowData = {
                itemcd:    itemcd,
                itemName:  itemName,
                serialno:  serialno,
                qty:       qty,
                rate:      rate,
                discper:   $('#modal_discper').val() || 0,
                discamt:   $('#modal_discamt').val() || 0,
                cgstper:   $('#modal_cgstper').val() || 0,
                cgstamt:   $('#modal_cgstamt').val() || 0,
                sgstper:   $('#modal_sgstper').val() || 0,
                sgstamt:   $('#modal_sgstamt').val() || 0,
                igstper:   $('#modal_igstper').val() || 0,
                igstamt:   $('#modal_igstamt').val() || 0,
                amount:    $('#modal_amount').val() || 0,
                itemdescr: $('#modal_itemdescr').val() || ''
            };

            if (editRowIndex > -1) {
                var $row = $('.item-row').eq(editRowIndex);
                renderRow($row, editRowIndex, rowData);
            } else {
                var $newRow = $(`
                    <tr class="item-row"></tr>
                `);
                $('#itemsTable tbody').append($newRow);
                renderRow($newRow, rowIndex, rowData);
                rowIndex++;
            }

            editRowIndex = -1;
            calculateTotals();

            resetModalFields();
            $('#itemModal').modal('hide');
        });

        function renderRow($row, idx, d) {
            $row.html(`
                <td>
                    ${d.itemName}
                    <input type="hidden" name="items[${idx}][itemcd]" value="${d.itemcd}">
                    <input type="hidden" name="items[${idx}][itemdescr]" value="${d.itemdescr}">
                </td>
                <td>
                    ${d.serialno}
                    <input type="hidden" name="items[${idx}][serialno]" value="${d.serialno}">
                </td>
                <td style="text-align:right;">
                    ${parseFloat(d.rate).toFixed(2)}
                    <input type="hidden" name="items[${idx}][rate]" value="${d.rate}">
                </td>
                <td style="text-align:right;">
                    ${d.qty}
                    <input type="hidden" name="items[${idx}][qty]" value="${d.qty}">
                </td>
                <td style="text-align:right;">
                    ${parseFloat(d.discamt).toFixed(2)} (${d.discper}%)
                    <input type="hidden" name="items[${idx}][discper]" value="${d.discper}">
                    <input type="hidden" name="items[${idx}][discamt]" value="${d.discamt}">
                </td>
                <td style="text-align:right;">
                    ${parseFloat(d.cgstamt).toFixed(2)} (${d.cgstper}%)
                    <input type="hidden" name="items[${idx}][cgstper]" value="${d.cgstper}">
                    <input type="hidden" name="items[${idx}][cgstamt]" value="${d.cgstamt}">
                    <input type="hidden" name="items[${idx}][sgstper]" value="${d.sgstper}">
                    <input type="hidden" name="items[${idx}][sgstamt]" value="${d.sgstamt}">
                    <input type="hidden" name="items[${idx}][igstper]" value="${d.igstper}">
                    <input type="hidden" name="items[${idx}][igstamt]" value="${d.igstamt}">
                </td>
                <td style="text-align:right;">
                    ${parseFloat(d.amount).toFixed(2)}
                    <input type="hidden" name="items[${idx}][amount]" value="${d.amount}">
                </td>
                <td class="dropdown text-center">
                    <i class="fas fa-bars ml-2 mr-1" data-toggle="dropdown" href="#" style="cursor:pointer"></i>
                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                        <a href="#" class="dropdown-item edit-item-row" data-index="${idx}"><p>Edit</p></a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item delete-item-row" data-index="${idx}"><p>Delete</p></a>
                    </div>
                </td>
            `);
        }

        $(document).on('click', '.edit-item-row', function (e) {
            e.preventDefault();
            editRowIndex = $(this).data('index');
            var $row = $('.item-row').eq(editRowIndex);

            $('#modal_itemcd').val($row.find('input[name*="[itemcd]"]').val()).trigger('change');
            $('#modal_serialno').val($row.find('input[name*="[serialno]"]').val());
            $('#modal_qty').val($row.find('input[name*="[qty]"]').val());
            $('#modal_rate').val($row.find('input[name*="[rate]"]').val());
            $('#modal_discper').val($row.find('input[name*="[discper]"]').val());
            $('#modal_discamt').val($row.find('input[name*="[discamt]"]').val());
            $('#modal_cgstper').val($row.find('input[name*="[cgstper]"]').val());
            $('#modal_cgstamt').val($row.find('input[name*="[cgstamt]"]').val());
            $('#modal_sgstper').val($row.find('input[name*="[sgstper]"]').val());
            $('#modal_sgstamt').val($row.find('input[name*="[sgstamt]"]').val());
            $('#modal_igstper').val($row.find('input[name*="[igstper]"]').val());
            $('#modal_igstamt').val($row.find('input[name*="[igstamt]"]').val());
            $('#modal_amount').val($row.find('input[name*="[amount]"]').val());
            $('#modal_itemdescr').val($row.find('input[name*="[itemdescr]"]').val());
            $('#itemModal').modal('show');
        });

        $(document).on('click', '.delete-item-row', function (e) {
            e.preventDefault();
            if (confirm('Delete this item?')) {
                $(this).closest('tr').remove();
                calculateTotals();
            }
        });

        $('#salesForm').off('submit').on('submit', function (e) {
            e.preventDefault();
            e.stopPropagation();

            if ($('#saveBtn').prop('disabled')) return;
            $('#saveBtn').prop('disabled', true);

            calculateTotals();

            var formData = new FormData(this);

            $.ajax({
                url : '/crm/save-sales',
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                beforeSend: function () { mtd.show_msg(3, '', 'Saving, Please Wait...', 4); },
                success: function (resp) {
                    Swal.close();
                    $('#saveBtn').prop('disabled', false);
                    var isError = !!resp.error;
                    var message = (resp.data && resp.data.message)
                                    ? resp.data.message
                                    : (resp.message || 'Saved successfully!');
                    if (!isError) {
                        let msg = message.split(/<br\s*\/?>/i)[0];
                        mtd.show_msgT(1, '/crm/sales', msg, 1);
                    } else {
                        mtd.show_msgT(0, '', message, 0);
                    }
                },
                error: function () {
                    Swal.close();
                    $('#saveBtn').prop('disabled', false);
                    mtd.show_msgT(0, '', 'Something went wrong!', 0);
                }
            });
        });
    });
</script>
@endpush
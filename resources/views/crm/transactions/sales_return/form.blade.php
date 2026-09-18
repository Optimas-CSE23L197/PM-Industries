@extends('layout.app', ['dept' => 'CRM'])
@section('page_title_link', route('salesReturn'))
@section('page_titleH', 'Sales Return')
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
                    <form id="salesReturnForm" method="post">
                        @csrf
                        <input type="hidden" name="intno" value="{{ $salesReturn['intno'] ?? 0 }}"/>

                        {{-- ============ SALES DETAILS ============ --}}
                        <div class="col-md-12">
                            <div class="form-section-heading">
                                <i class="fa-solid fa-receipt"></i>
                                <span>Sales Details</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="saleintno" class="col-md-2">Sales No.</label>
                            <div class="col-md-4">
                                <select name="saleintno" id="saleintno"
                                        class="form-control form-control-sm select2"
                                        {{ ($vwedt == 1 || $vwedt == 3) ? 'disabled' : '' }}>
                                    <option value="" selected disabled>Select</option>
                                    @foreach($sales as $sale)
                                        <option value="{{ $sale['intno'] }}"
                                            data-trandt="{{ $sale['trandt'] ?? '' }}"
                                            data-qutintno="{{ $sale['qutintno'] ?? 0 }}"
                                            data-partycd="{{ $sale['partycd'] ?? '' }}"
                                            data-customer="{{ $sale['customer_name'] ?? $sale['party_name'] ?? '' }}"
                                            {{ ($salesReturn['qutintno'] ?? '') == $sale['intno'] ? 'selected' : '' }}>
                                            {{ $sale['tranno'] ?? '' }} - {{ $sale['customer_name'] ?? $sale['party_name'] ?? '' }} - {{ $sale['trandt'] ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @if($vwedt == 1 || $vwedt == 3)
                                    <input type="hidden" name="saleintno" value="{{ $salesReturn['qutintno'] ?? '' }}">
                                @endif
                            </div>

                            <label class="col-md-2 required">Sales Date</label>
                            <div class="col-md-4">
                                <input type="date" id="trandt" class="form-control form-control-sm" disabled
                                       value="{{ $salesReturn['trandt'] ?? '' }}">
                            </div>

                            <label class="col-md-2">Quotation</label>
                            <div class="col-md-4">
                                <input type="text" id="qutno" class="form-control form-control-sm" disabled
                                       value="{{ $salesReturn['quotation_no'] ?? '' }}">
                            </div>

                            <label class="col-md-2">Customer</label>
                            <div class="col-md-4">
                                <input type="text" id="customer_name" class="form-control form-control-sm" disabled
                                       value="{{ $salesReturn['customer_name'] ?? $salesReturn['party_name'] ?? '' }}">
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
                                       value="{{ old('localconvamt', $salesReturn['localconvamt'] ?? 0) }}"
                                       {{ $vwedt == 1 ? 'readonly' : '' }}/>
                            </div>

                            <label class="col-md-2">Other Amount</label>
                            <div class="col-md-4">
                                <input type="number" step="0.01" name="otheramt" id="otheramt"
                                       class="form-control form-control-sm text-right"
                                       value="{{ old('otheramt', $salesReturn['otheramt'] ?? 0) }}"
                                       {{ $vwedt == 1 ? 'readonly' : '' }}/>
                            </div>
                        </div>

                        <div class="col-12"><hr></div>

                        {{-- ============ TAX & AMOUNT DETAILS ============ --}}
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
                                       value="{{ old('basic', $salesReturn['basic'] ?? 0) }}"
                                       {{ $vwedt == 1 ? 'readonly' : '' }}/>
                            </div>

                            <label class="col-md-2">Discount</label>
                            <div class="col-md-4">
                                <div class="btn-group w-100">
                                    <input type="number" step="0.01" name="discper" id="discper"
                                           class="form-control form-control-sm text-right" placeholder="%"
                                           value="{{ old('discper', $salesReturn['discper'] ?? 0) }}"
                                           {{ $vwedt == 1 ? 'readonly' : '' }}/>
                                    <input type="number" step="0.01" name="discamt" id="discamt"
                                           class="form-control form-control-sm text-right" placeholder="₹"
                                           value="{{ old('discamt', $salesReturn['discamt'] ?? 0) }}"
                                           {{ $vwedt == 1 ? 'readonly' : '' }}/>
                                </div>
                            </div>

                            <label class="col-md-2">CGST</label>
                            <div class="col-md-4">
                                <div class="btn-group w-100">
                                    <input type="number" step="0.01" name="cgstper" id="cgstper"
                                           class="form-control form-control-sm text-right" placeholder="%"
                                           value="{{ old('cgstper', $salesReturn['cgstper'] ?? 0) }}"
                                           {{ $vwedt == 1 ? 'readonly' : '' }}/>
                                    <input type="number" step="0.01" name="cgstamt" id="cgstamt"
                                           class="form-control form-control-sm text-right" placeholder="₹"
                                           value="{{ old('cgstamt', $salesReturn['cgstamt'] ?? 0) }}"
                                           {{ $vwedt == 1 ? 'readonly' : '' }}/>
                                </div>
                            </div>

                            <label class="col-md-2">SGST</label>
                            <div class="col-md-4">
                                <div class="btn-group w-100">
                                    <input type="number" step="0.01" name="sgstper" id="sgstper"
                                           class="form-control form-control-sm text-right" placeholder="%"
                                           value="{{ old('sgstper', $salesReturn['sgstper'] ?? 0) }}"
                                           {{ $vwedt == 1 ? 'readonly' : '' }}/>
                                    <input type="number" step="0.01" name="sgstamt" id="sgstamt"
                                           class="form-control form-control-sm text-right" placeholder="₹"
                                           value="{{ old('sgstamt', $salesReturn['sgstamt'] ?? 0) }}"
                                           {{ $vwedt == 1 ? 'readonly' : '' }}/>
                                </div>
                            </div>

                            <label class="col-md-2">IGST</label>
                            <div class="col-md-4">
                                <div class="btn-group w-100">
                                    <input type="number" step="0.01" name="igstper" id="igstper"
                                           class="form-control form-control-sm text-right" placeholder="%"
                                           value="{{ old('igstper', $salesReturn['igstper'] ?? 0) }}"
                                           {{ $vwedt == 1 ? 'readonly' : '' }}/>
                                    <input type="number" step="0.01" name="igstamt" id="igstamt"
                                           class="form-control form-control-sm text-right" placeholder="₹"
                                           value="{{ old('igstamt', $salesReturn['igstamt'] ?? 0) }}"
                                           {{ $vwedt == 1 ? 'readonly' : '' }}/>
                                </div>
                            </div>

                            <label class="col-md-2">Others</label>
                            <div class="col-md-4">
                                <div class="btn-group w-100">
                                    <input type="number" step="0.01" name="othersper" id="othersper"
                                           class="form-control form-control-sm text-right" placeholder="%"
                                           value="{{ old('othersper', $salesReturn['othersper'] ?? 0) }}"
                                           {{ $vwedt == 1 ? 'readonly' : '' }}/>
                                    <input type="number" step="0.01" name="othersamt" id="othersamt"
                                           class="form-control form-control-sm text-right" placeholder="₹"
                                           value="{{ old('othersamt', $salesReturn['othersamt'] ?? 0) }}"
                                           {{ $vwedt == 1 ? 'readonly' : '' }}/>
                                </div>
                            </div>

                            <label class="col-md-2">Round Off</label>
                            <div class="col-md-4">
                                <input type="number" step="0.01" name="rndoff" id="rndoff"
                                       class="form-control form-control-sm text-right"
                                       value="{{ old('rndoff', $salesReturn['rndoff'] ?? 0) }}"
                                       {{ $vwedt == 1 ? 'readonly' : '' }}/>
                            </div>

                            <label class="col-md-2">Net Amount</label>
                            <div class="col-md-4">
                                <input type="text" id="net_amount" class="form-control form-control-sm text-right" disabled
                                       value="{{ $salesReturn['basic'] ?? 0 }}"/>
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
                                    <option value="C" {{ ($salesReturn['modeofpay'] ?? 'C') == 'C' ? 'selected' : '' }}>Cash</option>
                                    <option value="U" {{ ($salesReturn['modeofpay'] ?? '') == 'U' ? 'selected' : '' }}>UPI</option>
                                    <option value="B" {{ ($salesReturn['modeofpay'] ?? '') == 'B' ? 'selected' : '' }}>Bank</option>
                                    <option value="CH" {{ ($salesReturn['modeofpay'] ?? '') == 'CH' ? 'selected' : '' }}>Cheque</option>
                                </select>
                                @if($vwedt == 1)
                                    <input type="hidden" name="modeofpay" value="{{ $salesReturn['modeofpay'] ?? 'C' }}">
                                @endif
                            </div>

                            <label class="col-md-2">Bank</label>
                            <div class="col-md-4">
                                <input type="text" name="bankcd" id="bankcd"
                                       class="form-control form-control-sm"
                                       value="{{ old('bankcd', $salesReturn['bankcd'] ?? '') }}"
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
                                          {{ $vwedt == 1 ? 'readonly' : '' }}>{{ old('narration', $salesReturn['narration'] ?? '') }}</textarea>
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
                                        <th style="width:10%; text-align:right;">Return Qty</th>
                                        <th style="width:10%; text-align:right;">Discount</th>
                                        <th style="width:10%; text-align:right;">GST</th>
                                        <th style="width:10%; text-align:right;">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($salesReturn['items']) && is_array($salesReturn['items']))
                                        @foreach($salesReturn['items'] as $index => $item)
                                            <tr class="item-row">
                                                <td>
                                                    {{ $item['raw_item_name'] ?? $item['finished_item_name'] ?? '' }}
                                                    <input type="hidden" name="items[{{ $index }}][itemcd]" value="{{ $item['itemcd'] ?? '' }}">
                                                </td>
                                                <td>
                                                    {{ $item['serialno'] ?? '' }}
                                                    <input type="hidden" name="items[{{ $index }}][serialno]" value="{{ $item['serialno'] ?? '' }}">
                                                </td>
                                                <td style="text-align:right;">{{ number_format((float)($item['rate'] ?? 0), 2) }}</td>
                                                <td style="text-align:right;">{{ rtrim(rtrim(number_format((float)($item['qty'] ?? 0), 3, '.', ''), '0'), '.') }}</td>
                                                <td>
                                                    <input type="number" step="0.01" name="items[{{ $index }}][qty]"
                                                           class="form-control form-control-sm text-right"
                                                           value="{{ $item['qty'] ?? 0 }}"
                                                           {{ $vwedt == 1 ? 'readonly' : '' }}/>
                                                </td>
                                                <td style="text-align:right;">
                                                    {{ number_format((float)($item['discamt'] ?? 0), 2) }}
                                                    ({{ $item['discper'] ?? 0 }}%)
                                                </td>
                                                <td style="text-align:right;">
                                                    {{ number_format((float)($item['cgstamt'] ?? 0) + (float)($item['sgstamt'] ?? 0), 2) }}
                                                    ({{ $item['cgstper'] ?? 0 }}%)
                                                </td>
                                                <td style="text-align:right;">
                                                    {{ number_format((float)($item['amount'] ?? 0), 2) }}
                                                    <input type="hidden" name="items[{{ $index }}][rate]" value="{{ $item['rate'] ?? 0 }}">
                                                    <input type="hidden" name="items[{{ $index }}][amount]" value="{{ $item['amount'] ?? 0 }}">
                                                    <input type="hidden" name="items[{{ $index }}][discper]" value="{{ $item['discper'] ?? 0 }}">
                                                    <input type="hidden" name="items[{{ $index }}][discamt]" value="{{ $item['discamt'] ?? 0 }}">
                                                    <input type="hidden" name="items[{{ $index }}][cgstper]" value="{{ $item['cgstper'] ?? 0 }}">
                                                    <input type="hidden" name="items[{{ $index }}][cgstamt]" value="{{ $item['cgstamt'] ?? 0 }}">
                                                    <input type="hidden" name="items[{{ $index }}][sgstper]" value="{{ $item['sgstper'] ?? 0 }}">
                                                    <input type="hidden" name="items[{{ $index }}][sgstamt]" value="{{ $item['sgstamt'] ?? 0 }}">
                                                    <input type="hidden" name="items[{{ $index }}][igstper]" value="{{ $item['igstper'] ?? 0 }}">
                                                    <input type="hidden" name="items[{{ $index }}][igstamt]" value="{{ $item['igstamt'] ?? 0 }}">
                                                </td>
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
    </section>

@endsection

@push('js')
<script>
    $(document).ready(function () {
        $('.select2').select2();

        // Auto-fill Sale details when Sale is selected
        $('#saleintno').on('change', function () {
            var $opt = $(this).find('option:selected');
            $('#trandt').val($opt.data('trandt') || '');
            $('#customer_name').val($opt.data('customer') || '');
            $('#qutno').val($opt.data('qutintno') || '');
        });

        if ($('#saleintno').val()) {
            $('#saleintno').trigger('change');
        }

        function toNum(val) {
            var n = parseFloat(val);
            return isNaN(n) ? 0 : n;
        }

        function round2(n) {
            return Math.round((n + Number.EPSILON) * 100) / 100;
        }

        function calculateTotals() {
            // --- Base Gross Amount ---
            var gross = toNum($('#basic').val());

            // --- Charges (Local Conveyance + Other Amount) ---
            var localConv = toNum($('#localconvamt').val());
            var otherAmt  = toNum($('#otheramt').val());

            // Gross + Charges = Taxable Base
            var taxableBase = gross + localConv + otherAmt;

            // --- Discount ---
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

            // --- Helper to apply tax ---
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

            // --- CGST ---
            var cgstAmt = applyTax('#cgstper', '#cgstamt');
            // --- SGST ---
            var sgstAmt = applyTax('#sgstper', '#sgstamt');
            // --- IGST ---
            var igstAmt = applyTax('#igstper', '#igstamt');
            // --- Others ---
            var othersAmt = applyTax('#othersper', '#othersamt');

            // --- Sub Total (before round off) ---
            var subTotal = afterDiscount + cgstAmt + sgstAmt + igstAmt + othersAmt;

            // --- Round Off ---
            var roundedTotal = Math.round(subTotal);
            var rndoff = round2(roundedTotal - subTotal);

            var manualRnd = toNum($('#rndoff').val());
            if (manualRnd !== 0) {
                rndoff = manualRnd;
                roundedTotal = subTotal + rndoff;
            } else {
                $('#rndoff').val(rndoff);
            }

            // --- Net Amount ---
            var netAmount = round2(roundedTotal);

            $('#net_amount').val(netAmount.toFixed(2));
        }

        var calcInputs = [
            '#basic',
            '#localconvamt', '#otheramt',
            '#discper', '#discamt',
            '#cgstper', '#cgstamt',
            '#sgstper', '#sgstamt',
            '#igstper', '#igstamt',
            '#othersper', '#othersamt',
            '#rndoff'
        ];

        $(calcInputs.join(',')).on('input change', function () {
            calculateTotals();
        });

        // % change karne pe related ₹ reset karo (optional UX)
        $('#discper').on('input', function () {
            if (toNum($(this).val()) > 0) $('#discamt').val(0);
        });
        $('#discamt').on('input', function () {
            if (toNum($(this).val()) > 0) $('#discper').val(0);
        });

        ['cgst', 'sgst', 'igst', 'others'].forEach(function (tax) {
            $('#' + tax + 'per').on('input', function () {
                if (toNum($(this).val()) > 0) $('#' + tax + 'amt').val(0);
            });
            $('#' + tax + 'amt').on('input', function () {
                if (toNum($(this).val()) > 0) $('#' + tax + 'per').val(0);
            });
        });

        // Page load pe initial calculation
        calculateTotals();

        $('#salesReturnForm').submit(function (e) {
            e.preventDefault();
            calculateTotals(); // final calc before submit

            var formData = new FormData(this);

            $.ajax({
                url : '/crm/save-sales-return',
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                beforeSend: function () {
                    mtd.show_msg(3, '', 'Saving, Please Wait...', 4);
                },
                success: function (resp) {
                    Swal.close();
                    var isError = !!resp.error;
                    var message = (resp.data && resp.data.message)
                                    ? resp.data.message
                                    : (resp.message || 'Saved successfully!');

                    if (!isError) {
                        let msg = message.split(/<br\s*\/?>/i)[0];
                        mtd.show_msgT(1, '/crm/sales-return', msg, 1);
                    } else {
                        mtd.show_msgT(0, '', message, 0);
                    }
                },
                error: function () {
                    Swal.close();
                    mtd.show_msgT(0, '', 'Something went wrong!', 0);
                }
            });
        });
    });
</script>
@endpush
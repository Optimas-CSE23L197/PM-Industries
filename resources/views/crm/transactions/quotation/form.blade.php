@extends('layout.app', ['dept' => 'CRM'])
@section('page_title_link', route('quotation'))
@section('page_titleH', 'Quotation')
@section('page_title', 'Details')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form id="quotationForm" method="post" data-no-global-submit="1">
                        @csrf
                        <input type="hidden" name="intno" value="{{ $quotation['intno'] ?? 0 }}"/>

                        <div class="form-group row">
                            <label class="col-md-2">Quotation No.</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control form-control-sm" disabled
                                       value="{{ $quotation['quotation_no'] ?? '' }}"/>
                            </div>

                            <label for="quotation_date" class="col-md-2 required">Quotation Date</label>
                            <div class="col-md-4">
                                <input type="date" name="quotation_date" id="quotation_date"
                                       class="form-control form-control-sm date_today" required autofocus
                                       value="{{ old('quotation_date', isset($quotation['quotation_date']) && $quotation['quotation_date'] ? date('Y-m-d', strtotime($quotation['quotation_date'])) : date('Y-m-d')) }}"
                                       {{ $vwedt == 1 ? 'readonly' : '' }}/>
                            </div>

                            <label for="enquiryintno" class="col-md-2 required">Enquiry</label>
                            <div class="col-md-4">
                                <select name="enquiryintno" id="enquiryintno"
                                        class="form-control form-control-sm select2" required
                                        {{ ($vwedt == 1 || $vwedt == 3) ? 'disabled' : '' }}>
                                    <option value="" selected disabled>Select</option>
                                    @foreach($enquiries as $e)
                                        <option value="{{ $e['intno'] }}"
                                            data-customercd="{{ $e['customercd'] ?? '' }}"
                                            data-customer="{{ $e['customer_name'] ?? '' }}"
                                            {{ ($quotation['enquiryintno'] ?? '') == $e['intno'] ? 'selected' : '' }}>
                                            {{ $e['enquiry_no'] ?? '' }} - {{ $e['customer_name'] ?? '' }} - {{ $e['enquiry_date'] ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @if($vwedt == 1 || $vwedt == 3)
                                    <input type="hidden" name="enquiryintno" value="{{ $quotation['enquiryintno'] ?? '' }}">
                                @endif
                            </div>

                            <label class="col-md-2">Customer</label>
                            <div class="col-md-4">
                                <input type="text" id="customer_name" class="form-control form-control-sm" disabled
                                       value="{{ $quotation['customer_name'] ?? '' }}"/>
                                <input type="hidden" name="customercd" id="customercd" value="{{ $quotation['customercd'] ?? '' }}"/>
                            </div>

                            <label for="quotation_termscd" class="col-md-2">Quotation T&amp;C</label>
                            <div class="col-md-4">
                                <select name="quotation_termscd" id="quotation_termscd"
                                        class="form-control form-control-sm select2"
                                        {{ $vwedt == 1 ? 'disabled' : '' }}>
                                    <option value="" selected disabled>Select</option>
                                    @foreach($terms as $t)
                                        <option value="{{ $t['code'] }}"
                                            {{ ($quotation['quotation_termscd'] ?? '') == $t['code'] ? 'selected' : '' }}>
                                            {{ $t['name'] ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @if($vwedt == 1)
                                    <input type="hidden" name="quotation_termscd" value="{{ $quotation['quotation_termscd'] ?? '' }}">
                                @endif
                            </div>

                            <label for="ratelistcd" class="col-md-2">Rate List</label>
                            <div class="col-md-4">
                                <select name="ratelistcd" id="ratelistcd"
                                        class="form-control form-control-sm select2"
                                        {{ $vwedt == 1 ? 'disabled' : '' }}>
                                    <option value="" selected disabled>Select</option>
                                    @foreach($rateLists as $r)
                                        <option value="{{ $r['code'] }}"
                                            {{ ($quotation['ratelistcd'] ?? '') == $r['code'] ? 'selected' : '' }}>
                                            {{ $r['name'] ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @if($vwedt == 1)
                                    <input type="hidden" name="ratelistcd" value="{{ $quotation['ratelistcd'] ?? '' }}">
                                @endif
                            </div>

                            <label for="valid_until" class="col-md-2 required">Valid Till</label>
                            <div class="col-md-4">
                                <input type="date" name="valid_until" id="valid_until"
                                       class="form-control form-control-sm" required
                                       value="{{ old('valid_until', isset($quotation['valid_until']) && $quotation['valid_until'] ? date('Y-m-d', strtotime($quotation['valid_until'])) : '') }}"
                                       {{ $vwedt == 1 ? 'readonly' : '' }}/>
                            </div>

                            <label for="status" class="col-md-2">Quotation Status</label>
                            <div class="col-md-4">
                                <select name="status" id="status" class="form-control form-control-sm"
                                        {{ $vwedt == 1 ? 'disabled' : '' }}>
                                    <option value="DRAFT"    {{ ($quotation['status'] ?? 'DRAFT') == 'DRAFT'    ? 'selected' : '' }}>DRAFT</option>
                                    <option value="SENT"     {{ ($quotation['status'] ?? '') == 'SENT'     ? 'selected' : '' }}>SENT</option>
                                    <option value="ACCEPTED" {{ ($quotation['status'] ?? '') == 'ACCEPTED' ? 'selected' : '' }}>ACCEPTED</option>
                                    <option value="REJECTED" {{ ($quotation['status'] ?? '') == 'REJECTED' ? 'selected' : '' }}>REJECTED</option>
                                </select>
                                @if($vwedt == 1)
                                    <input type="hidden" name="status" value="{{ $quotation['status'] ?? 'DRAFT' }}">
                                @endif
                            </div>

                            <label class="col-md-2">Gross Amount</label>
                            <div class="col-md-4">
                                <input type="text" id="gross_amount" class="form-control form-control-sm text-right" disabled
                                       value="{{ $quotation['subtotal'] ?? 0 }}"/>
                            </div>

                            <label class="col-md-2">GST</label>
                            <div class="col-md-4">
                                <input type="text" id="gst_amount" class="form-control form-control-sm text-right" disabled
                                       value="{{ $quotation['gst'] ?? 0 }}"/>
                            </div>

                            <label class="col-md-2">Net Amount</label>
                            <div class="col-md-4">
                                <input type="text" id="net_amount" class="form-control form-control-sm text-right" disabled
                                       value="{{ $quotation['net_amount'] ?? 0 }}"/>
                            </div>

                            <label for="remarks" class="col-md-2">Remarks</label>
                            <div class="col-md-4">
                                <textarea name="remarks" id="remarks" rows="3"
                                          class="form-control form-control-sm"
                                          {{ $vwedt == 1 ? 'readonly' : '' }}>{{ old('remarks', $quotation['remarks'] ?? '') }}</textarea>
                            </div>

                            <div class="col-md-12"><hr></div>

                            <div class="col-md-12" style="overflow:auto;">
                                <table class="table table-sm table-bordered text-xs" id="itemsTable">
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="width:15%">Item</th>
                                            <th style="width:10%">Size</th>
                                            <th style="width:15%">Description</th>
                                            <th style="width:10%;text-align:right;">Quantity</th>
                                            <th style="width:10%;text-align:right;">Rate</th>
                                            <th style="width:10%;text-align:right;">Discount</th>
                                            <th style="width:10%;text-align:right;">GST</th>
                                            <th style="width:10%;text-align:right;">Amount</th>
                                            @if($vwedt != 1)
                                            <th style="width:10%;text-align:center;">Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($vwedt != 1)
                                        <tr>
                                            <td colspan="9">
                                                <button type="button" class="btn btn-sm btn-secondary btn-block"
                                                        data-toggle="modal" data-target="#quotationModal">
                                                    <i class="fas fa-plus-circle"></i> Add Item
                                                </button>
                                            </td>
                                        </tr>
                                        @endif

                                        @if(isset($quotation['items']) && is_array($quotation['items']))
                                            @foreach($quotation['items'] as $index => $item)
                                                <tr class="item-row">
                                                    <td>
                                                        {{ $item['finished_item_name'] ?? '' }}
                                                        <input type="hidden" name="items[{{ $index }}][finisheditemcd]" value="{{ $item['finisheditemcd'] ?? '' }}">
                                                    </td>
                                                    <td>
                                                        {{ $item['size_name'] ?? '' }}
                                                        <input type="hidden" name="items[{{ $index }}][sizecd]" value="{{ $item['sizecd'] ?? '' }}">
                                                    </td>
                                                    <td>
                                                        {{ $item['description'] ?? '' }}
                                                        <input type="hidden" name="items[{{ $index }}][description]" value="{{ $item['description'] ?? '' }}">
                                                    </td>
                                                    <td style="text-align:right;">
                                                        {{ rtrim(rtrim(number_format((float)($item['qty'] ?? 0), 3, '.', ''), '0'), '.') }}
                                                        <input type="hidden" name="items[{{ $index }}][qty]" value="{{ $item['qty'] ?? 0 }}">
                                                    </td>
                                                    <td style="text-align:right;">
                                                        {{ number_format((float)($item['rate'] ?? 0), 2) }}
                                                        <input type="hidden" name="items[{{ $index }}][rate]" value="{{ $item['rate'] ?? 0 }}">
                                                    </td>
                                                    <td style="text-align:right;">
                                                        {{ number_format((float)($item['discount'] ?? 0), 2) }}
                                                        <input type="hidden" name="items[{{ $index }}][discount]" value="{{ $item['discount'] ?? 0 }}">
                                                    </td>
                                                    <td style="text-align:right;">
                                                        {{ $item['gstrt'] ?? 0 }}%
                                                        <input type="hidden" name="items[{{ $index }}][gstrt]" value="{{ $item['gstrt'] ?? 0 }}">
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

        {{-- ============ MODAL ============ --}}
        <div class="modal fade" id="quotationModal" tabindex="-1" role="dialog" aria-hidden="true">
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
                                <select id="modal_finisheditemcd" class="form-control form-control-sm select2-modal">
                                    <option value="" selected disabled>Select</option>
                                    @foreach($items as $it)
                                        <option value="{{ $it['code'] }}" data-name="{{ $it['name'] }}">{{ $it['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <label class="col-md-2 required">Size</label>
                            <div class="col-md-4">
                                <select id="modal_sizecd" class="form-control form-control-sm select2-modal">
                                    <option value="" selected disabled>Select</option>
                                    @foreach($sizes as $s)
                                        <option value="{{ $s['code'] }}" data-name="{{ $s['name'] }}">{{ $s['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <label class="col-md-2 required">Quantity</label>
                            <div class="col-md-4">
                                <input type="number" step="0.01" id="modal_qty" class="form-control form-control-sm text-right" required>
                            </div>

                            <label class="col-md-2 required">Rate</label>
                            <div class="col-md-4">
                                <input type="number" step="0.01" id="modal_rate" class="form-control form-control-sm text-right" required>
                            </div>

                            <label class="col-md-2 required">Discount</label>
                            <div class="col-md-4">
                                <input type="number" step="0.01" id="modal_discount" class="form-control form-control-sm text-right" value="0">
                            </div>

                            <label class="col-md-2 required">GST %</label>
                            <div class="col-md-4">
                                <input type="number" step="0.01" id="modal_gstrt" class="form-control form-control-sm text-right" value="0">
                            </div>

                            <label class="col-md-2">Amount</label>
                            <div class="col-md-4">
                                <input type="text" id="modal_amount" class="form-control form-control-sm text-right" disabled>
                            </div>

                            <label class="col-md-2 required">Description</label>
                            <div class="col-md-4">
                                <textarea id="modal_description" class="form-control form-control-sm" rows="3"></textarea>
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
        $('.select2-modal').select2({ dropdownParent: $('#quotationModal') });

        let rowIndex     = {{ isset($quotation['items']) && is_array($quotation['items']) ? count($quotation['items']) : 0 }};
        let editRowIndex = -1;

        // ============================================================
        // HELPERS
        // ============================================================
        function toNum(v) { var n = parseFloat(v); return isNaN(n) ? 0 : n; }
        function round2(n) { return Math.round((n + Number.EPSILON) * 100) / 100; }

        // ============================================================
        // Auto-fill customer from Enquiry
        // ============================================================
        $('#enquiryintno').on('change', function () {
            var $opt = $(this).find('option:selected');
            $('#customer_name').val($opt.data('customer') || '');
            $('#customercd').val($opt.data('customercd') || '');
        });
        if ($('#enquiryintno').val()) $('#enquiryintno').trigger('change');

        // ============================================================
        // MAIN PAGE AUTO CALCULATION
        // ============================================================
        function calculateTotals() {
            var gross = 0;
            var gst   = 0;

            $('.item-row').each(function () {
                var qty      = toNum($(this).find('input[name*="[qty]"]').val());
                var rate     = toNum($(this).find('input[name*="[rate]"]').val());
                var discount = toNum($(this).find('input[name*="[discount]"]').val());
                var gstrt    = toNum($(this).find('input[name*="[gstrt]"]').val());

                var lineAmt  = qty * rate;
                var afterDisc= lineAmt - discount;
                var gstAmt   = (afterDisc * gstrt) / 100;
                var lineTotal= afterDisc + gstAmt;

                gross += lineAmt;
                gst   += gstAmt;

                $(this).find('input[name*="[amount]"]').val(round2(lineTotal));
                $(this).find('td:eq(7)').contents().first().replaceWith(round2(lineTotal).toFixed(2) + ' ');
            });

            var net = gross + gst;

            $('#gross_amount').val(gross.toFixed(2));
            $('#gst_amount').val(gst.toFixed(2));
            $('#net_amount').val(net.toFixed(2));
        }
        calculateTotals();

        // ============================================================
        // MODAL AUTO CALC
        // ============================================================
        function recalcModal() {
            var qty      = toNum($('#modal_qty').val());
            var rate     = toNum($('#modal_rate').val());
            var discount = toNum($('#modal_discount').val());
            var gstrt    = toNum($('#modal_gstrt').val());

            var lineAmt   = qty * rate;
            var afterDisc = lineAmt - discount;
            var gstAmt    = (afterDisc * gstrt) / 100;
            var finalAmt  = afterDisc + gstAmt;

            $('#modal_amount').val(round2(finalAmt).toFixed(2));
        }
        $('#modal_qty, #modal_rate, #modal_discount, #modal_gstrt').on('input', recalcModal);

        // ============================================================
        // MODAL SAVE
        // ============================================================
        $('#modalSaveBtn').click(function () {
            var itemcd   = $('#modal_finisheditemcd').val();
            var itemName = $('#modal_finisheditemcd option:selected').data('name');
            var sizecd   = $('#modal_sizecd').val();
            var sizeName = $('#modal_sizecd option:selected').data('name');
            var qty      = $('#modal_qty').val();
            var rate     = $('#modal_rate').val();

            if (!itemcd || !sizecd || !qty || !rate) {
                alert('Please fill Item, Size, Qty, Rate.');
                return;
            }

            recalcModal();

            var rowData = {
                itemcd:      itemcd,
                itemName:    itemName,
                sizecd:      sizecd,
                sizeName:    sizeName,
                qty:         qty,
                rate:        rate,
                discount:    $('#modal_discount').val() || 0,
                gstrt:       $('#modal_gstrt').val() || 0,
                amount:      $('#modal_amount').val() || 0,
                description: $('#modal_description').val() || ''
            };

            if (editRowIndex > -1) {
                renderRow($('.item-row').eq(editRowIndex), editRowIndex, rowData);
                editRowIndex = -1;
            } else {
                var $newRow = $('<tr class="item-row"></tr>');
                $('#itemsTable tbody').append($newRow);
                renderRow($newRow, rowIndex, rowData);
                rowIndex++;
            }

            calculateTotals();

            // Reset modal
            $('#modal_finisheditemcd').val(null).trigger('change');
            $('#modal_sizecd').val(null).trigger('change');
            $('#modal_qty, #modal_rate, #modal_discount, #modal_gstrt, #modal_description').val('');
            $('#modal_amount').val('');
            $('#quotationModal').modal('hide');
        });

        // ============================================================
        // RENDER ROW
        // ============================================================
        function renderRow($row, idx, d) {
            $row.html(`
                <td>
                    ${d.itemName}
                    <input type="hidden" name="items[${idx}][finisheditemcd]" value="${d.itemcd}">
                </td>
                <td>
                    ${d.sizeName}
                    <input type="hidden" name="items[${idx}][sizecd]" value="${d.sizecd}">
                </td>
                <td>
                    ${d.description}
                    <input type="hidden" name="items[${idx}][description]" value="${d.description}">
                </td>
                <td style="text-align:right;">
                    ${d.qty}
                    <input type="hidden" name="items[${idx}][qty]" value="${d.qty}">
                </td>
                <td style="text-align:right;">
                    ${parseFloat(d.rate).toFixed(2)}
                    <input type="hidden" name="items[${idx}][rate]" value="${d.rate}">
                </td>
                <td style="text-align:right;">
                    ${parseFloat(d.discount).toFixed(2)}
                    <input type="hidden" name="items[${idx}][discount]" value="${d.discount}">
                </td>
                <td style="text-align:right;">
                    ${d.gstrt}%
                    <input type="hidden" name="items[${idx}][gstrt]" value="${d.gstrt}">
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

        // ============================================================
        // EDIT ROW
        // ============================================================
        $(document).on('click', '.edit-item-row', function (e) {
            e.preventDefault();
            editRowIndex = $(this).data('index');
            var $row = $('.item-row').eq(editRowIndex);

            $('#modal_finisheditemcd').val($row.find('input[name*="[finisheditemcd]"]').val()).trigger('change');
            $('#modal_sizecd').val($row.find('input[name*="[sizecd]"]').val()).trigger('change');
            $('#modal_qty').val($row.find('input[name*="[qty]"]').val());
            $('#modal_rate').val($row.find('input[name*="[rate]"]').val());
            $('#modal_discount').val($row.find('input[name*="[discount]"]').val());
            $('#modal_gstrt').val($row.find('input[name*="[gstrt]"]').val());
            $('#modal_amount').val($row.find('input[name*="[amount]"]').val());
            $('#modal_description').val($row.find('input[name*="[description]"]').val());
            $('#quotationModal').modal('show');
        });

        // ============================================================
        // DELETE ROW
        // ============================================================
        $(document).on('click', '.delete-item-row', function (e) {
            e.preventDefault();
            if (confirm('Delete this item?')) {
                $(this).closest('tr').remove();
                calculateTotals();
            }
        });

        // ============================================================
        // FORM SUBMIT
        // ============================================================
        $('#quotationForm').off('submit').on('submit', function (e) {
            e.preventDefault();
            e.stopPropagation();

            if ($('#saveBtn').prop('disabled')) return;
            $('#saveBtn').prop('disabled', true);

            calculateTotals();

            var formData = new FormData(this);

            $.ajax({
                url : '/crm/save-quotation',
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
                        mtd.show_msgT(1, '/crm/quotation', msg, 1);
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
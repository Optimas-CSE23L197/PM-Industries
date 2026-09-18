@extends('layout.app', ['dept' => 'CRM'])
@section('page_title_link', route('salesOrder'))
@section('page_titleH', 'Sales Order')
@section('page_title', 'Details')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form id="salesOrderForm" method="post" data-no-global-submit="1">
                        @csrf
                        <input type="hidden" name="intno" value="{{ $salesOrder['intno'] ?? 0 }}"/>

                        <div class="form-group row">
                            <label class="col-md-2">Order No.</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control form-control-sm" disabled
                                       value="{{ $salesOrder['order_no'] ?? '' }}"/>
                            </div>

                            <label for="order_date" class="col-md-2 required">Order Date</label>
                            <div class="col-md-4">
                                <input type="date" name="order_date" id="order_date"
                                       class="form-control form-control-sm date_today" required
                                       value="{{ old('order_date', isset($salesOrder['order_date']) && $salesOrder['order_date'] ? date('Y-m-d', strtotime($salesOrder['order_date'])) : date('Y-m-d')) }}"
                                       {{ $vwedt == 1 ? 'readonly' : '' }}/>
                            </div>

                            <label class="col-md-2 required">Customer</label>
                            <div class="col-md-4">
                                <input type="text" id="customer_name" class="form-control form-control-sm" disabled
                                       value="{{ $salesOrder['customer_name'] ?? '' }}"/>
                                <input type="hidden" name="customercd" id="customercd" value="{{ $salesOrder['customercd'] ?? '' }}"/>
                            </div>

                            <label for="quotationintno" class="col-md-2 required">Quotation No.</label>
                            <div class="col-md-4">
                                <select name="quotationintno" id="quotationintno"
                                        class="form-control form-control-sm select2" required
                                        {{ ($vwedt == 1 || $vwedt == 3) ? 'disabled' : '' }}>
                                    <option value="" selected disabled>Select</option>
                                    @foreach($quotations as $q)
                                        <option value="{{ $q['intno'] }}"
                                            data-customercd="{{ $q['customercd'] ?? '' }}"
                                            data-customer="{{ $q['customer_name'] ?? '' }}"
                                            {{ ($salesOrder['quotationintno'] ?? '') == $q['intno'] ? 'selected' : '' }}>
                                            {{ $q['quotation_no'] ?? '' }} - {{ $q['quotation_date'] ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @if($vwedt == 1 || $vwedt == 3)
                                    <input type="hidden" name="quotationintno" value="{{ $salesOrder['quotationintno'] ?? '' }}">
                                @endif
                            </div>

                            <label for="status" class="col-md-2 required">Status</label>
                            <div class="col-md-4">
                                <select name="status" id="status" class="form-control form-control-sm select2" required
                                        {{ $vwedt == 1 ? 'disabled' : '' }}>
                                    <option value="OPEN"     {{ ($salesOrder['status'] ?? 'OPEN') == 'OPEN'     ? 'selected' : '' }}>OPEN</option>
                                    <option value="CONFIRMED"{{ ($salesOrder['status'] ?? '') == 'CONFIRMED'? 'selected' : '' }}>CONFIRMED</option>
                                    <option value="DISPATCHED"{{ ($salesOrder['status'] ?? '') == 'DISPATCHED'? 'selected' : '' }}>DISPATCHED</option>
                                    <option value="CLOSED"   {{ ($salesOrder['status'] ?? '') == 'CLOSED'   ? 'selected' : '' }}>CLOSED</option>
                                    <option value="CANCELLED"{{ ($salesOrder['status'] ?? '') == 'CANCELLED'? 'selected' : '' }}>CANCELLED</option>
                                </select>
                                @if($vwedt == 1)
                                    <input type="hidden" name="status" value="{{ $salesOrder['status'] ?? 'OPEN' }}">
                                @endif
                            </div>

                            <label for="delivery_date" class="col-md-2">Delivery Date</label>
                            <div class="col-md-4">
                                <input type="date" name="delivery_date" id="delivery_date"
                                       class="form-control form-control-sm date_today"
                                       value="{{ old('delivery_date', isset($salesOrder['delivery_date']) && $salesOrder['delivery_date'] ? date('Y-m-d', strtotime($salesOrder['delivery_date'])) : '') }}"
                                       {{ $vwedt == 1 ? 'readonly' : '' }}/>
                            </div>

                            <label class="col-md-2">Total Amount</label>
                            <div class="col-md-4">
                                <input type="text" id="total_amount" class="form-control form-control-sm text-right" disabled
                                       value="{{ $salesOrder['total_amount'] ?? 0 }}"/>
                            </div>

                            <div class="col-12"><hr></div>

                            <div class="col-md-12" style="overflow:auto;">
                                <table class="table table-sm table-bordered text-xs" id="itemsTable">
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="width:20%">Item</th>
                                            <th style="width:30%">Item Description</th>
                                            <th style="width:10%;text-align:right;">Rate</th>
                                            <th style="width:10%;text-align:right;">Qty</th>
                                            <th style="width:10%;text-align:right;">Amount</th>
                                            <th style="width:10%;text-align:right;">Delivered Qty</th>
                                            @if($vwedt != 1)
                                            <th style="width:10%;text-align:center;">Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($vwedt != 1)
                                        <tr>
                                            <td colspan="7">
                                                <button type="button" class="btn btn-sm btn-secondary btn-block"
                                                        data-toggle="modal" data-target="#itemModal">
                                                    <i class="fas fa-plus-circle"></i> Add Item
                                                </button>
                                            </td>
                                        </tr>
                                        @endif

                                        @if(isset($salesOrder['items']) && is_array($salesOrder['items']))
                                            @foreach($salesOrder['items'] as $index => $item)
                                                <tr class="item-row">
                                                    <td>
                                                        {{ $item['finished_item_name'] ?? '' }}
                                                        <input type="hidden" name="items[{{ $index }}][finisheditemcd]" value="{{ $item['finisheditemcd'] ?? '' }}">
                                                    </td>
                                                    <td>
                                                        {{ $item['description'] ?? '' }}
                                                        <input type="hidden" name="items[{{ $index }}][description]" value="{{ $item['description'] ?? '' }}">
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
                                                        {{ number_format((float)($item['amount'] ?? 0), 2) }}
                                                        <input type="hidden" name="items[{{ $index }}][amount]" value="{{ $item['amount'] ?? 0 }}">
                                                    </td>
                                                    <td style="text-align:right;">
                                                        {{ rtrim(rtrim(number_format((float)($item['delivered_qty'] ?? 0), 3, '.', ''), '0'), '.') }}
                                                        <input type="hidden" name="items[{{ $index }}][delivered_qty]" value="{{ $item['delivered_qty'] ?? 0 }}">
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

        {{-- ITEM MODAL --}}
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
                                <select id="modal_finisheditemcd" class="form-control form-control-sm select2-modal">
                                    <option value="" selected disabled>Select</option>
                                    @foreach($items as $it)
                                        <option value="{{ $it['code'] }}" data-name="{{ $it['name'] }}">{{ $it['name'] }}</option>
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

                            <label class="col-md-2">Amount</label>
                            <div class="col-md-4">
                                <input type="text" id="modal_amount" class="form-control form-control-sm text-right" disabled>
                            </div>

                            <label class="col-md-2 required">Delivered Quantity</label>
                            <div class="col-md-4">
                                <input type="number" step="0.01" id="modal_delivered_qty" class="form-control form-control-sm text-right" value="0">
                            </div>

                            <label class="col-md-2">Item Description</label>
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
        $('.select2-modal').select2({ dropdownParent: $('#itemModal') });

        let rowIndex     = {{ isset($salesOrder['items']) && is_array($salesOrder['items']) ? count($salesOrder['items']) : 0 }};
        let editRowIndex = -1;

        // HELPERS
        function toNum(v) { var n = parseFloat(v); return isNaN(n) ? 0 : n; }
        function round2(n) { return Math.round((n + Number.EPSILON) * 100) / 100; }

        // Auto-fill customer from quotation
        $('#quotationintno').on('change', function () {
            var $opt = $(this).find('option:selected');
            $('#customer_name').val($opt.data('customer') || '');
            $('#customercd').val($opt.data('customercd') || '');
        });
        if ($('#quotationintno').val()) $('#quotationintno').trigger('change');

        // MAIN PAGE — Total Amount calc
        function calculateTotals() {
            var total = 0;
            $('.item-row').each(function () {
                total += toNum($(this).find('input[name*="[amount]"]').val());
            });
            $('#total_amount').val(total.toFixed(2));
        }
        calculateTotals();

        // MODAL — Amount calc
        function recalcModal() {
            var qty  = toNum($('#modal_qty').val());
            var rate = toNum($('#modal_rate').val());
            $('#modal_amount').val(round2(qty * rate).toFixed(2));
        }
        $('#modal_qty, #modal_rate').on('input', recalcModal);

        // MODAL SAVE
        $('#modalSaveBtn').click(function () {
            var itemcd   = $('#modal_finisheditemcd').val();
            var itemName = $('#modal_finisheditemcd option:selected').data('name');
            var qty      = $('#modal_qty').val();
            var rate     = $('#modal_rate').val();

            if (!itemcd || !qty || !rate) {
                alert('Please fill Item, Qty, Rate.');
                return;
            }
            recalcModal();

            var rowData = {
                itemcd:        itemcd,
                itemName:      itemName,
                qty:           qty,
                rate:          rate,
                amount:        $('#modal_amount').val() || 0,
                delivered_qty: $('#modal_delivered_qty').val() || 0,
                description:   $('#modal_description').val() || ''
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

            // Reset & close
            $('#modal_finisheditemcd').val(null).trigger('change');
            $('#modal_qty, #modal_rate, #modal_delivered_qty, #modal_description, #modal_amount').val('');
            $('#itemModal').modal('hide');
        });

        // RENDER ROW
        function renderRow($row, idx, d) {
            $row.html(`
                <td>
                    ${d.itemName}
                    <input type="hidden" name="items[${idx}][finisheditemcd]" value="${d.itemcd}">
                </td>
                <td>
                    ${d.description}
                    <input type="hidden" name="items[${idx}][description]" value="${d.description}">
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
                    ${parseFloat(d.amount).toFixed(2)}
                    <input type="hidden" name="items[${idx}][amount]" value="${d.amount}">
                </td>
                <td style="text-align:right;">
                    ${d.delivered_qty}
                    <input type="hidden" name="items[${idx}][delivered_qty]" value="${d.delivered_qty}">
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

        // EDIT ROW
        $(document).on('click', '.edit-item-row', function (e) {
            e.preventDefault();
            editRowIndex = $(this).data('index');
            var $row = $('.item-row').eq(editRowIndex);

            $('#modal_finisheditemcd').val($row.find('input[name*="[finisheditemcd]"]').val()).trigger('change');
            $('#modal_qty').val($row.find('input[name*="[qty]"]').val());
            $('#modal_rate').val($row.find('input[name*="[rate]"]').val());
            $('#modal_amount').val($row.find('input[name*="[amount]"]').val());
            $('#modal_delivered_qty').val($row.find('input[name*="[delivered_qty]"]').val());
            $('#modal_description').val($row.find('input[name*="[description]"]').val());
            $('#itemModal').modal('show');
        });

        // DELETE ROW
        $(document).on('click', '.delete-item-row', function (e) {
            e.preventDefault();
            if (confirm('Delete this item?')) {
                $(this).closest('tr').remove();
                calculateTotals();
            }
        });

        // FORM SUBMIT
        $('#salesOrderForm').off('submit').on('submit', function (e) {
            e.preventDefault();
            e.stopPropagation();

            if ($('#saveBtn').prop('disabled')) return;
            $('#saveBtn').prop('disabled', true);

            calculateTotals();
            var formData = new FormData(this);

            $.ajax({
                url : '/crm/save-sales-order',
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
                        mtd.show_msgT(1, '/crm/sales-order', msg, 1);
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
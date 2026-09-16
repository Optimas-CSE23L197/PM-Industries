@extends('layout.app', ['dept' => 'Raw Material Inventory'])

@section('page_title_link')
    {{ route('rawMaterialsInventory.purchaseOrderList') }}
@endsection

@section('page_titleH', 'Purchase Order')
@section('page_title', 'Details')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <form id="purchaseOrderForm" method="POST">
                @csrf

                <input type="hidden" name="intno" id="intno" value="{{ $prOdr['intno'] ?? '' }}"/>
                <input type="hidden" name="activeyn" id="activeyn" value="{{ $prOdr['activeyn'] ?? 'Y' }}"/>
                {{-- Serialized JSON of all item rows (API rows + user-added rows) gets written here right before submit --}}
                <input type="hidden" name="items" id="items_input"/>

                <div class="card">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="po_no" class="col-md-2">Transaction No.</label>
                            <div class="col-md-4">
                                <input type="text" name="po_no" id="po_no" value="{{ $prOdr['po_no'] ?? '' }}" class="form-control form-control-sm" readonly/>
                            </div>

                            <label for="po_date" class="col-md-2 required">Date</label>
                            <div class="col-md-4">
                                <input type="date" name="po_date" id="po_date" value="{{ old('po_date', $prOdr['po_date'] ?? now()->format('Y-m-d')) }}" class="form-control form-control-sm" required autofocus/>
                            </div>

                            <label for="suppliercd" class="col-md-2 required">Supplier</label>
                            <div class="col-md-4">
                                <select name="suppliercd" class="form-control form-control-sm select2" id="suppliercd" required>
                                    @if ($mode === 'new')
                                        <option value="" selected disabled>Select</option>
                                    @endif
                                    @forelse ( $splr as $s )
                                        <option value="{{ $s['code'] }}"
                                            {{ (($s['code'] ?? '') === ($prOdr['suppliercd'] ?? '')) ? 'selected' : '' }}>
                                            {{ $s['name'] }}
                                        </option>
                                    @empty
                                        <option>No supplier found</option>
                                    @endforelse
                                </select>
                            </div>

                            <label for="expected_date" class="col-md-2 required">Expected Date</label>
                            <div class="col-md-4">
                                <input type="date" name="expected_date" id="expected_date" value="{{ old('expected_date', $prOdr['expected_date'] ?? now()->format('Y-m-d')) }}" class="form-control form-control-sm" required autofocus/>
                            </div>

                            <div class="col-12"><hr></div>
                            <label for="gross" class="col-md-2">Gross Amount</label>
                            <div class="col-md-4">
                                <input type="text" name="gross" id="gross" value="{{ old('gross', $prOdr['gross'] ?? 0.00) }}" class="form-control form-control-sm text-right" readonly/>
                            </div>
                            <label for="gstamt" class="col-md-2">GST Amount</label>
                            <div class="col-md-4">
                                <input type="text" name="gstamt" id="gstamt" value="{{ old('gstamt', $prOdr['gstamt'] ?? 0.00) }}" class="form-control form-control-sm text-right" readonly/>
                            </div>

                            <label for="roundoff" class="col-md-2">Round off Amount</label>
                            <div class="col-md-4">
                                <input type="text" name="roundoff" id="roundoff" value="{{ old('roundoff', $prOdr['roundoff'] ?? 0.00) }}" class="form-control form-control-sm text-right" readonly/>
                            </div>

                            <label for="netamt" class="col-md-2">Net Amount</label>
                            <div class="col-md-4">
                                <input type="text" name="netamt" id="netamt" value="{{ old('netamt', $prOdr['netamt'] ?? 0.00) }}" class="form-control form-control-sm text-right" readonly/>
                            </div>

                            <label for="remarks" class="col-md-2">Remarks</label>
                            <div class="col-md-4">
                                <textarea name="remarks" class="form-control form-control-sm"
                                    rows="3" id="remarks">{{ $prOdr['remarks'] ?? '' }}</textarea>
                            </div>

                            <div class="col-12"><hr></div>
                            <div class="col-md-12" style="overflow:auto;">
                                <table class="table table-sm table-bordered text-xs">
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="width:50%">Item</th>
                                            <th style="width:10%;text-align:right;">Qty</th>
                                            <th style="width:10%;text-align:right;">Rate</th>
                                            <th style="width:10%;text-align:right;">GST</th>
                                            <th style="width:10%;text-align:right;">Amount</th>
                                            <th style="width:10%;text-align:center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemsTbody">
                                        <tr id="addItemRow">
                                            <td colspan="6"><button type="button" class="btn btn-sm btn-secondary btn-block"
                                                    data-toggle="modal" data-target="#poModal"><i
                                                        class="fas fa-plus-circle"></i> Add Item</button></td>
                                        </tr>
                                        {{-- Item rows (whether they came from the API or were added by the user
                                             in this session) are rendered here dynamically by JS. See the
                                             renderItems() function below. --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <button type="submit" id="saveBtn" class="btn btn-sm btn-dark float-right"><i
                                class="fas fa-save mr-1"></i>
                            Save</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    @include('rawMaterialsInventory.transactions.purchaseOrder.popup.itemDetails', ['rawItems'=>$rawItems])

    @push('js')
        <script>
            const mode = @json($mode);

            // Seed data: rows that already exist (came from the API / DB).
            // Rows the user adds during this session get pushed into this same
            // array, so from here on there is no distinction between the two sources.
            let items = @json($prOdr['items'] ?? []);

            let uidCounter = 0;
            let editingUid = null;

            // Give every seeded row a client-side unique id so we can reference
            // a specific row for edit/delete without relying on array position.
            items = items.map(function (it) {
                uidCounter++;
                return Object.assign({}, it, { _uid: uidCounter });
            });

            function toNum(v) {
                const n = parseFloat(v);
                return isNaN(n) ? 0 : n;
            }

            function money(v) {
                return toNum(v).toFixed(2);
            }

            function escapeHtml(str) {
                return $('<div>').text(str === null || str === undefined ? '' : str).html();
            }

            function renderItems() {
                const $tbody = $('#itemsTbody');
                $tbody.find('tr.item-row, tr.empty-row').remove();

                if (items.length === 0) {
                    $tbody.append(
                        '<tr class="empty-row"><td colspan="6" style="text-align:center">' +
                        'No item record found. Click on <strong>Add Item</strong> button to add a record</td></tr>'
                    );
                } else {
                    items.forEach(function (item) {
                        const row = $(
                            '<tr class="item-row" data-uid="' + item._uid + '">' +
                                '<td class="item-name"></td>' +
                                '<td style="text-align:right;" class="item-qty"></td>' +
                                '<td style="text-align:right;" class="item-rate"></td>' +
                                '<td style="text-align:right;" class="item-gst"></td>' +
                                '<td style="text-align:right;" class="item-amount"></td>' +
                                '<td class="dropdown text-center">' +
                                    '<i class="fas fa-bars ml-2 mr-1" data-toggle="dropdown" href="#" style="cursor:pointer"></i>' +
                                    '<div class="dropdown-menu dropdown-menu-md dropdown-menu-right">' +
                                        '<a href="#" class="dropdown-item edit-item" data-uid="' + item._uid + '">' +
                                            '<div class="media"><div class="media-body"><p>Edit</p></div></div>' +
                                        '</a>' +
                                        '<div class="dropdown-divider"></div>' +
                                        '<a href="#" class="dropdown-item delete-item" data-uid="' + item._uid + '">' +
                                            '<div class="media"><div class="media-body"><p>Delete</p></div></div>' +
                                        '</a>' +
                                    '</div>' +
                                '</td>' +
                            '</tr>'
                        );

                        row.find('.item-name').text(item.raw_item_name || '');
                        row.find('.item-qty').text(money(item.ordered_qty));
                        row.find('.item-rate').text(money(item.rate));
                        row.find('.item-gst').text(money(item.gst));
                        row.find('.item-amount').text(money(item.item_amount));

                        $tbody.append(row);
                    });
                }

                calculateSummary();

                if (mode === 'view') {
                    applyViewMode();
                }
            }

            // Gross = sum of every row's amount.
            // GST Amount = average gst value across rows.
            // Net Amount = Gross rounded to the nearest whole number ("selling value").
            // Round Off = Net Amount - Gross Amount.
            function calculateSummary() {
                let gross = 0;
                let gstTotal = 0;

                items.forEach(function (item) {
                    gross += toNum(item.item_amount);
                    gstTotal += toNum(item.gst);
                });

                const gstAvg = items.length ? (gstTotal / items.length) : 0;
                const netAmt = Math.ceil(gross);
                const roundOff = netAmt - gross;

                $('#gross').val(gross.toFixed(2));
                $('#gstamt').val(gstAvg.toFixed(2));
                $('#netamt').val(netAmt.toFixed(2));
                $('#roundoff').val(roundOff.toFixed(2));
            }

            // Live amount calculation inside the popup: amount = (qty * rate) + gst
            function calculatePopupAmount() {
                const qty = toNum($('#ordered_qty').val());
                const rate = toNum($('#rate').val());
                const gst = toNum($('#gst').val());
                const amount = (qty * rate) + gst;
                $('#item_amount').val(amount.toFixed(2));
            }

            function resetPopup() {
                editingUid = null;
                $('#familyForm')[0].reset();
                $('#rawitemcd').val('').trigger('change');
                $('#item_amount').val('');
            }

            function openPopupForAdd() {
                resetPopup();
                $('#poModal').modal('show');
            }

            function openPopupForEdit(uid) {
                const item = items.find(function (it) { return it._uid == uid; });
                if (!item) return;

                resetPopup();
                editingUid = uid;

                $('#rawitemcd').val(item.rawitemcd).trigger('change');
                $('#ordered_qty').val(item.ordered_qty);
                $('#rate').val(item.rate);
                $('#gst').val(item.gst);
                $('#item_amount').val(money(item.item_amount));

                $('#poModal').modal('show');
            }

            function applyViewMode() {
                $('input, textarea, select').attr('disabled', true);
                $('#saveBtn').hide();
                $('#addItemRow').hide();
                $('#itemsTbody .fa-bars').hide();
            }

            $(document).on('click', '.edit-item', function (e) {
                e.preventDefault();
                openPopupForEdit($(this).data('uid'));
            });

            $(document).on('click', '.delete-item', function (e) {
                e.preventDefault();
                if (!confirm('Remove this item from the list?')) return;
                const uid = $(this).data('uid');
                items = items.filter(function (it) { return it._uid != uid; });
                renderItems();
            });

            $(document).on('input change', '#ordered_qty, #rate, #gst', function () {
                calculatePopupAmount();
            });

            // Reset the popup to a clean "add" state whenever it finishes closing,
            // whatever caused the close (Add button success, X button, backdrop click, Esc).
            $('#poModal').on('hidden.bs.modal', function () {
                resetPopup();
            });

            $('#addBtn').on('click', function () {
                const rawitemcd = $('#rawitemcd').val();
                const rawItemName = $('#rawitemcd option:selected').text();
                const ordered_qty = toNum($('#ordered_qty').val());
                const rate = toNum($('#rate').val());
                const gst = toNum($('#gst').val());
                const item_amount = (ordered_qty * rate) + gst;

                if (!rawitemcd) {
                    alert('Please select an item.');
                    return;
                }
                if (ordered_qty <= 0) {
                    alert('Please enter a valid quantity.');
                    return;
                }
                if (rate <= 0) {
                    alert('Please enter a valid rate.');
                    return;
                }

                if (editingUid) {
                    const idx = items.findIndex(function (it) { return it._uid == editingUid; });
                    if (idx > -1) {
                        items[idx] = Object.assign({}, items[idx], {
                            rawitemcd: rawitemcd,
                            raw_item_name: rawItemName,
                            ordered_qty: ordered_qty,
                            rate: rate,
                            gst: gst,
                            item_amount: item_amount
                        });
                    }
                } else {
                    uidCounter++;
                    items.push({
                        _uid: uidCounter,
                        rawitemcd: rawitemcd,
                        raw_item_name: rawItemName,
                        ordered_qty: ordered_qty,
                        received_qty: 0,
                        rate: rate,
                        gst: gst,
                        item_amount: item_amount,
                        activeyn: 'Y'
                    });
                }

                renderItems();
                $('#poModal').modal('hide');
            });

            // Build the items JSON payload (same shape the API uses) into the
            // hidden #items_input field, right before the form gets serialized.
            function syncItemsInput() {
                const payload = items.map(function (it) {
                    return {
                        rawitemcd: it.rawitemcd,
                        ordered_qty: it.ordered_qty,
                        received_qty: it.received_qty || 0,
                        rate: it.rate,
                        gst: it.gst,
                        item_amount: it.item_amount,
                        activeyn: it.activeyn || 'Y'
                    };
                });
                $('#items_input').val(JSON.stringify(payload));
            }

            $('#purchaseOrderForm').submit(function (e) {
                e.preventDefault();

                if (items.length === 0) {
                    alert('Please add at least one item before saving.');
                    return;
                }

                syncItemsInput();

                var $saveBtn = $('#saveBtn');
                var originalBtnHtml = $saveBtn.html();
                $saveBtn.prop('disabled', true);
                $saveBtn.html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');

                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('rawMaterialsInventory.savePurchsaeOrder') }}",
                    type: 'post',
                    data: formData,
                    beforeSend: function () {
                        mtd.show_msg(3, '', 'Saving, Please Wait...', 4);
                    },
                    success: function (resp) {
                        Swal.close();
                        let message = resp.message.split(/<br\s*\/?>/i)[0];

                        if (!resp.error) {
                            mtd.show_msgT(1, "{{ route('rawMaterialsInventory.purchaseOrderList') }}", message, 1); // TODO: put your real list route name here
                        } else {
                            mtd.show_msgT(0, '', message, 0);
                        }
                    },
                    error: function (xhr) {
                        Swal.close();
                        let message = xhr.responseJSON?.message ?? 'Something went wrong. Please try again.';
                        mtd.show_msgT(0, '', message, 0);
                    },
                    complete: function () {
                        $saveBtn.prop('disabled', false);
                        $saveBtn.html(originalBtnHtml);
                    }
                });
            });

            $(function () {
                renderItems();
            });
        </script>
    @endpush

@endsection
@extends('layout.app', ['dept' => 'Raw Material Inventory'])

@section('page_title_link')
    {{ route('rawMaterialsInventory.stkAdjList') }}
@endsection

@section('page_titleH', 'Stock Adjustment')
@section('page_title', 'Details')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form id="stkAdjForm" method="POST">
                        @csrf

                        <input type="hidden" name="intno" id="intno" value="{{ $stkAdj['intno'] ?? 0 }}"/>
                        <input type="hidden" name="activeyn" id="activeyn" value="{{ $stkAdj['activeyn'] ?? 'Y' }}"/>
                        <input type="hidden" name="items" id="items_input"/>

                        <div class="form-group row">
                            <label for="" class="col-md-2">Adjustment No.</label>
                            <div class="col-md-4">
                                <input type="text" name="adjno" id="adjno" value="{{ $stkAdj['adjno'] ?? '' }}" class="form-control form-control-sm" readonly/>
                            </div>

                            <label for="adjdt" class="col-md-2 required">Adjustment Date</label>
                            <div class="col-md-4">
                                <input type="date" name="adjdt" id="adjdt" class="form-control form-control-sm {{ ($mode === 'new' || empty($stkAdj['adjdt'])) ? 'date_today' : '' }}" value="{{ old('adjdt', $stkAdj['adjdt'] ?? '') }}" autofocus required/>
                            </div>

                            <label for="" class="col-md-2 required">Department</label>
                            <div class="col-md-4">
                                <select name="" class="form-control form-control-sm select2" id="" required>
                                    @if ($mode === 'new')
                                        <option value="" selected disabled>Select</option>
                                    @endif
                                    @forelse ( $deprt as $d )
                                        <option value="{{ $d['code'] }}" {{ (($d['code'] ?? '') === ($stkAdj['departmentcd'] ?? '')) ? 'selected' : '' }}>{{ $d['name'] }}</option>
                                    @empty
                                        <option value="" selected disabled>No item data found</option>
                                    @endforelse
                                </select>
                            </div>
                            <label for="reason" class="col-md-2">Reason</label>
                            <div class="col-md-4">
                                <textarea name="reason" class="form-control form-control-sm" rows="3" id="reason">{{ old('reason', $stkAdj['reason'] ?? '') }}</textarea>
                            </div>
                            <div class="col-12">
                                <hr>
                            </div>
                            <!-- Item List -->
                            <div class="col-md-12" style="overflow:auto;">
                                <table class="table table-sm table-bordered text-xs">
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="width:10%">Raw / Finished</th>
                                            <th style="width:25%">Item</th>
                                            <th style="width:10%;text-align:right;">Qty</th>
                                            <th style="width:10%;text-align:right;">Rate</th>
                                            <th style="width:35%">Reason</th>
                                            <th style="width:10%;text-align:center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemsTbody">
                                        <tr id="addItemRow">
                                            <td colspan="6"><button type="button"
                                                    class="btn btn-sm btn-secondary btn-block" data-toggle="modal"
                                                    data-target="#adjModal"><i class="fas fa-plus-circle"></i> Add
                                                    Item</button></td>
                                        </tr>
                                        {{-- Item rows (whether they came from the API or were added by the user
                                             in this session) are rendered here dynamically by JS. See the
                                             renderItems() function below. --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <button id="saveBtn" class="btn btn-sm btn-dark float-right"><i class="fas fa-save"></i>
                            Save</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    @include('rawMaterialsInventory.transactions.stockAdjustment.popup.itemDetails', ['item' => $rawItems])

    @push('js')
        <script>
            const mode = @json($mode);

            let items = @json($stkAdj['items'] ?? []);

            // Used only to resolve an item's display name for rows that arrive
            // pre-seeded (they only carry itemcd, not a name, per your API sample).
            const itemCatalog = @json($rawItems ?? []);

            let uidCounter = 0;
            let editingUid = null;

            function toNum(v) {
                const n = parseFloat(v);
                return isNaN(n) ? 0 : n;
            }

            function findItemName(code) {
                const match = itemCatalog.find(function (x) {
                    return String(x.code) === String(code);
                });
                return match ? match.name : '';
            }

            function typeLabel(code) {
                return code === 'F' ? 'Finished' : 'Raw';
            }

            // Give every seeded row a client-side unique id, and backfill a
            // display name for the item dropdown value it carries.
            items = items.map(function (it) {
                uidCounter++;
                return Object.assign({}, it, {
                    _uid: uidCounter,
                    item_name: it.item_name || findItemName(it.itemcd)
                });
            });

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
                                '<td class="item-type"></td>' +
                                '<td class="item-name"></td>' +
                                '<td style="text-align:right;" class="item-qty"></td>' +
                                '<td style="text-align:right;" class="item-rate"></td>' +
                                '<td class="item-reason"></td>' +
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

                        row.find('.item-type').text(typeLabel(item.raw_finished));
                        row.find('.item-name').text(item.item_name || '');
                        row.find('.item-qty').text(item.qty);
                        row.find('.item-rate').text(item.rate);
                        row.find('.item-reason').text(item.reason || '');

                        $tbody.append(row);
                    });
                }

                if (mode === 'view') {
                    applyViewMode();
                }
            }

            // The modal has no <form> wrapper of its own, so add/edit/reset
            // work directly on the individual fields rather than form.reset().
            function resetPopup() {
                editingUid = null;
                $('#raw_finished').val('R').trigger('change');
                $('#itmItemcd').val('').trigger('change');
                $('#itmRate').val('');
                $('#itmQty').val('');
                $('#itmReason').val('');
            }

            function openPopupForEdit(uid) {
                const item = items.find(function (it) { return it._uid == uid; });
                if (!item) return;

                resetPopup();
                editingUid = uid;

                $('#raw_finished').val(item.raw_finished).trigger('change');
                $('#itmItemcd').val(item.itemcd).trigger('change');
                $('#itmRate').val(item.rate);
                $('#itmQty').val(item.qty);
                $('#itmReason').val(item.reason);

                $('#adjModal').modal('show');
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

            // Reset the popup to a clean "add" state whenever it finishes closing,
            // whatever caused the close (Save success, X button, backdrop click, Esc).
            $('#adjModal').on('hidden.bs.modal', function () {
                resetPopup();
            });

            $('#addBtn').on('click', function () {
                const raw_finished = $('#raw_finished').val();
                const itemcd = $('#itmItemcd').val();
                const itemName = $('#itmItemcd option:selected').text();
                const rate = toNum($('#itmRate').val());
                const qty = toNum($('#itmQty').val());
                const reason = ($('#itmReason').val() || '').trim();

                if (!raw_finished) {
                    alert('Please select item type.');
                    return;
                }
                if (!itemcd) {
                    alert('Please select an item.');
                    return;
                }
                if (qty <= 0) {
                    alert('Please enter a valid quantity.');
                    return;
                }
                if (rate <= 0) {
                    alert('Please enter a valid rate.');
                    return;
                }
                if (!reason) {
                    alert('Please enter a reason.');
                    return;
                }

                if (editingUid) {
                    const idx = items.findIndex(function (it) { return it._uid == editingUid; });
                    if (idx > -1) {
                        items[idx] = Object.assign({}, items[idx], {
                            raw_finished: raw_finished,
                            itemcd: itemcd,
                            item_name: itemName,
                            rate: rate,
                            qty: qty,
                            reason: reason
                        });
                    }
                } else {
                    uidCounter++;
                    items.push({
                        _uid: uidCounter,
                        raw_finished: raw_finished,
                        itemcd: itemcd,
                        item_name: itemName,
                        rate: rate,
                        qty: qty,
                        reason: reason
                    });
                }

                renderItems();
                $('#adjModal').modal('hide');
            });

            // Build the items JSON payload (same shape the API uses) into the
            // hidden #items_input field, right before the form gets serialized.
            function syncItemsInput() {
                const payload = items.map(function (it) {
                    return {
                        raw_finished: it.raw_finished,
                        itemcd: it.itemcd,
                        qty: it.qty,
                        reason: it.reason,
                        rate: it.rate
                    };
                });
                $('#items_input').val(JSON.stringify(payload));
            }

            $('#stkAdjForm').submit(function (e) {
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
                    url: "{{ route('rawMaterialsInventory.saveStkAdj') }}",
                    type: 'post',
                    data: formData,
                    beforeSend: function () {
                        mtd.show_msg(3, '', 'Saving, Please Wait...', 4);
                    },
                    success: function (resp) {
                        Swal.close();
                        let message = resp.message.split(/<br\s*\/?>/i)[0];

                        if (!resp.error) {
                            mtd.show_msgT(1, "{{ route('rawMaterialsInventory.stkAdjList') }}", message, 1);
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

                if (mode === 'view') {
                    applyViewMode();
                }
            });
        </script>
    @endpush

@endsection
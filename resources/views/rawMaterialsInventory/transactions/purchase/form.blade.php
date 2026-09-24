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

                        <input type="hidden" name="intno" id="intno" value="{{ $purc['intno'] ?? '' }}"/>
                        <input type="hidden" name="activeyn" id="activeyn" value="{{ $purc['activeyn'] ?? 'Y' }}"/>
                        {{-- Serialized JSON of all item rows (API rows + user-added rows) gets written here right before submit --}}
                        <input type="hidden" name="items" id="items_input"/>

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
                                <input type="date" name="trandt" id="trandt" class="form-control form-control-sm {{ ($mode === 'new' || empty($purc['trandt'])) ? 'date_today' : '' }}" value="{{ old('trandt', $purc['trandt'] ?? '') }}" required/>
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
                                <input type="date" name="partybilldt" id="partybilldt" value="{{ old('partybilldt', $purc['partybilldt'] ?? '') }}" class="form-control form-control-sm {{ ($mode === 'new' || empty($purc['partybilldt'])) ? 'date_today' : '' }}" required/>
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

                            {{-- NOTE: Gross Amount and Net Amount below still have name="" id="" in the
                                 source - they were left untouched since page-level gross/net aggregation
                                 wasn't part of this request (only the popup's per-item calculation was).
                                 They need real name/id attributes (and a formula) before they'll do anything. --}}
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

                                <tbody id="itemsTbody">
                                    <tr id="addItemRow">
                                        <td colspan="8">
                                            <button type="button" class="btn btn-sm btn-secondary btn-block" data-toggle="modal" data-target="#purchaseModal">
                                                <i class="fas fa-plus-circle"></i> Add Item 
                                            </button>
                                        </td>
                                    </tr>
                                    {{-- Item rows (whether they came from the API or were added by the user
                                         in this session) are rendered here dynamically by JS. See the
                                         renderItems() function below. --}}
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

            // Seed data: rows that already exist (came from the API / DB).
            let items = @json($purc['items'] ?? []);

            // Used only to resolve an item's display name for rows that arrive
            // pre-seeded (your API sample doesn't include a name field), and to
            // check whether an item still exists in the current list when editing.
            const itemCatalog = @json($rawItm ?? []);

            let uidCounter = 0;
            let editingUid = null;

            // Tracks, per %/₹ pair, which side the user last typed into - that
            // side is treated as the source of truth and the other side gets
            // recomputed from it whenever anything changes.
            let discMode = 'per';
            let sgstMode = 'per';
            let cgstMode = 'per';
            let igstMode = 'per';

            function toNum(v) {
                const n = parseFloat(v);
                return isNaN(n) ? 0 : n;
            }

            function round2(n) {
                return Math.round((n + Number.EPSILON) * 100) / 100;
            }

            function money(v) {
                return round2(toNum(v)).toFixed(2);
            }

            function findItemName(code) {
                const match = itemCatalog.find(function (x) {
                    return String(x.code) === String(code);
                });
                return match ? match.name : '';
            }

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
                        '<tr class="empty-row"><td colspan="8" style="text-align:center">' +
                        'No item record found. Click on <strong>Add Item</strong> button to add a record</td></tr>'
                    );
                } else {
                    items.forEach(function (item) {
                        const gstAmt = toNum(item.sgstamt) + toNum(item.cgstamt) + toNum(item.igstamt);
                        const gstPer = toNum(item.sgstper) + toNum(item.cgstper) + toNum(item.igstper);

                        const row = $(
                            '<tr class="item-row" data-uid="' + item._uid + '">' +
                                '<td class="item-name"></td>' +
                                '<td class="item-serial"></td>' +
                                '<td style="text-align:right;" class="item-rate"></td>' +
                                '<td style="text-align:right;" class="item-qty"></td>' +
                                '<td style="text-align:right;" class="item-disc"></td>' +
                                '<td style="text-align:right;" class="item-gst"></td>' +
                                '<td style="text-align:right;" class="item-amount"></td>' +
                                '<td class="dropdown text-center actionCol">' +
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

                        row.find('.item-name').text(item.item_name || '');
                        row.find('.item-serial').text(item.serialno || '');
                        row.find('.item-rate').text(money(item.rate));
                        row.find('.item-qty').text(item.qty);
                        row.find('.item-disc').text(money(item.discamt) + ' (' + money(item.discper) + '%)');
                        row.find('.item-gst').text(money(gstAmt) + ' (' + money(gstPer) + '%)');
                        row.find('.item-amount').text(money(item.amount));

                        $tbody.append(row);
                    });
                }

                if (mode === 'view') {
                    applyViewMode();
                }
            }

            // Recomputes discount, GST amounts and the final line amount from
            // whatever's currently in the popup fields, respecting each pair's
            // current mode (per vs amt) as the source of truth for that pair.
            function recalcAll() {
                const qty = toNum($('#itmQty').val());
                const rate = toNum($('#itmRate').val());
                const baseQtyRate = qty * rate;

                // Qty/Rate isn't set yet (or is 0) - there's nothing meaningful
                // to calculate from, so leave whatever's in the discount/GST
                // fields alone and don't touch Amount.
                if (baseQtyRate <= 0) {
                    return;
                }

                let discamt;
                if (discMode === 'amt') {
                    discamt = toNum($('#itmDiscamt').val());
                    const discper = round2((discamt / baseQtyRate) * 100);
                    $('#itmDiscper').val(discper.toFixed(2));
                } else {
                    const discper = toNum($('#itmDiscper').val());
                    discamt = round2(baseQtyRate * discper / 100);
                    $('#itmDiscamt').val(discamt.toFixed(2));
                }

                const baseAfterDisc = baseQtyRate - discamt;

                function syncGstPair(perSel, amtSel, gstMode) {
                    let amt;
                    if (gstMode === 'amt') {
                        amt = toNum($(amtSel).val());
                        const per = baseAfterDisc ? round2((amt / baseAfterDisc) * 100) : 0;
                        $(perSel).val(per.toFixed(2));
                    } else {
                        const per = toNum($(perSel).val());
                        amt = round2(baseAfterDisc * per / 100);
                        $(amtSel).val(amt.toFixed(2));
                    }
                    return amt;
                }

                const sgstamt = syncGstPair('#itmSgstper', '#itmSgstamt', sgstMode);
                const cgstamt = syncGstPair('#itmCgstper', '#itmCgstamt', cgstMode);
                const igstamt = syncGstPair('#itmIgstper', '#itmIgstamt', igstMode);

                const amount = round2(baseAfterDisc + sgstamt + cgstamt + igstamt);
                $('#itmAmount').val(amount.toFixed(2));
            }

            $(document).on('input', '#itmQty, #itmRate', function () {
                recalcAll();
            });

            $(document).on('input', '#itmDiscper', function () { discMode = 'per'; recalcAll(); });
            $(document).on('input', '#itmDiscamt', function () { discMode = 'amt'; recalcAll(); });
            $(document).on('input', '#itmSgstper', function () { sgstMode = 'per'; recalcAll(); });
            $(document).on('input', '#itmSgstamt', function () { sgstMode = 'amt'; recalcAll(); });
            $(document).on('input', '#itmCgstper', function () { cgstMode = 'per'; recalcAll(); });
            $(document).on('input', '#itmCgstamt', function () { cgstMode = 'amt'; recalcAll(); });
            $(document).on('input', '#itmIgstper', function () { igstMode = 'per'; recalcAll(); });
            $(document).on('input', '#itmIgstamt', function () { igstMode = 'amt'; recalcAll(); });

            // Only preselect the item if that value actually exists among the
            // dropdown's current options - otherwise fall back to the "Select"
            // placeholder (e.g. the item was deactivated after this row was created).
            function setItemSelectValue(itemcd) {
                const $select = $('#itmItemcd');
                const exists = itemcd !== '' && itemcd !== null && itemcd !== undefined &&
                    $select.find('option').toArray().some(function (opt) {
                        return String(opt.value) === String(itemcd);
                    });
                $select.val(exists ? itemcd : '').trigger('change');
            }

            function resetPopup() {
                editingUid = null;
                discMode = 'per';
                sgstMode = 'per';
                cgstMode = 'per';
                igstMode = 'per';

                setItemSelectValue('');
                $('#itmSerialno').val('');
                $('#itmQty').val('');
                $('#itmRate').val('');
                $('#itmDiscper').val('');
                $('#itmDiscamt').val('');
                $('#itmSgstper').val('');
                $('#itmSgstamt').val('');
                $('#itmCgstper').val('');
                $('#itmCgstamt').val('');
                $('#itmIgstper').val('');
                $('#itmIgstamt').val('');
                $('#itmAmount').val('');
                $('#itmItemdescr').val('');
            }

            function openPopupForEdit(uid) {
                const item = items.find(function (it) { return String(it._uid) === String(uid); });
                if (!item) return;

                resetPopup();
                editingUid = uid;

                setItemSelectValue(item.itemcd);
                $('#itmSerialno').val(item.serialno);
                $('#itmQty').val(item.qty);
                $('#itmRate').val(item.rate);
                $('#itmDiscper').val(money(item.discper));
                $('#itmDiscamt').val(money(item.discamt));
                $('#itmSgstper').val(money(item.sgstper));
                $('#itmSgstamt').val(money(item.sgstamt));
                $('#itmCgstper').val(money(item.cgstper));
                $('#itmCgstamt').val(money(item.cgstamt));
                $('#itmIgstper').val(money(item.igstper));
                $('#itmIgstamt').val(money(item.igstamt));
                $('#itmAmount').val(money(item.amount));
                $('#itmItemdescr').val(item.itemdescr || '');

                $('#purchaseModal').modal('show');
            }

            function applyViewMode() {
                $('input, textarea, select').attr('disabled', true);
                $('#saveBtn, .actionCol').hide();
                $('#addItemRow').hide();
                $('#itemsTbody .fa-bars').hide();
            }

            $(document).on('click', '.edit-item', function (e) {
                e.preventDefault();
                openPopupForEdit($(this).attr('data-uid'));
            });

            $(document).on('click', '.delete-item', function (e) {
                e.preventDefault();
                if (!confirm('Remove this item from the list?')) return;
                const uid = String($(this).attr('data-uid'));
                items = items.filter(function (it) { return String(it._uid) !== uid; });
                renderItems();
            });

            // Reset the popup to a clean "add" state whenever it finishes closing,
            // whatever caused the close (Save success, X button, backdrop click, Esc).
            $('#purchaseModal').on('hidden.bs.modal', function () {
                resetPopup();
            });

            $('#addBtn').on('click', function () {
                const itemcd = $('#itmItemcd').val();
                const itemName = $('#itmItemcd option:selected').text();
                const serialno = ($('#itmSerialno').val() || '').trim();
                const qty = toNum($('#itmQty').val());
                const rate = toNum($('#itmRate').val());
                const discper = toNum($('#itmDiscper').val());
                const discamt = toNum($('#itmDiscamt').val());
                const sgstper = toNum($('#itmSgstper').val());
                const sgstamt = toNum($('#itmSgstamt').val());
                const cgstper = toNum($('#itmCgstper').val());
                const cgstamt = toNum($('#itmCgstamt').val());
                const igstper = toNum($('#itmIgstper').val());
                const igstamt = toNum($('#itmIgstamt').val());
                const amount = toNum($('#itmAmount').val());
                const itemdescr = ($('#itmItemdescr').val() || '').trim();

                if (!itemcd) {
                    alert('Please select an item.');
                    return;
                }
                if (!serialno) {
                    alert('Please enter serial no.');
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

                const rowData = {
                    itemcd: itemcd,
                    item_name: itemName,
                    serialno: serialno,
                    itemdescr: itemdescr,
                    qty: qty,
                    rate: rate,
                    discper: discper,
                    discamt: discamt,
                    sgstper: sgstper,
                    sgstamt: sgstamt,
                    cgstper: cgstper,
                    cgstamt: cgstamt,
                    igstper: igstper,
                    igstamt: igstamt,
                    amount: amount
                };

                if (editingUid) {
                    const idx = items.findIndex(function (it) { return String(it._uid) === String(editingUid); });
                    if (idx > -1) {
                        items[idx] = Object.assign({}, items[idx], rowData);
                    }
                } else {
                    uidCounter++;
                    items.push(Object.assign({ _uid: uidCounter }, rowData));
                }

                renderItems();
                $('#purchaseModal').modal('hide');
            });

            // Build the items JSON payload (same shape the API uses) into the
            // hidden #items_input field, right before the form gets serialized.
            function syncItemsInput() {
                const payload = items.map(function (it) {
                    return {
                        itemcd: it.itemcd,
                        serialno: it.serialno,
                        itemdescr: it.itemdescr,
                        qty: it.qty,
                        rate: it.rate,
                        discper: it.discper,
                        discamt: it.discamt,
                        sgstper: it.sgstper,
                        sgstamt: it.sgstamt,
                        cgstper: it.cgstper,
                        cgstamt: it.cgstamt,
                        igstper: it.igstper,
                        igstamt: it.igstamt,
                        amount: it.amount
                    };
                });
                $('#items_input').val(JSON.stringify(payload));
            }

            $('#purchaseForm').submit(function (e) {
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
                    url: "{{ route('rawMaterialsInventory.savePurchase') }}",
                    type: 'post',
                    data: formData,
                    beforeSend: function () {
                        mtd.show_msg(3, '', 'Saving, Please Wait...', 4);
                    },
                    success: function (resp) {
                        Swal.close();
                        let message = resp.message.split(/<br\s*\/?>/i)[0];

                        if (!resp.error) {
                            mtd.show_msgT(1, "{{ route('rawMaterialsInventory.purchaseList') }}", message, 1);
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
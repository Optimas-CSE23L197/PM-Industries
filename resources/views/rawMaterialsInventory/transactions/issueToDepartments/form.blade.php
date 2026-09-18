@extends('layout.app', ['dept' => 'Raw Material Inventory'])

@section('page_title_link')
    {{ route('rawMaterialsInventory.issueToDeptList') }}
@endsection

@section('page_titleH', 'Issue To Departments')
@section('page_title', 'Details')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form id="issueToDeptForm" method="POST">
                        @csrf

                        <input type="hidden" name="intno" id="intno" value="{{ $ir['intno'] ?? '' }}"/>
                        <input type="hidden" name="activeyn" id="activeyn" value="{{ $ir['activeyn'] ?? 'Y' }}"/>
                        <input type="hidden" name="items" id="items_input"/>

                        <div class="form-group row">
                            <label for="issue_no" class="col-md-2">Issue No.</label>
                            <div class="col-md-4">
                                <input type="text" name="issue_no" id="issueno_display" class="form-control form-control-sm" value="{{ $ir['issue_no'] ?? '' }}" readonly/>
                            </div>

                            <label for="issue_date" class="col-md-2 required">Issue Date</label>
                            <div class="col-md-4">
                                <input type="date" name="issue_date" id="issue_date" class="form-control form-control-sm {{ ($mode === 'new' || empty($ir['issue_date'])) ? 'date_today' : '' }}" value="{{ old('issue_date', $ir['issue_date'] ?? '') }}" required/>
                            </div>

                            <label for="fromdeptcd" class="col-md-2 required">From Department</label>
                            <div class="col-md-4">
                                <select name="fromdeptcd" class="form-control form-control-sm select2" id="fromdeptcd" required>
                                    @if ($mode === 'new' || )
                                        <option value="" selected disabled>Select</option> 
                                    @elseif (!(collect($deprt)->contains('code', $ir['fromdeptcd'])))
                                        <option value="" selected disabled>{{ $ir['from_department_name'] }} (Department deactivated)</option>
                                    @endif
                                    @forelse ( $deprt as $d )
                                        <option value="{{ $d['code'] }}" {{ (($d['code'] ?? 0) === ($ir['fromdeptcd'] ?? 0)) ? 'selected' : '' }}>{{ $d['name'] }}</option>
                                    @empty
                                        <option value="" selected disabled>No department found active</option>
                                    @endforelse
                                </select>
                            </div>

                            <label for="todeptcd" class="col-md-2 required">To Department</label>
                            <div class="col-md-4">
                                <select name="todeptcd" class="form-control form-control-sm select2" id="todeptcd" required>
                                    @if ($mode === 'new')
                                        <option value="" selected disabled>Select</option> 
                                    @elseif (!(collect($deprt)->contains('deptcd', $ir['todeptcd'])))
                                        <option value="" selected disabled>{{ $ir['to_department_name'] }} (Department deactivated)</option>
                                    @endif
                                    @forelse ( $deprt as $d )
                                        <option value="{{ $d['code'] }}" {{ (($d['code'] ?? 0) === ($ir['todeptcd'] ?? 0)) ? 'selected' : '' }}>{{ $d['name'] }}</option>
                                    @empty
                                        <option value="" selected disabled>No department found active</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="col-12"><hr></div>

                            <!-- Item List -->
                            <div class="col-md-12" style="overflow:auto;">
                                <table class="table table-sm table-bordered text-xs">
                                    <thead class="thead-light">
                                        @if ($mode === 'view')
                                            <tr>
                                                <th style="width:70%">Item</th>
                                                <th style="width:30%;text-align:right;">Qty</th>
                                            </tr> 
                                        @else
                                            <tr>
                                                <th style="width:70%">Item</th>
                                                <th style="width:20%;text-align:right;">Qty</th>
                                                <th style="width:10%;text-align:center;">Action</th>
                                            </tr> 
                                        @endif
                                    </thead>
                                    <tbody id="itemsTbody">
                                        <tr id="addItemRow">
                                            <td colspan="3">
                                                <button type="button" class="btn btn-sm btn-secondary btn-block" data-toggle="modal" data-target="#issueModal">
                                                    <i class="fas fa-plus-circle"></i> Add Item
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <button id="saveBtn" class="btn btn-sm btn-dark float-right"><i class="fas fa-save"></i> Save</button> 
                    </form>
                </div>
            </div>
        </div>
    </section>

    @include('rawMaterialsInventory.transactions.issueToDepartments.popup.itemDetails', ['items' => $rawItm])

    @push('js')
        <script>
            const mode = @json($mode);
            let items = @json($ir['items'] ?? []);
            const itemCatalog = @json($rawItm ?? []);

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
            
            items = items.map(function (it) {
                uidCounter++;
                return Object.assign({}, it, {
                    _uid: uidCounter,
                    item_name: it.raw_item_name || it.item_name || findItemName(it.itemcd)
                });
            });

            function renderItems() {
                const $tbody = $('#itemsTbody');
                $tbody.find('tr.item-row, tr.empty-row').remove();

                if (items.length === 0) {
                    $tbody.append(
                        '<tr class="empty-row"><td colspan="3" style="text-align:center">' +
                        'No item record found. Click on <strong>Add Item</strong> button to add a record</td></tr>'
                    );
                } else {
                    items.forEach(function (item) {
                        const row = $(
                            '<tr class="item-row" data-uid="' + item._uid + '">' +
                                '<td class="item-name"></td>' +
                                '<td style="text-align:right;" class="item-qty"></td>' +
                                '<td class="dropdown text-center actionDropdown">' +
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
                        row.find('.item-qty').text(item.qty);

                        $tbody.append(row);
                    });
                }

                if (mode === 'view') {
                    applyViewMode();
                }
            }

            function setItemSelectValue(itemcd) {
                const $select = $('#itemcd');
                const exists = itemcd !== '' && itemcd !== null && itemcd !== undefined &&
                    $select.find('option').toArray().some(function (opt) {
                        return String(opt.value) === String(itemcd);
                    });
                $select.val(exists ? itemcd : '').trigger('change');
            }

            function resetPopup() {
                editingUid = null;
                setItemSelectValue('');
                $('#qty').val('');
            }

            function openPopupForEdit(uid) {
                const item = items.find(function (it) { return String(it._uid) === String(uid); });
                if (!item) return;

                resetPopup();
                editingUid = uid;

                setItemSelectValue(item.itemcd);
                $('#qty').val(item.qty);

                $('#issueModal').modal('show');
            }

            function applyViewMode() {
                $('input, textarea, select').attr('disabled', true);
                $('#saveBtn').hide();
                $('#addItemRow').hide();
                $('#itemsTbody .fa-bars, .actionDropdown').hide();
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

            $('#issueModal').on('hidden.bs.modal', function () {
                resetPopup();
            });

            $('#addBtn').on('click', function () {
                const itemcd = $('#itemcd').val();
                const itemName = $('#itemcd option:selected').text();
                const qty = toNum($('#qty').val());

                if (!itemcd) {
                    alert('Please select an item.');
                    return;
                }
                if (qty <= 0) {
                    alert('Please enter a valid quantity.');
                    return;
                }

                if (editingUid) {
                    const idx = items.findIndex(function (it) { return String(it._uid) === String(editingUid); });
                    if (idx > -1) {
                        items[idx] = Object.assign({}, items[idx], {
                            itemcd: itemcd,
                            item_name: itemName,
                            qty: qty
                        });
                    }
                } else {
                    uidCounter++;
                    items.push({
                        _uid: uidCounter,
                        intno: '',
                        issuereturnintno: '',
                        itemcd: itemcd,
                        item_name: itemName,
                        qty: qty,
                        activeyn: 'Y'
                    });
                }

                renderItems();
                $('#issueModal').modal('hide');
            });


            function syncItemsInput() {
                const payload = items.map(function (it) {
                    return {
                        intno: it.intno || '',
                        issuereturnintno: it.issuereturnintno || '',
                        itemcd: it.itemcd,
                        qty: it.qty,
                        activeyn: it.activeyn || 'Y'
                    };
                });
                $('#items_input').val(JSON.stringify(payload));
            }

            $('#issueToDeptForm').submit(function (e) {
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
                    url: "{{ route('rawMaterialsInventory.saveIssuetoDept') }}",
                    type: 'post',
                    data: formData,
                    beforeSend: function () {
                        mtd.show_msg(3, '', 'Saving, Please Wait...', 4);
                    },
                    success: function (resp) {
                        Swal.close();
                        let message = resp.message.split(/<br\s*\/?>/i)[0];

                        if (!resp.error) {
                            mtd.show_msgT(1, "{{ route('rawMaterialsInventory.issueToDeptList') }}", message, 1);
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
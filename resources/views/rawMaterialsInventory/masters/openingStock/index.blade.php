@extends('layout.app', ['dept' => 'Raw Material Inventory'])
@section('page_title', 'Opening Stock')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header py-1">
                    <label for="" class="card-title">Opening Stock</label>
                    <div class="float-right">
                        <button class="btn btn-sm btn-secondary"
                            onclick="location.href='{{ Route('rawMaterialsInventory.printOpStkList') }}'">
                            <i class="fas fa-print mr-1"></i> Print 
                        </button>
                        
                        <button class="btn btn-sm btn-dark" data-toggle="modal" data-target="#opstkModal" data-mode="add">
                            <i class="fas fa-plus-circle mr-1"></i> Add New
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="depttable" class="table table-sm table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th style="width:30%">Item</th>
                                <th style="width:15%">Type</th>
                                <th style="width:10%; text-align:right">Quantity</th>
                                <th style="width:10%; text-align:right">Rate</th>
                                <th style="width:15%">User</th>
                                <th style="width:10%; text-align:center;">Status</th>
                                <th style="width:10%; text-align:center;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ( $opstk as $o )
                                @php
                                    $status = $o['activeyn'] ?? 'N';
                                    $btnColor = $aedl = '';
                                    if ($status === 'Y') {
                                        $status = 'Active';
                                        $btnColor = 'btn-success';
                                        $aedl = 'D';
                                    } elseif ($status === 'N') {
                                        $status = 'Inactive';
                                        $btnColor = 'btn-danger';
                                        $aedl = 'U';
                                    }
                                @endphp
                               <tr>
                                    <td>{{ $o['item_name'] ?? '' }}</td>
                                    <td>{{ $o[''] ?? '' }}</td>
                                    <td style="text-align:right">{{ $o['qty'] ?? '' }}</td>
                                    <td style="text-align:right">{{ $o['rate'] ?? '' }}</td>
                                    <td>{{ $o['user_name'] ?? '' }}</td>
                                    <td>
                                        <button type='button' class="btn btn-xs {{ $btnColor }} btn-block"
                                            onclick="mtd.show_msg(2, '{{ Route('rawMaterialsInventory.opStkStatChange', ['code' => $o['intno'], 'aedl' => $aedl]) }}', 'Are you sure to change its status..?', 2);">
                                            {{ $status }}
                                        </button>
                                    </td>
                                    <td class="dropdown text-center">
                                        <i class="fas fa-bars ml-2 mr-1" data-toggle="dropdown" href="#"
                                            style="cursor:pointer"></i>
                                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                            <a href="#" class="dropdown-item" data-toggle="modal" data-target="#opstkModal"
                                            data-mode="view"
                                            data-intno="{{ $o['intno'] }}"
                                            data-item-type="{{ $o['item_type'] ?? '' }}"
                                            data-item-id="{{ $o['item_id'] ?? '' }}"
                                            data-qty="{{ $o['qty'] ?? '' }}"
                                            data-rate="{{ $o['rate'] ?? '' }}"
                                            data-activeyn="{{ $o['activeyn'] ?? 'N' }}">
                                                <div class="media">
                                                    <div class="media-body">
                                                        <p>View</p>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item" data-toggle="modal" data-target="#opstkModal"
                                            data-mode="edit"
                                            data-intno="{{ $o['intno'] }}"
                                            data-item-type="{{ $o['item_type'] ?? '' }}"
                                            data-item-id="{{ $o['item_id'] ?? '' }}"
                                            data-qty="{{ $o['qty'] ?? '' }}"
                                            data-rate="{{ $o['rate'] ?? '' }}"
                                            data-activeyn="{{ $o['activeyn'] ?? 'N' }}">
                                                <div class="media">
                                                    <div class="media-body">
                                                        <p>Edit</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </td>
                                </tr> 
                            @empty
                                <tr><td colspan="7" style="text-align:center"></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

        <! -- ========== || POPUP || =========== -- >
    @include('rawMaterialsInventory.masters.openingStock.popup.itemDetails')

    @push('js')
        <script>
        $('#opstkModal').on('show.bs.modal', function (e) {
            const $trigger = $(e.relatedTarget);
            const mode = $trigger.data('mode') || 'add';
            const $form = $('#opstkForm');

            $form[0].reset();
            $('#item_type, #item_id').val(null).trigger('change'); // resets select2 too

            if (mode !== 'add') {
                $('#intno').val($trigger.data('intno'));
                $('#item_type').val($trigger.data('item-type')).trigger('change');
                $('#item_id').val($trigger.data('item-id')).trigger('change');
                $('#qty').val($trigger.data('qty'));
                $('#rate').val($trigger.data('rate'));
                $('#activeyn').val($trigger.data('activeyn'));
            }

            const isView = mode === 'view';
            $form.find('input, select, textarea').prop('disabled', isView);
            $('#saveBtn').toggle(!isView);

            $('#opstkModalTitle').text(
                mode === 'add' ? 'Add Item' : (mode === 'view' ? 'View Item' : 'Edit Item')
            );
        });

        $('#opstkForm').on('submit', function (e) {
            e.preventDefault();
            var $saveBtn = $('#saveBtn');
            var originalBtnHtml = $saveBtn.html();
            $saveBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');

            $.ajax({
                url: "{{ Route('rawMaterialsInventory.saveOpStk') }}",
                type: 'post',
                data: $(this).serialize(),
                beforeSend: function () {
                    mtd.show_msg(3, '', 'Saving, Please Wait...', 4);
                },
                success: function (resp) {
                    Swal.close();
                    let message = resp.message.split(/<br\s*\/?>/i)[0];
                    if (!resp.error) {
                        mtd.show_msgT(1, "{{ Route('rawMaterialsInventory.opStkList') }}", message, 1);
                    } else {
                        mtd.show_msgT(0, '', message, 0);
                    }
                },
                error: function () {
                    Swal.close();
                    let message = xhr.responseJSON?.message ?? 'Something went wrong. Please try again.';
                    mtd.show_msgT(0, '', message, 0);
                },
                complete: function () {
                    $saveBtn.prop('disabled', false).html(originalBtnHtml);
                }
            });
        });
        </script>
    @endpush

@endsection
@extends('layout.app', ['dept' => 'Production'])
@section('page_title_link', route('bom'))
@section('page_titleH', 'Bill of Materials (BOM)')
@section('page_title', 'Details')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form id="bomForm" method="post">
                        @csrf
                        <input type="hidden" name="code" value="{{ $bom['code'] ?? 0 }}"/>

                        <div class="form-group row">
                            <label for="finisheditemcd" class="col-md-2 required">Finished Item</label>
                            <div class="col-md-4">
                                <select name="finisheditemcd" id="finisheditemcd"
                                        class="form-control form-control-sm select2" required autofocus
                                        {{ $vwedt == 1 ? 'disabled' : '' }}>
                                    <option value="" selected disabled>Select</option>
                                    @foreach($finishedItems as $fi)
                                        <option value="{{ $fi['code'] }}"
                                            {{ (isset($bom['finisheditemcd']) && $bom['finisheditemcd'] == $fi['code']) ? 'selected' : '' }}>
                                            {{ $fi['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <label for="qty" class="col-md-2 required">Qty</label>
                            <div class="col-md-4">
                                <input type="text" name="qty" id="qty"
                                       class="form-control form-control-sm text-right" required
                                       value="{{ $bom['qty'] ?? '' }}"
                                       {{ $vwedt == 1 ? 'disabled' : '' }}>
                            </div>

                            <div class="col-12"><hr></div>

                            <div class="col-md-12">
                                <table class="table table-sm table-bordered" id="bomDetailsTable">
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="width:80%">Raw Item</th>
                                            <th style="width:10%;text-align:right;">Qty</th>
                                            {{-- ✅ Action column hidden in View mode --}}
                                            @if($vwedt != 1)
                                                <th style="width:10%;text-align:center;">Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- ✅ Add Item button hidden in View mode --}}
                                        @if($vwedt != 1)
                                        <tr>
                                            <td colspan="3">
                                                <button type="button" class="btn btn-sm btn-secondary btn-block"
                                                        data-toggle="modal" data-target="#bomModal">
                                                    <i class="fas fa-plus-circle"></i> Add Item
                                                </button>
                                            </td>
                                        </tr>
                                        @endif

                                        @if(isset($bom['bomdtl']) && is_array($bom['bomdtl']))
                                            @foreach($bom['bomdtl'] as $index => $detail)
                                            <tr class="bom-row">
                                                <td>
                                                    {{ $detail['rawitemnm'] ?? $detail['raw_item_name'] ?? $detail['rawitemcd'] ?? '' }}
                                                    <input type="hidden" name="bomdtl[{{ $index }}][code]" value="{{ $detail['code'] ?? 0 }}">
                                                    <input type="hidden" name="bomdtl[{{ $index }}][rawitemcd]" value="{{ $detail['rawitemcd'] ?? '' }}">
                                                    <input type="hidden" name="bomdtl[{{ $index }}][activeyn]" value="{{ $detail['activeyn'] ?? 'Y' }}">
                                                </td>
                                                <td style="text-align:right;">
                                                    {{ rtrim(rtrim(number_format((float)($detail['qty'] ?? 0), 3, '.', ''), '0'), '.') }}
                                                    <input type="hidden" name="bomdtl[{{ $index }}][qty]" value="{{ $detail['qty'] ?? '' }}">
                                                </td>
                                                @if($vwedt != 1)
                                                <td class="dropdown text-center">
                                                    <i class="fas fa-bars ml-2 mr-1" data-toggle="dropdown" href="#" style="cursor:pointer"></i>
                                                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                                        <a href="#" class="dropdown-item edit-bom-row" data-index="{{ $index }}">
                                                            <div class="media"><div class="media-body"><p>Edit</p></div></div>
                                                        </a>
                                                        <div class="dropdown-divider"></div>
                                                        <a href="#" class="dropdown-item delete-bom-row" data-index="{{ $index }}">
                                                            <div class="media"><div class="media-body"><p>Delete</p></div></div>
                                                        </a>
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

        <!-- Item Details Modal -->
        <div class="modal fade" id="bomModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header py-2 bg-dark text-white">
                        <h6 class="modal-title font-weight-bold">Item Details</h6>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="modalItemForm">
                            <div class="row">
                                <label for="modal_rawitemcd" class="col-md-2 required">Raw Item</label>
                                <div class="col-md-4">
                                    <select id="modal_rawitemcd" class="form-control form-control-sm select2-modal">
                                        <option value="" selected disabled>Select</option>
                                        @foreach($rawItems as $ri)
                                            <option value="{{ $ri['code'] }}" data-name="{{ $ri['name'] }}">
                                                {{ $ri['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="modal_qty" class="col-md-2 required">Quantity</label>
                                <div class="col-md-4">
                                    <input type="text" id="modal_qty" class="form-control form-control-sm text-right">
                                </div>
                            </div>
                        </form>
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
    $(document).ready(function() {
        $('.select2').select2();
        $('.select2-modal').select2({ dropdownParent: $('#bomModal') });

        let rowIndex     = {{ isset($bom['bomdtl']) && is_array($bom['bomdtl']) ? count($bom['bomdtl']) : 0 }};
        let editRowIndex = -1;

        // ── Modal Save Button ──────────────────────────────
        $('#modalSaveBtn').click(function() {
            var rawitemcd   = $('#modal_rawitemcd').val();
            var rawitemName = $('#modal_rawitemcd option:selected').data('name');
            var qty         = $('#modal_qty').val();

            if(!rawitemcd || !qty) {
                alert('Please select item and enter quantity.');
                return;
            }

            if(editRowIndex > -1) {
                // ── Update existing row ──
                var $row = $('.bom-row').eq(editRowIndex);
                $row.find('td:eq(0)').html(
                    rawitemName +
                    '<input type="hidden" name="bomdtl['+editRowIndex+'][code]" value="'+($row.find('input[name*="[code]"]').val() || 0)+'">' +
                    '<input type="hidden" name="bomdtl['+editRowIndex+'][rawitemcd]" value="'+rawitemcd+'">' +
                    '<input type="hidden" name="bomdtl['+editRowIndex+'][activeyn]" value="Y">'
                );
                $row.find('td:eq(1)').html(
                    qty +
                    '<input type="hidden" name="bomdtl['+editRowIndex+'][qty]" value="'+qty+'">'
                );
                editRowIndex = -1;
            } else {
                // ── Add new row ──
                var newRow = `
                    <tr class="bom-row">
                        <td>
                            ${rawitemName}
                            <input type="hidden" name="bomdtl[${rowIndex}][code]" value="0">
                            <input type="hidden" name="bomdtl[${rowIndex}][rawitemcd]" value="${rawitemcd}">
                            <input type="hidden" name="bomdtl[${rowIndex}][activeyn]" value="Y">
                        </td>
                        <td style="text-align:right;">
                            ${qty}
                            <input type="hidden" name="bomdtl[${rowIndex}][qty]" value="${qty}">
                        </td>
                        <td class="dropdown text-center">
                            <i class="fas fa-bars ml-2 mr-1" data-toggle="dropdown" href="#" style="cursor:pointer"></i>
                            <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                <a href="#" class="dropdown-item edit-bom-row" data-index="${rowIndex}">
                                    <div class="media"><div class="media-body"><p>Edit</p></div></div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item delete-bom-row" data-index="${rowIndex}">
                                    <div class="media"><div class="media-body"><p>Delete</p></div></div>
                                </a>
                            </div>
                        </td>
                    </tr>`;
                $('#bomDetailsTable tbody').append(newRow);
                rowIndex++;
            }

            // Reset & close modal
            $('#modalItemForm')[0].reset();
            $('#modal_rawitemcd').val(null).trigger('change');
            $('#bomModal').modal('hide');
        });

        $(document).on('click', '.edit-bom-row', function(e) {
            e.preventDefault();
            editRowIndex = $(this).data('index');
            var $row = $('.bom-row').eq(editRowIndex);

            var rawitemcd = $row.find('input[name*="[rawitemcd]"]').val();
            var qty       = $row.find('input[name*="[qty]"]').val();

            $('#modal_rawitemcd').val(rawitemcd).trigger('change');
            $('#modal_qty').val(qty);
            $('#bomModal').modal('show');
        });

        $(document).on('click', '.delete-bom-row', function(e) {
            e.preventDefault();
            if(confirm('Are you sure you want to delete this item?')) {
                $(this).closest('tr').remove();
            }
        });

        $('#bomForm').submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url : '/production/save-bom',
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
                    var message = resp.message || 'Something went wrong!';

                    if (!isError) {
                        let msg = resp.message.split(/<br\s*\/?>/i)[0];
                        mtd.show_msgT(1, '/production/bom', msg, 1);
                    } else {
                        mtd.show_msgT(0, '', message, 0);
                    }
                },
                error: function (xhr) {
                    Swal.close();
                    mtd.show_msgT(0, '', 'Something went wrong!', 0);
                }
            });
        });
    });
</script>
@endpush
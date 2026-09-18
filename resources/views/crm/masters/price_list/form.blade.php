@extends('layout.app', ['dept' => 'CRM'])
@section('page_title_link', route('priceList'))
@section('page_titleH', 'Price List')
@section('page_title', 'Details')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form id="priceListForm" method="post">
                        @csrf
                        <input type="hidden" name="code" value="{{ $priceList['code'] ?? 0 }}"/>

                        <div class="form-group row">
                            <label for="name" class="col-md-2 required">Name</label>
                            <div class="col-md-4">
                                <input type="text" name="name" id="name"
                                       class="form-control form-control-sm" autofocus required
                                       value="{{ $priceList['name'] ?? '' }}"
                                       {{ $vwedt == 1 ? 'readonly' : '' }}/>
                            </div>

                            <label for="valid_from" class="col-md-2">Valid From</label>
                            <div class="col-md-4">
                                <input type="date" name="valid_from" id="valid_from"
                                       class="form-control form-control-sm"
                                       value="{{ $priceList['valid_from'] ?? '' }}"
                                       {{ $vwedt == 1 ? 'readonly' : '' }}/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="valid_to" class="col-md-2">Valid To</label>
                            <div class="col-md-4">
                                <input type="date" name="valid_to" id="valid_to"
                                       class="form-control form-control-sm"
                                       value="{{ $priceList['valid_to'] ?? '' }}"
                                       {{ $vwedt == 1 ? 'readonly' : '' }}/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <table class="table table-sm table-bordered" id="priceListDetails">
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="width:40%">Finished Item</th>
                                            <th style="width:20%;text-align:right;">Rate</th>
                                            <th style="width:15%;text-align:right;">Min Qty</th>
                                            @if($vwedt != 1)
                                            <th style="width:15%;text-align:center;">Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($vwedt != 1)
                                        <tr>
                                            <td colspan="4">
                                                <button type="button" class="btn btn-sm btn-secondary btn-block"
                                                        data-toggle="modal" data-target="#priceListModal">
                                                    <i class="fas fa-plus-circle"></i> Add Item
                                                </button>
                                            </td>
                                        </tr>
                                        @endif

                                        @if(isset($details) && is_array($details))
                                            @foreach($details as $index => $d)
                                            <tr class="detail-row">
                                                <td>
                                                    {{ $d['finisheditemnm'] ?? $d['finisheditemcd'] ?? '' }}
                                                    <input type="hidden" name="details[{{ $index }}][detail_code]"    value="{{ $d['detail_code'] ?? 0 }}">
                                                    <input type="hidden" name="details[{{ $index }}][finisheditemcd]" value="{{ $d['finisheditemcd'] ?? '' }}">
                                                    <input type="hidden" name="details[{{ $index }}][activeyn]"       value="{{ $d['activeyn'] ?? 'Y' }}">
                                                </td>
                                                <td style="text-align:right;">
                                                    {{ rtrim(rtrim(number_format((float)($d['rate'] ?? 0), 4, '.', ''), '0'), '.') }}
                                                    <input type="hidden" name="details[{{ $index }}][rate]" value="{{ $d['rate'] ?? '' }}">
                                                </td>
                                                <td style="text-align:right;">
                                                    {{ rtrim(rtrim(number_format((float)($d['min_qty'] ?? 0), 3, '.', ''), '0'), '.') }}
                                                    <input type="hidden" name="details[{{ $index }}][min_qty]" value="{{ $d['min_qty'] ?? '' }}">
                                                </td>
                                                @if($vwedt != 1)
                                                <td class="dropdown text-center">
                                                    <i class="fas fa-bars ml-2 mr-1" data-toggle="dropdown" href="#" style="cursor:pointer"></i>
                                                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                                        <a href="#" class="dropdown-item edit-detail-row" data-index="{{ $index }}">
                                                            <div class="media"><div class="media-body"><p>Edit</p></div></div>
                                                        </a>
                                                        <div class="dropdown-divider"></div>
                                                        <a href="#" class="dropdown-item delete-detail-row" data-index="{{ $index }}">
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
        <div class="modal fade" id="priceListModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
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
                                <label for="modal_finisheditemcd" class="col-md-2 required">Finished Item</label>
                                <div class="col-md-4">
                                    <select id="modal_finisheditemcd" class="form-control form-control-sm select2-modal">
                                        <option value="" selected disabled>Select</option>
                                        @foreach($finishedItems as $fi)
                                            <option value="{{ $fi['code'] }}" data-name="{{ $fi['name'] }}">
                                                {{ $fi['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="modal_rate" class="col-md-2 required">Rate</label>
                                <div class="col-md-4">
                                    <input type="number" step="0.01" id="modal_rate" class="form-control form-control-sm text-right">
                                </div>
                                <label for="modal_min_qty" class="col-md-2 mt-2">Min Qty</label>
                                <div class="col-md-4 mt-2">
                                    <input type="number" step="0.01" id="modal_min_qty" class="form-control form-control-sm text-right">
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
        $('.select2-modal').select2({ dropdownParent: $('#priceListModal') });

        let rowIndex     = {{ isset($details) && is_array($details) ? count($details) : 0 }};
        let editRowIndex = -1;

        // ── Modal Save ─────────────────────────────────
        $('#modalSaveBtn').click(function() {
            var itemcd   = $('#modal_finisheditemcd').val();
            var itemName = $('#modal_finisheditemcd option:selected').data('name');
            var rate     = $('#modal_rate').val();
            var min_qty  = $('#modal_min_qty').val();

            if(!itemcd || !rate) {
                alert('Please select item and enter rate.');
                return;
            }

            if(editRowIndex > -1) {
                var $row = $('.detail-row').eq(editRowIndex);
                $row.find('td:eq(0)').html(
                    itemName +
                    '<input type="hidden" name="details['+editRowIndex+'][detail_code]" value="'+($row.find('input[name*="[detail_code]"]').val() || 0)+'">' +
                    '<input type="hidden" name="details['+editRowIndex+'][finisheditemcd]" value="'+itemcd+'">' +
                    '<input type="hidden" name="details['+editRowIndex+'][activeyn]" value="Y">'
                );
                $row.find('td:eq(1)').html(rate + '<input type="hidden" name="details['+editRowIndex+'][rate]" value="'+rate+'">');
                $row.find('td:eq(2)').html(min_qty + '<input type="hidden" name="details['+editRowIndex+'][min_qty]" value="'+min_qty+'">');
                editRowIndex = -1;
            } else {
                var newRow = `
                    <tr class="detail-row">
                        <td>
                            ${itemName}
                            <input type="hidden" name="details[${rowIndex}][detail_code]" value="0">
                            <input type="hidden" name="details[${rowIndex}][finisheditemcd]" value="${itemcd}">
                            <input type="hidden" name="details[${rowIndex}][activeyn]" value="Y">
                        </td>
                        <td style="text-align:right;">${rate}<input type="hidden" name="details[${rowIndex}][rate]" value="${rate}"></td>
                        <td style="text-align:right;">${min_qty}<input type="hidden" name="details[${rowIndex}][min_qty]" value="${min_qty}"></td>
                        <td class="dropdown text-center">
                            <i class="fas fa-bars ml-2 mr-1" data-toggle="dropdown" href="#" style="cursor:pointer"></i>
                            <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                <a href="#" class="dropdown-item edit-detail-row" data-index="${rowIndex}">
                                    <div class="media"><div class="media-body"><p>Edit</p></div></div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item delete-detail-row" data-index="${rowIndex}">
                                    <div class="media"><div class="media-body"><p>Delete</p></div></div>
                                </a>
                            </div>
                        </td>
                    </tr>`;
                $('#priceListDetails tbody').append(newRow);
                rowIndex++;
            }

            $('#modalItemForm')[0].reset();
            $('#modal_finisheditemcd').val(null).trigger('change');
            $('#priceListModal').modal('hide');
        });

        // ── Edit Row ───────────────────────────────────
        $(document).on('click', '.edit-detail-row', function(e) {
            e.preventDefault();
            editRowIndex = $(this).data('index');
            var $row = $('.detail-row').eq(editRowIndex);

            $('#modal_finisheditemcd').val($row.find('input[name*="[finisheditemcd]"]').val()).trigger('change');
            $('#modal_rate').val($row.find('input[name*="[rate]"]').val());
            $('#modal_min_qty').val($row.find('input[name*="[min_qty]"]').val());
            $('#priceListModal').modal('show');
        });

        // ── Delete Row ─────────────────────────────────
        $(document).on('click', '.delete-detail-row', function(e) {
            e.preventDefault();
            if(confirm('Are you sure you want to delete this item?')) {
                $(this).closest('tr').remove();
            }
        });

        // ── Form Submit ────────────────────────────────
        $('#priceListForm').submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url : '/crm/save-price-list',
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
                        mtd.show_msgT(1, '/crm/price-list', msg, 1);
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
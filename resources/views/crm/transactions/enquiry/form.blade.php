@extends('layout.app', ['dept' => 'CRM'])
@section('page_title_link', route('enquiry'))
@section('page_titleH', 'Enquiry')
@section('page_title', 'Details')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form id="enquiryForm" method="post">
                        @csrf
                        <input type="hidden" name="intno" value="{{ $enquiry['intno'] ?? 0 }}"/>

                        <div class="form-group row">
                            <label class="col-md-2">Enquiry No.</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control form-control-sm"
                                       value="{{ $enquiry['enquiry_no'] ?? '' }}" disabled>
                            </div>

                            <label class="col-md-2 required">Enquiry Date</label>
                            <div class="col-md-4">
                                <input type="date" name="enquiry_date" id="enquiry_date"
                                       class="form-control form-control-sm" required autofocus
                                       value="{{ old('enquiry_date', $enquiry['enquiry_date'] ?? date('Y-m-d')) }}"
                                       {{ $vwedt == 1 ? 'readonly' : '' }}/>
                            </div>

                            <label class="col-md-2 required">Customer</label>
                            <div class="col-md-4">
                                <select name="customercd" id="customercd"
                                        class="form-control form-control-sm select2" required
                                        {{ $vwedt == 1 ? 'disabled' : '' }}>
                                    <option value="" selected disabled>Select</option>
                                    @foreach($customers as $c)
                                        <option value="{{ $c['code'] }}"
                                            {{ ($enquiry['customercd'] ?? '') == $c['code'] ? 'selected' : '' }}>
                                            {{ $c['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <label class="col-md-2 required">Lead Source</label>
                            <div class="col-md-4">
                                <select name="leadsourcecd" id="leadsourcecd"
                                        class="form-control form-control-sm select2" required
                                        {{ $vwedt == 1 ? 'disabled' : '' }}>
                                    <option value="" selected disabled>Select</option>
                                    @foreach($leadSources as $ls)
                                        <option value="{{ $ls['code'] }}"
                                            {{ ($enquiry['leadsourcecd'] ?? '') == $ls['code'] ? 'selected' : '' }}>
                                            {{ $ls['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <label class="col-md-2 required">Expected Order Date</label>
                            <div class="col-md-4">
                                <input type="date" name="expected_order_date" id="expected_order_date"
                                       class="form-control form-control-sm" required
                                       value="{{ old('expected_order_date', $enquiry['expected_order_date'] ?? '') }}"
                                       {{ $vwedt == 1 ? 'readonly' : '' }}/>
                            </div>

                            <label class="col-md-2">Status</label>
                            <div class="col-md-4">
                                <input type="text" name="status" id="status"
                                       class="form-control form-control-sm"
                                       value="{{ old('status', $enquiry['status'] ?? 'OPEN') }}"
                                       {{ $vwedt == 1 ? 'readonly' : '' }}/>
                            </div>

                            <label class="col-md-2 required">Remarks</label>
                            <div class="col-md-4">
                                <textarea name="remarks" id="remarks" rows="3"
                                          class="form-control form-control-sm"
                                          {{ $vwedt == 1 ? 'readonly' : '' }}>{{ old('remarks', $enquiry['remarks'] ?? '') }}</textarea>
                            </div>

                            <div class="col-12"><hr></div>

                            <div class="col-md-12">
                                <table class="table table-sm table-bordered text-xs" id="itemsTable">
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="width:25%">Finished Item</th>
                                            <th style="width:10%">Size</th>
                                            <th style="width:10%;text-align:right;">Quantity</th>
                                            <th style="width:10%;text-align:right;">Target Rate</th>
                                            <th style="width:25%">Remarks</th>
                                            @if($vwedt != 1)
                                            <th style="width:10%;text-align:center;">Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($vwedt != 1)
                                        <tr>
                                            <td colspan="6">
                                                <button type="button" class="btn btn-sm btn-secondary btn-block"
                                                        data-toggle="modal" data-target="#enquiryModal">
                                                    <i class="fas fa-plus-circle"></i> Add Item
                                                </button>
                                            </td>
                                        </tr>
                                        @endif

                                        @if(isset($enquiry['items']) && is_array($enquiry['items']))
                                            @foreach($enquiry['items'] as $index => $item)
                                            <tr class="item-row">
                                                <td>
                                                    {{ $item['finished_item_name'] ?? '' }}
                                                    <input type="hidden" name="items[{{ $index }}][finisheditemcd]" value="{{ $item['finisheditemcd'] ?? '' }}">
                                                </td>
                                                <td>
                                                    {{ $item['size_name'] ?? '' }}
                                                    <input type="hidden" name="items[{{ $index }}][sizecd]" value="{{ $item['sizecd'] ?? '' }}">
                                                </td>
                                                <td style="text-align:right;">
                                                    {{ rtrim(rtrim(number_format((float)($item['qty'] ?? 0), 3, '.', ''), '0'), '.') }}
                                                    <input type="hidden" name="items[{{ $index }}][qty]" value="{{ $item['qty'] ?? '' }}">
                                                </td>
                                                <td style="text-align:right;">
                                                    {{ number_format((float)($item['target_rate'] ?? 0), 2) }}
                                                    <input type="hidden" name="items[{{ $index }}][target_rate]" value="{{ $item['target_rate'] ?? '' }}">
                                                </td>
                                                <td>{{ $item['remarks'] ?? '' }}</td>
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

        {{-- Item Modal --}}
        <div class="modal fade" id="enquiryModal" tabindex="-1" role="dialog" aria-hidden="true">
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
                            <label class="col-md-2 required">Finished Item</label>
                            <div class="col-md-4">
                                <select id="modal_finisheditemcd" class="form-control form-control-sm select2-modal">
                                    <option value="" selected disabled>Select</option>
                                    @foreach($finishedItems as $fi)
                                        <option value="{{ $fi['code'] }}" data-name="{{ $fi['name'] }}">{{ $fi['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <label class="col-md-2 required">Size</label>
                            <div class="col-md-4">
                                <select id="modal_sizecd" class="form-control form-control-sm select2-modal">
                                    <option value="" selected disabled>Select</option>
                                    @foreach($itemSizes as $s)
                                        <option value="{{ $s['code'] }}" data-name="{{ $s['name'] }}">{{ $s['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <label class="col-md-2 required">Quantity</label>
                            <div class="col-md-4">
                                <input type="number" step="0.01" id="modal_qty" class="form-control form-control-sm text-right" required>
                            </div>

                            <label class="col-md-2 required">Target Rate</label>
                            <div class="col-md-4">
                                <input type="number" step="0.01" id="modal_target_rate" class="form-control form-control-sm text-right" required>
                            </div>

                            <label class="col-md-2">Remarks</label>
                            <div class="col-md-4">
                                <textarea id="modal_remarks" class="form-control form-control-sm" rows="3"></textarea>
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
    $(document).ready(function() {
        $('.select2').select2();
        $('.select2-modal').select2({ dropdownParent: $('#enquiryModal') });

        let rowIndex     = {{ isset($enquiry['items']) && is_array($enquiry['items']) ? count($enquiry['items']) : 0 }};
        let editRowIndex = -1;

        // Modal Save
        $('#modalSaveBtn').click(function() {
            var itemcd   = $('#modal_finisheditemcd').val();
            var itemName = $('#modal_finisheditemcd option:selected').data('name');
            var sizecd   = $('#modal_sizecd').val();
            var sizeName = $('#modal_sizecd option:selected').data('name');
            var qty      = $('#modal_qty').val();
            var rate     = $('#modal_target_rate').val();
            var remarks  = $('#modal_remarks').val();

            if (!itemcd || !sizecd || !qty || !rate) {
                alert('Please fill all required fields.');
                return;
            }

            if (editRowIndex > -1) {
                var $row = $('.item-row').eq(editRowIndex);
                $row.find('td:eq(0)').html(itemName + '<input type="hidden" name="items['+editRowIndex+'][finisheditemcd]" value="'+itemcd+'">');
                $row.find('td:eq(1)').html(sizeName + '<input type="hidden" name="items['+editRowIndex+'][sizecd]" value="'+sizecd+'">');
                $row.find('td:eq(2)').html(qty + '<input type="hidden" name="items['+editRowIndex+'][qty]" value="'+qty+'">');
                $row.find('td:eq(3)').html(rate + '<input type="hidden" name="items['+editRowIndex+'][target_rate]" value="'+rate+'">');
                $row.find('td:eq(4)').html(remarks);
                editRowIndex = -1;
            } else {
                var newRow = `
                    <tr class="item-row">
                        <td>${itemName}<input type="hidden" name="items[${rowIndex}][finisheditemcd]" value="${itemcd}"></td>
                        <td>${sizeName}<input type="hidden" name="items[${rowIndex}][sizecd]" value="${sizecd}"></td>
                        <td style="text-align:right;">${qty}<input type="hidden" name="items[${rowIndex}][qty]" value="${qty}"></td>
                        <td style="text-align:right;">${rate}<input type="hidden" name="items[${rowIndex}][target_rate]" value="${rate}"></td>
                        <td>${remarks}</td>
                        <td class="dropdown text-center">
                            <i class="fas fa-bars ml-2 mr-1" data-toggle="dropdown" href="#" style="cursor:pointer"></i>
                            <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                <a href="#" class="dropdown-item edit-item-row" data-index="${rowIndex}"><p>Edit</p></a>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item delete-item-row" data-index="${rowIndex}"><p>Delete</p></a>
                            </div>
                        </td>
                    </tr>`;
                $('#itemsTable tbody').append(newRow);
                rowIndex++;
            }

            // Reset
            $('#modal_finisheditemcd').val(null).trigger('change');
            $('#modal_sizecd').val(null).trigger('change');
            $('#modal_qty').val('');
            $('#modal_target_rate').val('');
            $('#modal_remarks').val('');
            $('#enquiryModal').modal('hide');
        });

        // Edit Row
        $(document).on('click', '.edit-item-row', function(e) {
            e.preventDefault();
            editRowIndex = $(this).data('index');
            var $row = $('.item-row').eq(editRowIndex);

            $('#modal_finisheditemcd').val($row.find('input[name*="[finisheditemcd]"]').val()).trigger('change');
            $('#modal_sizecd').val($row.find('input[name*="[sizecd]"]').val()).trigger('change');
            $('#modal_qty').val($row.find('input[name*="[qty]"]').val());
            $('#modal_target_rate').val($row.find('input[name*="[target_rate]"]').val());
            $('#modal_remarks').val($row.find('td:eq(4)').text().trim());
            $('#enquiryModal').modal('show');
        });

        // Delete Row
        $(document).on('click', '.delete-item-row', function(e) {
            e.preventDefault();
            if (confirm('Delete this item?')) {
                $(this).closest('tr').remove();
            }
        });

        // Form Submit
        $('#enquiryForm').submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url : '/crm/save-enquiry',
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                beforeSend: function () { mtd.show_msg(3, '', 'Saving, Please Wait...', 4); },
                success: function (resp) {
                    Swal.close();
                    var isError = !!resp.error;

                    var message = resp.data && resp.data.message
                                    ? resp.data.message
                                    : (resp.message || 'Saved successfully!');

                    if (!isError) {
                        let msg = message.split(/<br\s*\/?>/i)[0];
                        mtd.show_msgT(1, '/crm/enquiry', msg, 1);
                    } else {
                        mtd.show_msgT(0, '', message, 0);
                    }
                },
                error: function (xhr) {
                    Swal.close();
                    mtd.show_msgT(0, '', 'Something went wrong!', 0);
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
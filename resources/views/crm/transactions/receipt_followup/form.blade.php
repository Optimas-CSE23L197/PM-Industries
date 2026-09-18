@extends('layout.app', ['dept' => 'CRM'])
@section('page_title_link', route('receiptFollowup'))
@section('page_titleH', 'Receipt Followup')
@section('page_title', 'Details')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form id="receiptFollowupForm" method="post">
                        @csrf
                        <input type="hidden" name="intno" value="{{ $followup['intno'] ?? 0 }}"/>

                        <div class="form-group row">
                            <label for="followup_date" class="col-md-2 required">Followup Date</label>
                            <div class="col-md-4">
                                <input type="date" name="followup_date" id="followup_date"
                                       class="form-control form-control-sm date_today" required autofocus
                                       value="{{ old('followup_date', isset($followup['followup_date']) && $followup['followup_date'] ? date('Y-m-d', strtotime($followup['followup_date'])) : date('Y-m-d')) }}"
                                       {{ $vwedt == 1 ? 'readonly' : '' }}/>
                            </div>

                            <label for="partycd" class="col-md-2 required">Customer</label>
                            <div class="col-md-4">
                                <select name="partycd" id="partycd"
                                        class="form-control form-control-sm select2" required
                                        {{ ($vwedt == 1 || $vwedt == 3 || $vwedt == 4) ? 'disabled' : '' }}>
                                    <option value="" selected disabled>Select</option>
                                    @foreach($customers as $c)
                                        <option value="{{ $c['code'] }}"
                                            {{ ($followup['partycd'] ?? '') == $c['code'] ? 'selected' : '' }}>
                                            {{ $c['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @if($vwedt == 1 || $vwedt == 3 || $vwedt == 4)
                                    <input type="hidden" name="partycd" value="{{ $followup['partycd'] ?? '' }}">
                                @endif
                            </div>

                            <label for="billintno" class="col-md-2 required">Invoice No.</label>
                            <div class="col-md-4">
                                <select name="billintno" id="billintno"
                                        class="form-control form-control-sm select2" required
                                        {{ ($vwedt == 1 || $vwedt == 3 || $vwedt == 4) ? 'disabled' : '' }}>
                                    <option value="" selected disabled>Select</option>
                                    @foreach($invoices as $inv)
                                        <option value="{{ $inv['intno'] }}"
                                            data-trandt="{{ $inv['trandt'] ?? '' }}"
                                            data-amount="{{ $inv['basic'] ?? 0 }}"
                                            data-partycd="{{ $inv['partycd'] ?? '' }}"
                                            data-customer="{{ $inv['customer_name'] ?? $inv['party_name'] ?? '' }}"
                                            data-dueamt="{{ $inv['dueamt'] ?? 0 }}"
                                            {{ ($followup['billintno'] ?? '') == $inv['intno'] ? 'selected' : '' }}>
                                            {{ $inv['tranno'] ?? '' }} - {{ $inv['customer_name'] ?? $inv['party_name'] ?? '' }} - {{ $inv['trandt'] ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @if($vwedt == 1 || $vwedt == 3 || $vwedt == 4)
                                    <input type="hidden" name="billintno" value="{{ $followup['billintno'] ?? '' }}">
                                @endif
                            </div>

                            <label class="col-md-2">Invoice Date &amp; Amount</label>
                            <div class="col-md-4">
                                <div class="btn-group w-100">
                                    <input type="date" id="invoice_date" class="form-control form-control-sm" disabled
                                           value="{{ $followup['invoice_date'] ?? '' }}">
                                    <input type="text" id="invoice_amount" class="form-control form-control-sm text-right" disabled
                                           value="{{ $followup['invoice_amount'] ?? '' }}">
                                </div>
                            </div>

                            <label class="col-md-2">Total Due Amount</label>
                            <div class="col-md-4">
                                <input type="text" id="due_amount" class="form-control form-control-sm text-right" disabled
                                       value="{{ $followup['due_amount'] ?? '' }}">
                            </div>

                            <label for="next_followup_date" class="col-md-2">Next Followup Date</label>
                            <div class="col-md-4">
                                <input type="date" name="next_followup_date" id="next_followup_date"
                                       class="form-control form-control-sm"
                                       value="{{ old('next_followup_date', $followup['next_followup_date'] ?? '') }}"
                                       {{ $vwedt == 1 ? 'readonly' : '' }}/>
                            </div>

                            <label for="status" class="col-md-2 required">Status</label>
                            <div class="col-md-4">
                                <select name="status" id="status" class="form-control form-control-sm"
                                        {{ $vwedt == 1 ? 'disabled' : '' }}>
                                    <option value="PENDING"   {{ ($followup['status'] ?? 'PENDING') == 'PENDING'   ? 'selected' : '' }}>PENDING</option>
                                    <option value="COMPLETED" {{ ($followup['status'] ?? '') == 'COMPLETED' ? 'selected' : '' }}>COMPLETED</option>
                                    <option value="CANCELLED" {{ ($followup['status'] ?? '') == 'CANCELLED' ? 'selected' : '' }}>CANCELLED</option>
                                </select>
                                @if($vwedt == 1)
                                    <input type="hidden" name="status" value="{{ $followup['status'] ?? 'PENDING' }}">
                                @endif
                            </div>

                            <label for="remarks" class="col-md-2">Remarks</label>
                            <div class="col-md-4">
                                <textarea name="remarks" id="remarks" rows="3"
                                          class="form-control form-control-sm"
                                          {{ $vwedt == 1 ? 'readonly' : '' }}>{{ old('remarks', $followup['remarks'] ?? '') }}</textarea>
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
    </section>

@endsection

@push('js')
<script>
    $(document).ready(function () {
        $('.select2').select2();

        // ✅ Auto-fill invoice details when invoice selected
        $('#billintno').on('change', function () {
            var $opt = $(this).find('option:selected');
            $('#invoice_date').val($opt.data('trandt') || '');
            $('#invoice_amount').val($opt.data('amount') || '');
            $('#due_amount').val($opt.data('dueamt') || '');
            // auto-select customer
            if ($opt.data('partycd')) {
                $('#partycd').val($opt.data('partycd')).trigger('change');
            }
        });

        // Trigger on page load if editing
        if ($('#billintno').val()) {
            $('#billintno').trigger('change');
        }

        $('#receiptFollowupForm').submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url : '/crm/save-receipt-followup',
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
                    var message = (resp.data && resp.data.message)
                                    ? resp.data.message
                                    : (resp.message || 'Saved successfully!');

                    if (!isError) {
                        let msg = message.split(/<br\s*\/?>/i)[0];
                        mtd.show_msgT(1, '/crm/receipt-followup', msg, 1);
                    } else {
                        mtd.show_msgT(0, '', message, 0);
                    }
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
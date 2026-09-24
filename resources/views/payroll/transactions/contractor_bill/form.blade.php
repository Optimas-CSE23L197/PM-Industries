@extends('layout.app', ['dept' => 'Payroll'])
@section('page_title_link', route('payroll.contractorBill'))
@section('page_titleH', 'Contractor Bill')
@section('page_title', 'Details')

@section('content')

<section class="content mt-3">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form id="contractorBillForm" method="post">
                    @csrf
                    <input type="hidden" name="intno" value="{{ $bill['intno'] ?? 0 }}"/>

                    <div class="form-group row">
                        <label for="bill_no" class="col-md-2">Bill No.</label>
                        <div class="col-md-4">
                            <input type="text" name="bill_no" id="bill_no"
                                   class="form-control form-control-sm" disabled
                                   value="{{ $bill['bill_no'] ?? '' }}">
                        </div>

                        <label for="bill_date" class="col-md-2 required">Bill Date</label>
                        <div class="col-md-4">
                            <input type="date" name="bill_date" id="bill_date"
                                   class="form-control form-control-sm date_today" required autofocus
                                   value="{{ $bill['bill_date'] ?? date('Y-m-d') }}"
                                   {{ $vwedt == 1 ? 'disabled' : '' }}>
                        </div>

                        <label for="contractorcd" class="col-md-2 required">Contractor</label>
                        <div class="col-md-4">
                            <select name="contractorcd" id="contractorcd"
                                    class="form-control form-control-sm select2" required
                                    {{ $vwedt == 1 ? 'disabled' : '' }}>
                                <option value="" selected disabled>Select</option>
                                @foreach($contractors as $c)
                                    <option value="{{ $c['code'] }}"
                                        {{ (isset($bill['contractorcd']) && $bill['contractorcd'] == $c['code']) ? 'selected' : '' }}>
                                        {{ $c['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <label for="gross_amount" class="col-md-2 required">Gross Amount</label>
                        <div class="col-md-4">
                            <input type="text" name="gross_amount" id="gross_amount"
                                   class="form-control form-control-sm text-right" required
                                   value="{{ $bill['gross_amount'] ?? '' }}"
                                   {{ $vwedt == 1 ? 'disabled' : '' }}>
                        </div>

                        <label for="advance_adjustment" class="col-md-2">Adv. Adj. Amount</label>
                        <div class="col-md-4">
                            <input type="text" name="advance_adjustment" id="advance_adjustment"
                                   class="form-control form-control-sm text-right"
                                   value="{{ $bill['advance_adjustment'] ?? '' }}"
                                   {{ $vwedt == 1 ? 'disabled' : '' }}>
                        </div>

                        <label for="net_amount" class="col-md-2">Net Amount</label>
                        <div class="col-md-4">
                            <input type="text" name="net_amount" id="net_amount"
                                   class="form-control form-control-sm text-right" disabled
                                   value="{{ $bill['net_amount'] ?? '' }}">
                        </div>

                        <div class="col-12"><hr></div>

                        <label for="approval_status" class="col-md-2 required">Approval Status</label>
                        <div class="col-md-4">
                            <select name="approval_status" id="approval_status"
                                    class="form-control form-control-sm" required
                                    {{ $vwedt == 1 ? 'disabled' : '' }}>
                                <option value="PENDING"  {{ ($bill['approval_status'] ?? 'PENDING') == 'PENDING'  ? 'selected' : '' }}>Pending</option>
                                <option value="APPROVED" {{ ($bill['approval_status'] ?? '') == 'APPROVED' ? 'selected' : '' }}>Approved</option>
                                <option value="REJECTED" {{ ($bill['approval_status'] ?? '') == 'REJECTED' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>

                        <label for="approved_by" class="col-md-2">Approved By</label>
                        <div class="col-md-4">
                            <input type="text" name="approved_by" id="approved_by"
                                   class="form-control form-control-sm"
                                   value="{{ $bill['approved_by'] ?? '' }}"
                                   {{ $vwedt == 1 ? 'disabled' : '' }}>
                        </div>

                        <label for="approved_at" class="col-md-2">Approved At</label>
                        <div class="col-md-4">
                            <input type="datetime-local" name="approved_at" id="approved_at"
                                   class="form-control form-control-sm date_time_today" disabled
                                   value="{{ !empty($bill['approved_at']) ? date('Y-m-d\TH:i', strtotime($bill['approved_at'])) : '' }}">
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

        function calcNet() {
            var gross = parseFloat($('#gross_amount').val()) || 0;
            var adv   = parseFloat($('#advance_adjustment').val()) || 0;
            $('#net_amount').val((gross - adv).toFixed(2));
        }

        $('#gross_amount, #advance_adjustment').on('keyup change', calcNet);
        calcNet();

        $('#contractorBillForm').submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: '/payroll/save-contractor-bill',
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

                    var isError = false;
                    var message = '';

                    if (resp.data && typeof resp.data === 'object' && resp.data.message) {
                        isError = resp.data.status === 1 ? false : true;
                        message = resp.data.message;
                    } else {
                        isError = !!resp.error;
                        message = resp.message || 'Something went wrong!';
                    }

                    if (!isError) {
                        let msg = message.split(/<br\s*\/?>/i)[0];
                        mtd.show_msgT(1, '/payroll/contractor-bill', msg, 1);
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
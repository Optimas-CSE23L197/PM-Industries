@extends('layout.app', ['dept' => 'Payroll'])
@section('page_title_link', route('payroll.workerAdvance'))
@section('page_titleH', 'Advance to Worker')
@section('page_title', 'Details')

@section('content')

<section class="content mt-3">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form id="workerAdvanceForm" method="post">
                    @csrf
                    <input type="hidden" name="intno" value="{{ $advance['intno'] ?? 0 }}"/>

                    <div class="form-group row">
                        <label for="advance_no" class="col-md-2">Advance No.</label>
                        <div class="col-md-4">
                            <input type="text" name="advance_no" id="advance_no"
                                   class="form-control form-control-sm" disabled
                                   value="{{ $advance['advance_no'] ?? '' }}">
                        </div>

                        <label for="advance_date" class="col-md-2 required">Advance Date</label>
                        <div class="col-md-4">
                            <input type="date" name="advance_date" id="advance_date"
                                   class="form-control form-control-sm date_today" required autofocus
                                   value="{{ $advance['advance_date'] ?? date('Y-m-d') }}"
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
                                        {{ (isset($advance['contractorcd']) && $advance['contractorcd'] == $c['code']) ? 'selected' : '' }}>
                                        {{ $c['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <label for="workercd" class="col-md-2 required">Worker</label>
                        <div class="col-md-4">
                            <select name="workercd" id="workercd"
                                    class="form-control form-control-sm select2" required
                                    {{ $vwedt == 1 ? 'disabled' : '' }}>
                                <option value="" selected disabled>Select</option>
                                @foreach($workers as $w)
                                    <option value="{{ $w['code'] }}"
                                        {{ (isset($advance['workercd']) && $advance['workercd'] == $w['code']) ? 'selected' : '' }}>
                                        {{ $w['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <label for="contractorbillcd" class="col-md-2 required">Contractor Bill</label>
                        <div class="col-md-4">
                            <select name="contractorbillcd" id="contractorbillcd"
                                    class="form-control form-control-sm select2" required
                                    {{ $vwedt == 1 ? 'disabled' : '' }}>
                                <option value="" selected disabled>Select</option>
                                @foreach($bills as $b)
                                    <option value="{{ $b['intno'] }}"
                                        {{ (isset($advance['contractorbillcd']) && $advance['contractorbillcd'] == $b['intno']) ? 'selected' : '' }}>
                                        {{ $b['bill_no'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <label for="amount" class="col-md-2 required">Amount</label>
                        <div class="col-md-4">
                            <input type="text" name="amount" id="amount"
                                   class="form-control form-control-sm text-right" required
                                   value="{{ $advance['amount'] ?? '' }}"
                                   {{ $vwedt == 1 ? 'disabled' : '' }}>
                        </div>

                        <label for="adjustment_amount" class="col-md-2">Adjustment Amount</label>
                        <div class="col-md-4">
                            <input type="text" name="adjustment_amount" id="adjustment_amount"
                                   class="form-control form-control-sm text-right"
                                   value="{{ $advance['adjustment_amount'] ?? '' }}"
                                   {{ $vwedt == 1 ? 'disabled' : '' }}>
                        </div>

                        <label for="balance_amount" class="col-md-2">Balance Amount</label>
                        <div class="col-md-4">
                            <input type="text" name="balance_amount" id="balance_amount"
                                   class="form-control form-control-sm text-right"
                                   value="{{ $advance['balance_amount'] ?? '' }}"
                                   {{ $vwedt == 1 ? 'disabled' : '' }}>
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

        function calcBalance() {
            var amt = parseFloat($('#amount').val()) || 0;
            var adj = parseFloat($('#adjustment_amount').val()) || 0;
            $('#balance_amount').val((amt - adj).toFixed(2));
        }

        $('#amount, #adjustment_amount').on('keyup change', calcBalance);

        $('#workerAdvanceForm').submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: '/payroll/save-worker-advance',
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
                        mtd.show_msgT(1, '/payroll/worker-advance', msg, 1);
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
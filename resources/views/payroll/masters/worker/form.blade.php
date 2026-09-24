@extends('layout.app', ['dept' => 'Payroll'])
@section('page_title_link', route('payroll.worker'))
@section('page_titleH', 'Worker')
@section('page_title', 'Details')

@section('content')

<section class="content mt-3">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form id="workerForm" method="post">
                    @csrf
                    <input type="hidden" name="code" value="{{ $worker['code'] ?? 0 }}"/>

                    <div class="form-group row">
                        <label for="name" class="col-md-2 required">Name</label>
                        <div class="col-md-4">
                            <input type="text" name="name" id="name"
                                   class="form-control form-control-sm" required autofocus
                                   value="{{ $worker['name'] ?? '' }}"
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
                                        {{ (isset($worker['contractorcd']) && $worker['contractorcd'] == $c['code']) ? 'selected' : '' }}>
                                        {{ $c['name'] }}
                                    </option>
                                @endforeach
                            </select>
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

        $('#workerForm').submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: '/payroll/save-worker',
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
                        mtd.show_msgT(1, '/payroll/worker', msg, 1);
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
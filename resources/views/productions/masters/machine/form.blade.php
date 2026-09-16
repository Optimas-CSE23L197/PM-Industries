@extends('productions.layout.app')
@section('page_title_link', route('machine'))
@section('page_titleH', 'Machine')
@section('page_title', 'Details')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form id="machineForm" method="post">
                        @csrf

                        <input type="hidden" name="code"
                               value="{{ $machine['code'] ?? 0 }}"/>

                        {{-- Row 1 : Name + Model No --}}
                        <div class="form-group row">
                            <label for="name" class="col-md-2 required">Name</label>
                            <div class="col-md-3">
                                <input type="text" name="name" id="name"
                                       class="form-control form-control-sm" autofocus required
                                       value="{{ old('name', $machine['name'] ?? '') }}"/>
                            </div>

                            <label for="model_no" class="col-md-2">Model No.</label>
                            <div class="col-md-3">
                                <input type="text" name="model_no" id="model_no"
                                       class="form-control form-control-sm"
                                       value="{{ old('model_no', $machine['model_no'] ?? '') }}"/>
                            </div>
                        </div>

                        {{-- Row 2 : Serial No + Installation Date --}}
                        <div class="form-group row">
                            <label for="serial_no" class="col-md-2">Serial No.</label>
                            <div class="col-md-3">
                                <input type="text" name="serial_no" id="serial_no"
                                       class="form-control form-control-sm"
                                       value="{{ old('serial_no', $machine['serial_no'] ?? '') }}"/>
                            </div>

                            <label for="installation_date" class="col-md-2">Installation Date</label>
                            <div class="col-md-3">
                                <input type="date" name="installation_date" id="installation_date"
                                       class="form-control form-control-sm"
                                       value="{{ old('installation_date', $machine['installation_date'] ?? '') }}"/>
                            </div>
                        </div>

                        {{-- Row 3 : Maintenance Period + Next Maintenance Date --}}
                        <div class="form-group row">
                            <label for="maintenance_period_days" class="col-md-2">Maintenance Period (Days)</label>
                            <div class="col-md-3">
                                <input type="number" name="maintenance_period_days" id="maintenance_period_days"
                                       class="form-control form-control-sm"
                                       value="{{ old('maintenance_period_days', $machine['maintenance_period_days'] ?? '') }}"/>
                            </div>

                            <label for="next_maintenance_date" class="col-md-2">Next Maintenance Date</label>
                            <div class="col-md-3">
                                <input type="date" name="next_maintenance_date" id="next_maintenance_date"
                                       class="form-control form-control-sm"
                                       value="{{ old('next_maintenance_date', $machine['next_maintenance_date'] ?? '') }}"/>
                            </div>
                        </div>

                        <button type="submit" id="saveBtn" class="btn btn-sm btn-dark float-right">
                            <i class="fas fa-save mr-1"></i>
                            Save
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('js')
<script>
    $('#machineForm').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url : '/production/save-machine',
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
                    mtd.show_msgT(1, '/production/machine', msg, 1);
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
</script>
@endpush
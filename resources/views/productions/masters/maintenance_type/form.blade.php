@extends('productions.layout.app')
@section('page_title_link', route('maintenanceType'))
@section('page_titleH', 'Maintenance Type')
@section('page_title', 'Details')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form id="maintenanceTypeForm" method="post">
                        @csrf

                        <input type="hidden" name="code"
                               value="{{ $maintenanceType['code'] ?? 0 }}"/>

                        <div class="form-group row">
                            <label for="name" class="col-md-2 required">Name</label>
                            <div class="col-md-4">
                                <input type="text" name="name" id="name"
                                       class="form-control form-control-sm" autofocus required
                                       value="{{ old('name', $maintenanceType['name'] ?? '') }}"/>
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
    $('#maintenanceTypeForm').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url : '/production/save-maintenance-type',
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
                    mtd.show_msgT(1, '/production/maintenance-type', msg, 1);
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
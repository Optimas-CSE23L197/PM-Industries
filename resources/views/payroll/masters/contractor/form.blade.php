@extends('layout.app', ['dept' => 'Payroll'])
@section('page_title_link', route('payroll.contractor'))
@section('page_titleH', 'Contractor')
@section('page_title', 'Details')

@section('content')

<section class="content mt-3">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form id="contractorForm" method="post">
                    @csrf
                    <input type="hidden" name="code" value="{{ $contractor['code'] ?? 0 }}"/>

                    <div class="form-group row">
                        <label for="name" class="col-md-2 required">Name</label>
                        <div class="col-md-4">
                            <input type="text" name="name" id="name"
                                   class="form-control form-control-sm" required autofocus
                                   value="{{ $contractor['name'] ?? '' }}"
                                   {{ $vwedt == 1 ? 'disabled' : '' }}>
                        </div>

                        <label for="phone" class="col-md-2 required">Phone No.</label>
                        <div class="col-md-4">
                            <input type="text" name="phone" id="phone"
                                   class="form-control form-control-sm" required
                                   value="{{ $contractor['phone'] ?? '' }}"
                                   {{ $vwedt == 1 ? 'disabled' : '' }}>
                        </div>

                        <label for="email" class="col-md-2">Email</label>
                        <div class="col-md-4">
                            <input type="email" name="email" id="email"
                                   class="form-control form-control-sm"
                                   value="{{ $contractor['email'] ?? '' }}"
                                   {{ $vwedt == 1 ? 'disabled' : '' }}>
                        </div>

                        <label for="address" class="col-md-2">Address</label>
                        <div class="col-md-4">
                            <input type="text" name="address" id="address"
                                   class="form-control form-control-sm"
                                   value="{{ $contractor['address'] ?? '' }}"
                                   {{ $vwedt == 1 ? 'disabled' : '' }}>
                        </div>

                        <label for="opbal" class="col-md-2">Opening Balance</label>
                        <div class="col-md-4">
                            <input type="text" name="opbal" id="opbal"
                                   class="form-control form-control-sm text-right"
                                   value="{{ $contractor['opbal'] ?? '' }}"
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

        $('#contractorForm').submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: '/payroll/save-contractor',
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
                        mtd.show_msgT(1, '/payroll/contractor', msg, 1);
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
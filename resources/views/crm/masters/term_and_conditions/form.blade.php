@extends('layout.app', ['dept' => 'CRM'])
@section('page_title', 'Terms & Conditions')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form id="termsForm" method="post">
                        @csrf

                        <div class="form-group row">
                            <label for="quotation" class="col-md-2 required">Quotation</label>
                            <div class="col-md-10">
                                <textarea name="quotation" id="quotation" rows="3"
                                          class="form-control form-control-sm" required
                                          placeholder="Enter quotation terms...">{{ $terms['quotation'] ?? '' }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="invoice" class="col-md-2 required">Invoice</label>
                            <div class="col-md-10">
                                <textarea name="invoice" id="invoice" rows="3"
                                          class="form-control form-control-sm" required
                                          placeholder="Enter invoice terms...">{{ $terms['invoice'] ?? '' }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="delivery" class="col-md-2 required">Delivery</label>
                            <div class="col-md-10">
                                <textarea name="delivery" id="delivery" rows="3"
                                          class="form-control form-control-sm" required
                                          placeholder="Enter delivery terms...">{{ $terms['delivery'] ?? '' }}</textarea>
                            </div>
                        </div>

                        <button type="submit" id="saveBtn" class="btn btn-sm btn-dark float-right">
                            <i class="fas fa-save mr-1"></i>
                            Update
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('js')
<script>
    $('#termsForm').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url : '/crm/save-terms-conditions',
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
                    mtd.show_msgT(1, '/crm/terms-conditions', msg, 1);
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
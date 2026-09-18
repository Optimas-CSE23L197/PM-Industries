@extends('layout.app', ['dept' => 'CRM'])
@section('page_title_link', route('leadSource'))
@section('page_titleH', 'Lead Source')
@section('page_title', 'Details')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form id="leadSourceForm" method="post">
                        @csrf
                        <input type="hidden" name="code" value="{{ $leadSource['code'] ?? 0 }}"/>

                        <div class="form-group row">
                            <label for="name" class="col-md-2 required">Name</label>
                            <div class="col-md-4">
                                <input type="text" name="name" id="name"
                                       class="form-control form-control-sm" autofocus required
                                       value="{{ $leadSource['name'] ?? '' }}"
                                       {{ $vwedt == 1 ? 'readonly' : '' }}/>
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
    $('#leadSourceForm').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url : '/crm/save-lead-source',
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
                    mtd.show_msgT(1, '/crm/lead-source', msg, 1);
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
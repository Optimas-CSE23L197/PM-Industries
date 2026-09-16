@extends('productions.layout.app')
@section('page_title_link', route('finishedItem'))
@section('page_titleH', 'Finished Item')
@section('page_title', 'Details')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form id="finishedItemForm" method="post">
                        @csrf

                        <input type="hidden" name="code"
                               value="{{ $finishedItem['code'] ?? 0 }}"/>

                        {{-- Row 1 : Name + Unit --}}
                        <div class="form-group row">
                            <label for="name" class="col-md-2 required">Name</label>
                            <div class="col-md-3">
                                <input type="text" name="name" id="name"
                                       class="form-control form-control-sm" autofocus required
                                       value="{{ old('name', $finishedItem['name'] ?? '') }}"/>
                            </div>

                            <label for="unit" class="col-md-2 required">Unit</label>
                            <div class="col-md-3">
                                <input type="text" name="unit" id="unit"
                                       class="form-control form-control-sm" required
                                       value="{{ old('unit', $finishedItem['unit'] ?? '') }}"/>
                            </div>
                        </div>

                        {{-- Row 2 : Standard Cost --}}
                        <div class="form-group row">
                            <label for="standard_cost" class="col-md-2 required">Standard Cost</label>
                            <div class="col-md-3">
                                <input style="text-align: right;" type="number" step="0.01" name="standard_cost" id="standard_cost"
                                       class="form-control form-control-sm" required
                                       value="{{ old('standard_cost', $finishedItem['standard_cost'] ?? '') }}"/>
                            </div>
                        </div>

                        @if(($vwedt ?? 0) != 1)
                            <button type="submit" id="saveBtn" class="btn btn-sm btn-dark float-right">
                                <i class="fas fa-save mr-1"></i>
                                {{ ($finishedItemType['code'] ?? 0) ? 'Update' : 'Save' }}
                            </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('js')
<script>
    $('#finishedItemForm').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url : '/production/save-finished-item',
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
                    mtd.show_msgT(1, '/production/finished-item', msg, 1);
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
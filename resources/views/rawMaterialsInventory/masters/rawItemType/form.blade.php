@extends('layout.app', ['dept' => 'Raw Material Inventory'])

@section('page_title_link')
    {{ Route('rawMaterialsInventory.rawMaterialTypeList') }}
@endsection

@section('page_titleH', 'Raw Item Type')
@section('page_title', 'Details')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form id="rawMaterialsTypeForm" method="post">
                        @csrf

                        <input type="hidden" name="code" value="{{ $rmType['code'] ?? '' }}"/>
                        <input type="hidden" name="active_yn" value="{{ $rmType['active_yn'] ?? 'Y' }}"/>

                        <div class="form-group row">
                            <label for="name" class="col-md-2 required">Name</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control form-control-sm" name="name" id="name" value="{{ old('name', $rmType['name'] ?? '') }}" required autofocus/>
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

    @push('js')
        <script>
            const mode = @json($mode);
            $(function(){
                if(mode === 'view'){
                    $('input, textarea, select').attr('disabled', true);
                    $('#saveBtn').hide();
                }
            });

            $('#rawMaterialsTypeForm').submit(function(e){
                e.preventDefault();
                var $saveBtn = $('#saveBtn');
                var originalBtnHtml = $saveBtn.html();
                $saveBtn.prop('disabled', true);
                $saveBtn.html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');

                var formData = $(this).serialize();

                $.ajax({
                    url : "{{ Route('rawMaterialsInventory.rawMaterialTypeSave') }}",
                    type: 'post',
                    data: formData,
                    beforeSend:function(){
                        mtd.show_msg(3, '', 'Saving, Please Wait...',4);
                    },
                    success:function(resp){
                        Swal.close();
                        let message = resp.message.split(/<br\s*\/?>/i)[0];

                        if (!resp.error) {
                            mtd.show_msgT(1, "{{Route('rawMaterialsInventory.rawMaterialTypeList')}}", message, 1);
                        } else {
                            mtd.show_msgT(0, '', message, 0);
                        }
                    },

                    error: function(xhr){
                        Swal.close();
                        mtd.show_msgT(0, '', 'Something went wrong. Please try again.', 0);
                    },
                    complete: function(){
                        $saveBtn.prop('disabled', false);
                        $saveBtn.html(originalBtnHtml);
                    }
                });
            });
        </script>
         
    @endpush

@endsection
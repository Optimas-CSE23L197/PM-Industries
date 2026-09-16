@extends('layout.app', ['dept' => 'Raw Material Inventory'])

@section('page_title_link')
    {{ route('rawMaterialsInventory.departmentList') }}
@endsection

@section('page_titleH', 'Department')
@section('page_title', 'Details')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form id="storeForm" action="store.html">
                        @csrf
                        <input type="hidden" name="code" id="code" value=""/>
                        <input type="hidden" name="active_yn" id="active_yn" value=""/>

                        <div class="form-group row">
                            <label for="" class="col-md-2 required">Name</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control form-control-sm" autofocus required/>
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

            $('#storeForm').submit(function(e){
                e.preventDefault();
                var $saveBtn = $('#saveBtn');
                var originalBtnHtml = $saveBtn.html();
                $saveBtn.prop('disabled', true);
                $saveBtn.html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');

                var formData = $(this).serialize();

                $.ajax({
                    url : "{{ Route('rawMaterialsInventory.saveStore') }}",
                    type: 'post',
                    data: formData,
                    beforeSend:function(){
                        mtd.show_msg(3, '', 'Saving, Please Wait...',4);
                    },
                    success:function(resp){
                        Swal.close();
                        let message = resp.message.split(/<br\s*\/?>/i)[0];

                        if (!resp.error) {
                            mtd.show_msgT(1, "{{Route('rawMaterialsInventory.storeList')}}", message, 1);
                        } else {
                            mtd.show_msgT(0, '', message, 0);
                        }
                    },

                    error: function(xhr){
                        Swal.close();
                        let message = xhr.responseJSON?.message ?? 'Something went wrong. Please try again.';
                        mtd.show_msgT(0, '', message, 0);
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
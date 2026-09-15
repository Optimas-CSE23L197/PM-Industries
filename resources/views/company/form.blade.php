@extends('company.layout.app')

@section('pageTitle', 'Company Details')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form id="compForm" method="post">
                        @csrf

                        <input type="hidden" name="code" value="{{ $comp['code'] ?? '' }}"/>
                        <input type="hidden" name="activeyn" value="{{ $comp['activeyn'] ?? '' }}"/>
                        <input type="hidden" name="finyr" value="{{ $comp['finyr'] ?? '' }}"/>
                        <input type="hidden" name="fdt" value="{{ $comp['fdt'] ?? '' }}"/>
                        <input type="hidden" name="tdt" value="{{ $comp['tdt'] ?? '' }}"/>
                        <input type="hidden" name="lockdt" value="{{ $comp['lockdt'] ?? '' }}"/>

                        <div class="form-group row">
                            <label for="name" class="col-md-2 required">Name</label>
                            <div class="col-md-4">
                                <input type="text" name="name" id="name" value="{{ old('name', $comp['name'] ?? '') }}" class="form-control form-control-sm" required/>
                            </div>
                            <label for="mobile" class="col-md-2 required">Mobile No.</label>
                            <div class="col-md-4">
                                <input type="number" name="mobile" id="mobile" value="{{ old('mobile', $comp['mobile'] ?? '') }}"  class="form-control form-control-sm" required/>
                            </div>

                            <label for="phone" class="col-md-2">Phone</label>
                            <div class="col-md-4">
                                <input type="number" name="phone" id="phone" value="{{ old('phone', $comp['phone'] ?? '') }}"  class="form-control form-control-sm"/>
                            </div>

                            <label for="emailid" class="col-md-2">Email</label>
                            <div class="col-md-4">
                                <input type="email" name="emailid" id="emailid" value="{{ old('emailid', $comp['emailid'] ?? '') }}"  class="form-control form-control-sm"/>
                            </div>

                            <label for="address" class="col-md-2">Address</label>
                            <div class="col-md-4">
                                <input type="text" name="address" id="address" value="{{ old('address', $comp['address'] ?? '') }}"  class="form-control form-control-sm"/>
                            </div>

                            <label for="gstno" class="col-md-2">GST No.</label>
                            <div class="col-md-4">
                                <input type="text" name="gstno" id="gstno" value="{{ old('gstno', $comp['gstno'] ?? '') }}"  class="form-control form-control-sm"/>
                            </div>

                            <label for="gststatecd" class="col-md-2">GST State Code</label>
                            <div class="col-md-4">
                                <input type="number" name="gststatecd" id="gststatecd" value="{{ old('gststatecd', $comp['gststatecd'] ?? '') }}"  class="form-control form-control-sm"/>
                            </div>

                            <label for="other_credentials" class="col-md-2">Other Credentials</label>
                            <div class="col-md-4">
                                <input type="text" name="other_credentials" id="other_credentials" value="{{ old('other_credentials', $comp['other_credentials'] ?? '') }}"  class="form-control form-control-sm"/>
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

            $('#compForm').submit(function(e){
                e.preventDefault();
                var $saveBtn = $('#saveBtn');
                var originalBtnHtml = $saveBtn.html();
                $saveBtn.prop('disabled', true);
                $saveBtn.html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');

                var formData = $(this).serialize();

                $.ajax({
                    url : "{{ Route('saveComp') }}",
                    type: 'post',
                    data: formData,
                    beforeSend:function(){
                        mtd.show_msg(3, '', 'Saving, Please Wait...',4);
                    },
                    success:function(resp){
                        Swal.close();
                        let message = resp.message.split(/<br\s*\/?>/i)[0];

                        if (!resp.error) {
                            mtd.show_msgT(1, "{{Route('compList')}}", message, 1);
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
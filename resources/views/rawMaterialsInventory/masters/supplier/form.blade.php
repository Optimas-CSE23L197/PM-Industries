@extends('layout.app', ['dept' => 'Raw Material Inventory'])

@section('page_title_link')
    {{ route('rawMaterialsInventory.supplierList') }}
@endsection

@section('page_titleH', 'Supplier')
@section('page_title', 'Details')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form id="supplierForm" method="post">
                        @csrf

                        <input type="hidden" name="code" value="{{ $splr['code'] ?? '' }}"/>
                        <input type="hidden" name="active_yn" value="{{ $splr['active_yn'] ?? 'Y' }}"/>

                        <div class="form-group row">
                            <label for="name" class="col-md-2 required">Name</label>
                            <div class="col-md-4">
                                <input type="text" name="name" id="name" value="{{ old('name', $splr['name'] ?? '') }}" class="form-control form-control-sm" autofocus required/>
                            </div>

                            <label for="contact_person" class="col-md-2 required">Contact Person</label>
                            <div class="col-md-4">
                                <input type="text" name="contact_person" id="contact_person" value="{{ old('contact_person', $splr['contact_person'] ?? '') }}" class="form-control form-control-sm" required/>
                            </div>

                            <label for="phone" class="col-md-2 required">Phone</label>
                            <div class="col-md-4">
                                <input type="tel" name="phone" id="phone" value="{{ old('phone', $splr['phone'] ?? '') }}" class="form-control form-control-sm" required/>
                            </div>

                            <label for="email" class="col-md-2 required">Email</label>
                            <div class="col-md-4">
                                <input type="email" name="email" id="email" value="{{ old('email', $splr['email'] ?? '') }}" class="form-control form-control-sm" required/>
                            </div>

                            <label for="address1" class="col-md-2">Address</label>
                            <div class="col-md-4">
                                <input type="text" name="address1" id="address1" value="{{ old('address1', $splr['address1'] ?? '') }}" class="form-control form-control-sm"/>
                            </div>

                            <label for="gstin" class="col-md-2">GST No.</label>
                            <div class="col-md-4">
                                <input type="text" name="gstin" id="gstin" value="{{ old('gstin', $splr['gstin'] ?? '') }}" class="form-control form-control-sm"/>
                            </div>

                            <label for="pan_no" class="col-md-2">PAN No.</label>
                            <div class="col-md-4">
                                <input type="text" name="pan_no" id="pan_no" value="{{ old('pan_no', $splr['pan_no'] ?? '') }}" class="form-control form-control-sm"/>
                            </div>

                            <label for="credit_days" class="col-md-2">Credit Days</label>
                            <div class="col-md-4">
                                <input type="number" name="credit_days" id="credit_days" value="{{ old('credit_days', $splr['credit_days'] ?? '') }}" class="form-control form-control-sm" min="0"/>
                            </div>

                            <label for="opening_balance" class="col-md-2">Opening Balance</label>
                            <div class="col-md-4">
                                <input type="number" name="opening_balance" id="opening_balance" value="{{ old('opening_balance', $splr['opening_balance'] ?? '') }}" class="form-control form-control-sm" min="0" step="0.01"/>
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

            $('#supplierForm').submit(function(e){
                e.preventDefault();
                var $saveBtn = $('#saveBtn');
                var originalBtnHtml = $saveBtn.html();
                $saveBtn.prop('disabled', true);
                $saveBtn.html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');

                var formData = $(this).serialize();

                $.ajax({
                    url : "{{ Route('rawMaterialsInventory.supplierSave') }}",
                    type: 'post',
                    data: formData,
                    beforeSend:function(){
                        mtd.show_msg(3, '', 'Saving, Please Wait...',4);
                    },
                    success:function(resp){
                        Swal.close();
                        let message = resp.message.split(/<br\s*\/?>/i)[0];

                        if (!resp.error) {
                            mtd.show_msgT(1, "{{Route('rawMaterialsInventory.supplierList')}}", message, 1);
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

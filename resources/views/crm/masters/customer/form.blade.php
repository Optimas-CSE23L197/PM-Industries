@extends('layout.app', ['dept' => 'CRM'])
@section('page_title_link', route('customer'))
@section('page_titleH', 'Customer')
@section('page_title', 'Details')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form id="customerForm" method="post">
                        @csrf
                        <input type="hidden" name="code" value="{{ $customer['code'] ?? 0 }}"/>

                        <div class="form-group row">
                            <label for="name" class="col-md-2 required">Name</label>
                            <div class="col-md-4">
                                <input type="text" name="name" id="name"
                                       class="form-control form-control-sm" autofocus required
                                       value="{{ $customer['name'] ?? '' }}"
                                       {{ $vwedt == 1 ? 'readonly' : '' }}/>
                            </div>

                            <label for="contact_person" class="col-md-2">Contact Person</label>
                            <div class="col-md-4">
                                <input type="text" name="contact_person" id="contact_person"
                                       class="form-control form-control-sm"
                                       value="{{ $customer['contact_person'] ?? '' }}"
                                       {{ $vwedt == 1 ? 'readonly' : '' }}/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-2">Phone No.</label>
                            <div class="col-md-4">
                                <input type="text" name="phone" id="phone"
                                       class="form-control form-control-sm"
                                       value="{{ $customer['phone'] ?? '' }}"
                                       {{ $vwedt == 1 ? 'readonly' : '' }}/>
                            </div>

                            <label for="email" class="col-md-2">Email</label>
                            <div class="col-md-4">
                                <input type="email" name="email" id="email"
                                       class="form-control form-control-sm"
                                       value="{{ $customer['email'] ?? '' }}"
                                       {{ $vwedt == 1 ? 'readonly' : '' }}/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-md-2">Address</label>
                            <div class="col-md-4">
                                <input type="text" name="address" id="address"
                                       class="form-control form-control-sm"
                                       value="{{ $customer['address'] ?? '' }}"
                                       {{ $vwedt == 1 ? 'readonly' : '' }}/>
                            </div>

                            <label for="gstin" class="col-md-2">GST No.</label>
                            <div class="col-md-4">
                                <input type="text" name="gstin" id="gstin"
                                       class="form-control form-control-sm"
                                       value="{{ $customer['gstin'] ?? '' }}"
                                       {{ $vwedt == 1 ? 'readonly' : '' }}/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="pan_no" class="col-md-2">PAN No.</label>
                            <div class="col-md-4">
                                <input type="text" name="pan_no" id="pan_no"
                                       class="form-control form-control-sm"
                                       value="{{ $customer['pan_no'] ?? '' }}"
                                       {{ $vwedt == 1 ? 'readonly' : '' }}/>
                            </div>

                            <label for="credit_days" class="col-md-2">Credit Days</label>
                            <div class="col-md-4">
                                <input style="text-align: right;" type="number" name="credit_days" id="credit_days"
                                       class="form-control form-control-sm"
                                       value="{{ $customer['credit_days'] ?? '' }}"
                                       {{ $vwedt == 1 ? 'readonly' : '' }}/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="opening_balance" class="col-md-2">Opening Balance</label>
                            <div class="col-md-4">
                                <input style="text-align: right;" type="number" step="0.01" name="opening_balance" id="opening_balance"
                                       class="form-control form-control-sm"
                                       value="{{ $customer['opening_balance'] ?? '' }}"
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
    $('#customerForm').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url : '/crm/save-customer',
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
                    mtd.show_msgT(1, '/crm/customer', msg, 1);
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
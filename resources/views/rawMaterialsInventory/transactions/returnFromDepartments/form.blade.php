@extends('layout.app', ['dept' => 'Raw Material Inventory'])

@section('page_title_link')
    {{ route('rawMaterialsInventory.rtnFrmDeptList') }}
@endsection

@section('page_titleH', 'Retuen From Departments')
@section('page_title', 'Details')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form id="Form" action="return.html">
                        <div class="form-group row">
                            <label for="" class="col-md-2">Return No.</label>
                            <div class="col-md-4"><input type="text" class="form-control form-control-sm" disabled></div>
                            <label for="" class="col-md-2 required">Return Date</label>
                            <div class="col-md-4"><input type="date" class="form-control form-control-sm date_today" autofocus required></div>
                            <label for="" class="col-md-2 required">Issue No.</label>
                            <div class="col-md-4">
                                <select name="" class="form-control form-control-sm select2" id="" required>
                                    <option value="" selected disabled>Select</option>
                                    <option value="">ISSU/26-27/000001 - 01/01/2026</option>
                                    <option value="">ISSU/26-27/000002 - 01/01/2026</option>
                                    <option value="">ISSU/26-27/000003 - 01/01/2026</option>
                                </select>
                            </div>
                            <label for="" class="col-md-2">From Department</label>
                            <div class="col-md-4"><input type="text" class="form-control form-control-sm" disabled></div>
                            <label for="" class="col-md-2">To Department</label>
                            <div class="col-md-4"><input type="text" class="form-control form-control-sm" disabled></div>
                            <div class="col-12"><hr></div>
                            <!-- Item List -->
                            <div class="col-md-12" style="overflow:auto;">
                                <table class="table table-sm table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="width:70%">Item</th>
                                            <th style="width:15%;text-align:right;">Issued Qty</th>
                                            <th style="width:15%;text-align:right;">Return Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Item 1</td>
                                            <td style="text-align:right;">10</td>
                                            <td><input type="text" class="form-control form-control-sm text-right"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <button id="saveBtn" class="btn btn-sm btn-dark float-right"><i class="fas fa-save"></i> Save</button> 
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
        </script>
    @endpush

@endsection
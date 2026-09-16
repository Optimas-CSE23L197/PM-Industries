@extends('layout.app', ['dept' => 'Raw Material Inventory'])

@section('page_title_link')
    {{ route('rawMaterialsInventory.supplierList') }}
@endsection

@section('page_titleH', 'Supplier')
@section('page_title', 'Details')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <form id="Form" method="POST">
                @csrf

                <input type="hidden" name="intno" id="intno" value="{{ $prOdr['intno'] ?? '' }}"/>
                <input type="hidden" name="activeyn" id="activeyn" value="{{ $prOdr['activeyn'] ?? 'Y' }}"/>

                <div class="card">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="po_no" class="col-md-2">Transaction No.</label>
                            <div class="col-md-4">
                                <input type="text" name="po_no" id="po_no" value="{{ $prOdr['po_no'] ?? '' }}" class="form-control form-control-sm" disabled/>
                            </div>

                            <label for="po_date" class="col-md-2 required">Date</label>
                            <div class="col-md-4">
                                <input type="date" name="po_date" id="po_date" value="{{ old('po_date', $prOdr['po_date'] ?? '') }}" class="form-control form-control-sm date_today" required autofocus/>
                            </div>

                            <label for="suppliercd" class="col-md-2 required">Supplier</label>
                            <div class="col-md-4">
                                <select name="suppliercd" class="form-control form-control-sm select2" id="suppliercd" required>
                                    @if ($mode === 'new')
                                        <option value="" selected disabled>Select</option>
                                    @endif
                                    @forelse ( $splr as $s )
                                        <option value="{{ $s['code'] }}"
                                            {{ (($s['code'] ?? '') === ($prOdr['suppliercd'] ?? '')) ? 'selected' : '' }}>
                                            {{ $s['name'] }}
                                        </option>
                                    @empty
                                        <option>No supplier found</option>
                                    @endforelse
                                </select>
                            </div>

                            <label for="expected_date" class="col-md-2 required">Expected Date</label>
                            <div class="col-md-4">
                                <input type="date" name="expected_date" id="expected_date" value="{{ old('expected_date', $prOdr['expected_date'] ?? '') }}" class="form-control form-control-sm date_today" required autofocus/>
                            </div>

                            <div class="col-12"><hr></div>
                            <label for="" class="col-md-2">Gross Amount</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control form-control-sm text-right" disabled/>
                            </div>
                            <label for="" class="col-md-2">GST Amount</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control form-control-sm text-right" disabled/>
                            </div>

                            <label for="" class="col-md-2">Round off Amount</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control form-control-sm text-right" disabled/>
                            </div>

                            <label for="" class="col-md-2">Net Amount</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control form-control-sm text-right" disabled/>
                            </div>

                            <label for="" class="col-md-2">Remarks</label>
                            <div class="col-md-4">
                                <textarea name="" class="form-control form-control-sm"
                                    rows="3" id=""></textarea>
                            </div>

                            <div class="col-12"><hr></div>
                            <div class="col-md-12" style="overflow:auto;">
                                <table class="table table-sm table-bordered text-xs">
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="width:50%">Item</th>
                                            <th style="width:10%;text-align:right;">Qty</th>
                                            <th style="width:10%;text-align:right;">Rate</th>
                                            <th style="width:10%;text-align:right;">GST</th>
                                            <th style="width:10%;text-align:right;">Amount</th>
                                            <th style="width:10%;text-align:center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="6"><button type="button" class="btn btn-sm btn-secondary btn-block"
                                                    data-toggle="modal" data-target="#poModal"><i
                                                        class="fas fa-plus-circle"></i> Add Item</button></td>
                                        </tr>
                                        <tr>
                                            <td>Item 1</td>
                                            <td style="text-align:right;">1</td>
                                            <td style="text-align:right;">100.00</td>
                                            <td style="text-align:right;">100.00</td>
                                            <td style="text-align:right;">100.00</td>
                                            <td class="dropdown text-center">
                                                <i class="fas fa-bars ml-2 mr-1" data-toggle="dropdown" href="#"
                                                    style="cursor:pointer"></i>
                                                <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                                    <a href="#" class="dropdown-item">
                                                        <div class="media">
                                                            <div class="media-body">
                                                                <p>View</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a href="#" class="dropdown-item">
                                                        <div class="media">
                                                            <div class="media-body">
                                                                <p>Edit</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <button type="submit" id="saveBtn" class="btn btn-sm btn-dark float-right"><i
                                class="fas fa-save mr-1"></i>
                            Save</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    @include('rawMaterialsInventory.transactions.purchaseOrder.popup.itemDetails')

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
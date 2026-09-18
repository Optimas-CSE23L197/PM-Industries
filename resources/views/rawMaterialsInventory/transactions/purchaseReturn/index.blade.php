@extends('layout.app', ['dept' => 'Raw Material Inventory'])
@section('page_title', 'Purchase Retuen')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header py-1">
                    <label for="" class="card-title">Purchase Return</label>
                    <div class="float-right">
                        <button class="btn btn-sm btn-secondary"
                            onclick="location.href='{{ Route('rawMaterialsInventory.printPurchaseRtnList') }}'">
                            <i class="fas fa-print mr-1"></i> Print 
                        </button>
                        
                        <button class="btn btn-sm btn-dark"
                            onclick="location.href='{{ Route('rawMaterialsInventory.purchaseRtnDetails', 'new') }}'">
                            <i class="fas fa-plus-circle mr-1"></i> Add New 
                        </button>
                    </div>

                    {{-- <div class="btn-group float-right mr-2">
                        <button class="btn btn-sm btn-dark"><i class="fas fa-caret-left"></i></button>
                        <input type="date" class="form-control form-control-sm date_today">
                        <button class="btn btn-sm btn-dark"><i class="fas fa-caret-right"></i></button>
                    </div> --}}
                    
                </div>
                <div class="card-body">
                    <table id="depttable" class="table table-sm table-bordered text-xs">
                        <thead class="thead-light">
                            <tr>
                                <th style="width:15%">P.Return No.</th>
                                <th style="width:40%">Supplier</th>
                                <th style="width:15%">Supplier Bill No.</th>
                                <th style="width:10%">Amount</th>
                                <th style="width:10%">Status</th>
                                <th style="width:10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>PRET/26-27/000001</td>
                                <td>Supplier 1</td>
                                <td>000001</td>
                                <td>1000.00</td>
                                <td><button class="btn btn-xs btn-success btn-block">Active</button></td>
                                <td class="dropdown text-center">
                                    <i class="fas fa-bars ml-2 mr-1" data-toggle="dropdown" href="#"
                                        style="cursor:pointer"></i>
                                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                        <a href="{{ Route('rawMaterialsInventory.purchaseRtnDetails', ['mode'=>'view']) }}" class="dropdown-item">
                                            <div class="media">
                                                <div class="media-body">
                                                    <p>View</p>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a href="{{ Route('rawMaterialsInventory.purchaseRtnDetails', ['mode'=>'edit']) }}" class="dropdown-item">
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
        </div>
    </section>

@endsection
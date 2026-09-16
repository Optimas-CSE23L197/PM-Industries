@extends('layout.app', ['dept' => 'Raw Material Inventory'])
@section('page_title', 'Store')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header py-1">
                    <label for="" class="card-title">Store</label>
                    <div class="float-right">
                        <button class="btn btn-sm btn-secondary"
                            onclick="location.href='{{ Route('rawMaterialsInventory.printStoreList') }}'">
                            <i class="fas fa-print mr-1"></i> Print 
                        </button>
                        
                        <button class="btn btn-sm btn-dark"
                            onclick="location.href='{{ Route('rawMaterialsInventory.storeDetails', 'new') }}'">
                            <i class="fas fa-plus-circle mr-1"></i> Add New 
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="depttable" class="table table-sm table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th style="width:80%">Name</th>
                                <th style="width:10%">Status</th>
                                <th style="width:10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Store 1</td>
                                <td><button class="btn btn-xs btn-success btn-block">Active</button></td>
                                <td class="dropdown text-center">
                                    <i class="fas fa-bars ml-2 mr-1" data-toggle="dropdown" href="#"
                                        style="cursor:pointer"></i>
                                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                        <a href="{{ Route('rawMaterialsInventory.storeDetails', ['mode'=>'view']) }}" class="dropdown-item">
                                            <div class="media">
                                                <div class="media-body">
                                                    <p>View</p>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a href="{{ Route('rawMaterialsInventory.storeDetails', ['mode'=>'edit']) }}" class="dropdown-item">
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
@extends('layout.app', ['dept' => 'Raw Material Inventory'])
@section('page_title', 'Supplier')

@section('content')
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header py-1">
                    <label for="" class="card-title">Supplier</label>
                    <div class="float-right">
                        <button class="btn btn-sm btn-secondary"
                            onclick="location.href='{{ Route('rawMaterialsInventory.printSupplierList') }}'">
                            <i class="fas fa-print mr-1"></i> Print 
                        </button>
                        
                        <button class="btn btn-sm btn-dark"
                            onclick="location.href='{{ Route('rawMaterialsInventory.supplierDetails', 'new') }}'">
                            <i class="fas fa-plus-circle mr-1"></i> Add New 
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="depttable" class="table table-sm table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th style="width:35%">Name</th>
                                <th style="width:15%">Phone</th>
                                <th style="width:15%">Email</th>
                                <th style="width:15%">Contact Person</th>
                                <th style="width:10%; text-align:center">Status</th>
                                <th style="width:10%; text-align:center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ( $splr as $s )
                                @php
                                    $status = $s['active_yn'] ?? 'N';
                                    $btnColor = $aedl = '';
                                    if ($status === 'Y') {
                                        $status = 'Active';
                                        $btnColor = 'btn-success';
                                        $aedl = 'D';
                                    } elseif ($status === 'N') {
                                        $status = 'Inactive';
                                        $btnColor = 'btn-danger';
                                        $aedl = 'U';
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $s['name'] ?? '' }}</td>
                                    <td>{{ $s['phone'] ?? '' }}</td>
                                    <td>{{ $s['email'] ?? '' }}</td>
                                    <td>{{ $s['contact_person'] ?? '' }}</td>
                                    <td>
                                        <button type='button' class="btn btn-xs {{ $btnColor }} btn-block"
                                            onclick="mtd.show_msg(2, '{{ Route('rawMaterialsInventory.supplierStatChange', ['code' => $s['code'], 'aedl' => $aedl]) }}', 'Are you sure to change its status..?', 2);">
                                            {{ $status }}
                                        </button>
                                    </td>
                                    <td class="dropdown text-center">
                                        <i class="fas fa-bars ml-2 mr-1" data-toggle="dropdown" href="#"
                                            style="cursor:pointer"></i>
                                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                            <a href="{{ Route('rawMaterialsInventory.supplierDetails', ['mode'=>'view', 'code'=>$s['code'] ?? 0]) }}" class="dropdown-item">
                                                <div class="media">
                                                    <div class="media-body">
                                                        <p>View</p>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="{{ Route('rawMaterialsInventory.supplierDetails', ['mode'=>'edit', 'code'=>$s['code'] ?? 0]) }}" class="dropdown-item">
                                                <div class="media">
                                                    <div class="media-body">
                                                        <p>Edit</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 20px;">No records found</td>
                                </tr>
                            @endforelse
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
@extends('layout.app', ['dept' => 'Raw Material Inventory'])
@section('page_title', 'Department')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header py-1">
                    <label for="" class="card-title">Department</label>
                    <div class="float-right">
                        <button class="btn btn-sm btn-secondary"
                            onclick="location.href='{{ Route('rawMaterialsInventory.printDepartmentList') }}'">
                            <i class="fas fa-print mr-1"></i> Print 
                        </button>
                        
                        <button class="btn btn-sm btn-dark"
                            onclick="location.href='{{ Route('rawMaterialsInventory.departmentDetails', 'new') }}'">
                            <i class="fas fa-plus-circle mr-1"></i> Add New 
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="depttable" class="table table-sm table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th style="width:80%">Name</th>
                                <th style="width:10%; text-align:center">Status</th>
                                <th style="width:10%; text-align:center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ( $deprt as $d )
                                @php
                                    $status = $d['active_yn'] ?? 'N';
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
                                    <td>{{ $d['name'] ?? '' }}</td>
                                    <td>
                                        <button type='button' class="btn btn-xs {{ $btnColor }} btn-block"
                                            onclick="mtd.show_msg(2, '{{ Route('rawMaterialsInventory.departmentStatChange', ['code' => $d['code'], 'aedl' => $aedl]) }}', 'Are you sure to change its status..?', 2);">
                                            {{ $status }}
                                        </button>
                                    </td>
                                    <td class="dropdown text-center">
                                        <i class="fas fa-bars ml-2 mr-1" data-toggle="dropdown" href="#"
                                            style="cursor:pointer"></i>
                                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                            <a href="{{ Route('rawMaterialsInventory.departmentDetails', ['mode'=>'view', 'code'=>$d['code'] ?? 0]) }}" class="dropdown-item">
                                                <div class="media">
                                                    <div class="media-body">
                                                        <p>View</p>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="{{ Route('rawMaterialsInventory.departmentDetails', ['mode'=>'edit', 'code'=>$d['code'] ?? 0]) }}" class="dropdown-item">
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
                                    <td colspan="3" style="text-align:center">No data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection
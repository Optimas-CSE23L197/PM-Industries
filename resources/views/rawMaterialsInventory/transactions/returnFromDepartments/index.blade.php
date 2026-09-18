@extends('layout.app', ['dept' => 'Raw Material Inventory'])
@section('page_title', 'Issue To Departments')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header py-1">
                    <label for="" class="card-title">Return From Departments</label>
                    <div class="float-right">
                        <button class="btn btn-sm btn-secondary"
                            onclick="location.href='{{ Route('rawMaterialsInventory.printRtnFrmDeptList') }}'">
                            <i class="fas fa-print mr-1"></i> Print 
                        </button>
                        
                        <button class="btn btn-sm btn-dark"
                            onclick="location.href='{{ Route('rawMaterialsInventory.rtnFrmDeptDetails', 'new') }}'">
                            <i class="fas fa-plus-circle mr-1"></i> Add New 
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="depttable" class="table table-sm table-bordered text-xs">
                        <thead class="thead-light">
                            <tr>
                                <th style="width:15%">Return No.</th>
                                <th style="width:15%">Return against Issue No.</th>
                                <th style="width:25%">From Department</th>
                                <th style="width:25%">To Department</th>
                                <th style="width:10%">Status</th>
                                <th style="width:10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rtn as $r)
                                @php
                                    $status = $r['activeyn'] ?? 'N';
                                    $btnColor = $aedl = '';
                                    if ($status === 'Y') {
                                        $status = 'Active';
                                        $btnColor = 'btn-success';
                                        $aedl = 'D';
                                    } elseif($status === 'N') {
                                        $status = 'Inactive';
                                        $btnColor = 'btn-danger';
                                        $aedl = 'U';
                                    }
                                @endphp

                                <tr>
                                    <td>{{ $r['issue_no'] ?? '' }}</td>
                                    <td>{{ $r[''] ?? '' }}</td>
                                    <td>{{ $r['from_department_name'] ?? '' }}</td>
                                    <td>{{ $r['to_department_name'] ?? '' }}</td>
                                    <td>
                                        <button type='button' class="btn btn-xs {{ $btnColor }} btn-block"
                                            onclick="mtd.show_msg(2, '{{ Route('rawMaterialsInventory.statRtnFrmDept', ['code' => $r['intno'] ?? 0, 'aedl' => $aedl]) }}', 'Are you sure to change its status..?', 2);">
                                            {{ $status }}
                                        </button>
                                    </td>
                                    <td class="dropdown text-center">
                                        <i class="fas fa-bars ml-2 mr-1" data-toggle="dropdown" href="#"
                                            style="cursor:pointer"></i>
                                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                            <a href="{{ Route('rawMaterialsInventory.rtnFrmDeptDetails', ['mode'=>'view'], $r['intno']) }}" class="dropdown-item">
                                                <div class="media">
                                                    <div class="media-body">
                                                        <p>View</p>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="{{ Route('rawMaterialsInventory.rtnFrmDeptDetails', ['mode'=>'edit', $r['intno']]) }}" class="dropdown-item">
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
                                    <td colspan="6" style="text-align:center"></td>
                                </tr>
                            @endforelse
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection
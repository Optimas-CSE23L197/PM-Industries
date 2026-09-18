@extends('layout.app', ['dept' => 'Raw Material Inventory'])
@section('page_title', 'Stock Adjustment')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header py-1">
                    <label for="" class="card-title">Stock Adjustment</label>
                    <div class="float-right">
                        <button class="btn btn-sm btn-secondary"
                            onclick="location.href='{{ Route('rawMaterialsInventory.printStkAdjList') }}'">
                            <i class="fas fa-print mr-1"></i> Print 
                        </button>
                        
                        <button class="btn btn-sm btn-dark"
                            onclick="location.href='{{ Route('rawMaterialsInventory.stkAdjDetails', 'new') }}'">
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
                                <th style="width:15%">Adjustment No.</th>
                                <th style="width:25%">Department</th>
                                <th style="width:40%">Reason</th>
                                <th style="width:10%">Status</th>
                                <th style="width:10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse( $stkAdj as $s)
                                @php
                                    $status = $s['activeyn'] ?? 'N';
                                    $btnColor = $aedl = '';
                                    if($status === 'Y') {
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
                                <td>{{ $s['adjno'] ?? '' }}</td>
                                <td>{{ $s[''] ?? '' }}</td>
                                <td>{{ $s['reason'] ?? '' }}</td>
                                <td>
                                        <button type='button' class="btn btn-xs {{ $btnColor }} btn-block"
                                            onclick="mtd.show_msg(2, '{{ Route('rawMaterialsInventory.statStkAdj', ['code' => $s['intno'], 'aedl' => $aedl]) }}', 'Are you sure to change its status..?', 2);">
                                            {{ $status }}
                                        </button>
                                    </td>
                                <td class="dropdown text-center">
                                    <i class="fas fa-bars ml-2 mr-1" data-toggle="dropdown" href="#"
                                        style="cursor:pointer"></i>
                                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                        <a href="{{ Route('rawMaterialsInventory.stkAdjDetails', ['mode'=>'view', 'code'=>$s['intno'] ?? 0]) }}" class="dropdown-item">
                                            <div class="media">
                                                <div class="media-body">
                                                    <p>View</p>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a href="{{ Route('rawMaterialsInventory.stkAdjDetails', ['mode'=>'edit', 'code'=>$s['intno'] ?? 0]) }}" class="dropdown-item">
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
                                    <td colspan="5" style="text-align:center">No data found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection
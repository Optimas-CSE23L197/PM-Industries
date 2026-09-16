@extends('layout.app', ['dept' => 'Raw Material Inventory'])
@section('page_title', 'Purchase Order')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header py-1">
                    <label for="" class="card-title">Purchase Order</label>
                    <div class="float-right">
                        <button class="btn btn-sm btn-secondary"
                            onclick="location.href='{{ Route('rawMaterialsInventory.printPurchaseOrderList') }}'">
                            <i class="fas fa-print mr-1"></i> Print 
                        </button>
                        
                        <button class="btn btn-sm btn-dark"
                            onclick="location.href='{{ Route('rawMaterialsInventory.purchaseOrderDetails', 'new') }}'">
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
                                <th style="width:10%">Tran No.</th>
                                <th style="width:20%">Supplier</th>
                                <th style="width:10%">Exp. Date</th>
                                <th style="width:10%;text-align:right;">Gross Amount</th>
                                <th style="width:10%;text-align:right;">GST Amount</th>
                                <th style="width:10%;text-align:right;">Round off Amount</th>
                                <th style="width:10%;text-align:right;">Net Amount</th>
                                <th style="width:10%; text-align:center;">Status</th>
                                <th style="width:10%; text-align:center;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ( $prOdr as $p )
                                @php
                                    $status = $p['status'] ?? 'CLOSE';
                                    $btnColor = $aedl = '';
                                    if ($status === 'OPEN') {
                                        $btnColor = 'btn-success';
                                        $aedl = 'D';
                                    } else {
                                        $btnColor = 'btn-danger';
                                        $aedl = 'U';
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $p['po_no'] ?? '' }}</td>
                                    <td>{{ $p['supplier_name'] ?? '' }}</td>
                                    <td>{{ $p['po_date'] ?? '' }}</td>
                                    <td style="text-align:right;">{{ $p['gross'] ?? '' }}</td>
                                    <td style="text-align:right;">{{ $p['gstamt'] ?? '' }}</td>
                                    <td style="text-align:right;">{{ $p['roundoff'] ?? '' }}</td>
                                    <td style="text-align:right;">{{ $p['netamt'] ?? '' }}</td>
                                    <td>
                                        <button type='button' class="btn btn-xs {{ $btnColor }} btn-block"
                                            onclick="mtd.show_msg(2, '{{ Route('rawMaterialsInventory.sataPurchaseOrder', ['code' => $p['intno'], 'aedl' => $aedl]) }}', 'Are you sure to change its status..?', 2);">
                                            {{ $status }}
                                        </button>
                                    </td>
                                    <td class="dropdown text-center">
                                        <i class="fas fa-bars ml-2 mr-1" data-toggle="dropdown" href="#"
                                            style="cursor:pointer"></i>
                                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                            <a href="{{ Route('rawMaterialsInventory.purchaseOrderDetails', ['mode'=>'view', 'code'=>$p['intno'] ?? 0]) }}" class="dropdown-item">
                                                <div class="media">
                                                    <div class="media-body">
                                                        <p>View</p>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="{{ Route('rawMaterialsInventory.purchaseOrderDetails', ['mode'=>'edit', 'code'=>$p['intno'] ?? 0]) }}" class="dropdown-item">
                                                <div class="media">
                                                    <div class="media-body">
                                                        <p>Edit</p>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="purchase_details.html" class="dropdown-item">
                                                <div class="media">
                                                    <div class="media-body">
                                                        <p>Go to Purchase</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="9" style="text-align:center">No data available</td></tr>
                            @endforelse
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection
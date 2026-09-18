@extends('layout.app', ['dept' => 'CRM'])
@section('page_title', 'Sales Return')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header py-1">
                    <label for="" class="card-title">Sales Return</label>

                    <button class="btn btn-sm btn-secondary float-right ml-1"
                        onclick="location.href='{{ Route('crm.printSalesReturnList') }}'">
                        <i class="fas fa-print mr-1"></i> Print
                    </button>

                    <button class="btn btn-sm btn-dark float-right"
                        onclick="location.href='{{ route('salesReturnDetails') }}';">
                        <i class="fas fa-plus-circle mr-1"></i> Add New
                    </button>

                    <div class="btn-group float-right mr-2">
                        <button class="btn btn-sm btn-dark"><i class="fas fa-caret-left"></i></button>
                        <input type="date" class="form-control form-control-sm date_today">
                        <button class="btn btn-sm btn-dark"><i class="fas fa-caret-right"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="depttable" class="table table-sm table-bordered text-xs">
                        <thead class="thead-light">
                            <tr>
                                <th style="width:18%">Sales Return No.</th>
                                <th style="width:20%">Customer</th>
                                <th style="width:18%">Quotation No.</th>
                                <th style="width:14%; text-align:right;">Amount</th>
                                <th style="width:12%">Status</th>
                                <th style="width:18%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse( $salesReturns as $sr )
                                @php
                                    $recStatus = $sr['activeyn'] ?? 'N';
                                    $btnColor  = $recStatus === 'Y' ? 'btn-success' : 'btn-danger';
                                    $statusTxt = $recStatus === 'Y' ? 'Active' : 'Inactive';
                                @endphp
                                <tr>
                                    <td>{{ $sr['tranno'] ?? '' }}</td>
                                    <td>{{ $sr['customer_name'] ?? $sr['party_name'] ?? '' }}</td>
                                    <td>
                                        @if(!empty($sr['qutintno']) && $sr['qutintno'] != 0)
                                            QTN-{{ $sr['qutintno'] }}
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td style="text-align:right;">{{ number_format((float)($sr['basic'] ?? 0), 2) }}</td>
                                    <td>
                                        <button type='button' class="btn btn-xs {{ $btnColor }} btn-block"
                                            onclick="mtd.show_msg(2, '{{ route('salesReturn.stat', ['intno' => $sr['intno'], 'actyn' => $sr['activeyn']]) }}', 'Are you sure to change its status..?', 2);">
                                            {{ $statusTxt }}
                                        </button>
                                    </td>
                                    <td class="dropdown text-center">
                                        <i class="fas fa-bars ml-2 mr-1" data-toggle="dropdown" href="#" style="cursor:pointer"></i>
                                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                            <a href="{{ route('salesReturnDetails', ['vwedt' => 1, 'intno' => $sr['intno']]) }}" class="dropdown-item">
                                                <div class="media"><div class="media-body"><p>View</p></div></div>
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="{{ route('salesReturnDetails', ['vwedt' => 2, 'intno' => $sr['intno']]) }}" class="dropdown-item">
                                                <div class="media"><div class="media-body"><p>Edit</p></div></div>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center">No Data Found</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection
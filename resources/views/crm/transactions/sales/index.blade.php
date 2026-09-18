@extends('layout.app', ['dept' => 'CRM'])
@section('page_title', 'Sales')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header py-1">
                    <label for="" class="card-title">Sales</label>

                    <button class="btn btn-sm btn-secondary float-right ml-1"
                        onclick="location.href='{{ Route('crm.printSalesList') }}'">
                        <i class="fas fa-print mr-1"></i> Print
                    </button>

                    <button class="btn btn-sm btn-dark float-right"
                        onclick="location.href='{{ route('salesDetails') }}';">
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
                                <th style="width:18%">Sales No.</th>
                                <th style="width:20%">Customer</th>
                                <th style="width:18%">Quot. No.</th>
                                <th style="width:14%; text-align:right;">Amount</th>
                                <th style="width:12%">Status</th>
                                <th style="width:18%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse( $sales as $s )
                                @php
                                    $recStatus = $s['activeyn'] ?? 'N';
                                    $btnColor  = $recStatus === 'Y' ? 'btn-success' : 'btn-danger';
                                    $statusTxt = $recStatus === 'Y' ? 'Active' : 'Inactive';
                                @endphp
                                <tr>
                                    <td>{{ $s['tranno'] ?? '' }}</td>
                                    <td>{{ $s['customer_name'] ?? $s['party_name'] ?? '' }}</td>
                                    <td>
                                        @if(!empty($s['qutintno']) && $s['qutintno'] != 0)
                                            QTN-{{ $s['qutintno'] }}
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td style="text-align:right;">{{ number_format((float)($s['basic'] ?? 0), 2) }}</td>
                                    <td>
                                        <button type='button' class="btn btn-xs {{ $btnColor }} btn-block"
                                            onclick="mtd.show_msg(2, '{{ route('sales.stat', ['intno' => $s['intno'], 'actyn' => $s['activeyn']]) }}', 'Are you sure to change its status..?', 2);">
                                            {{ $statusTxt }}
                                        </button>
                                    </td>
                                    <td class="dropdown text-center">
                                        <i class="fas fa-bars ml-2 mr-1" data-toggle="dropdown" href="#" style="cursor:pointer"></i>
                                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                            <a href="{{ route('salesDetails', ['vwedt' => 1, 'intno' => $s['intno']]) }}" class="dropdown-item">
                                                <div class="media"><div class="media-body"><p>View</p></div></div>
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="{{ route('salesDetails', ['vwedt' => 2, 'intno' => $s['intno']]) }}" class="dropdown-item">
                                                <div class="media"><div class="media-body"><p>Edit</p></div></div>
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="{{ route('receiptDetails') }}?salesintno={{ $s['intno'] }}&partycd={{ $s['partycd'] }}" class="dropdown-item">
                                                <div class="media"><div class="media-body"><p>Create Receipt</p></div></div>
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
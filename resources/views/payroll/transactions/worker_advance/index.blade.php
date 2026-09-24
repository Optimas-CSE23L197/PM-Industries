@extends('layout.app', ['dept' => 'Payroll'])
@section('page_title', 'Advance to Worker')

@section('content')

<section class="content mt-3">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header py-1">
                <label class="card-title">Advance to Worker</label>
                <button class="btn btn-sm btn-secondary float-right ml-1"
                    onclick="location.href='{{ route('payroll.printWorkerAdvanceList') }}'">
                    <i class="fas fa-print mr-1"></i> Print
                </button>
                <button class="btn btn-sm btn-dark float-right"
                    onclick="location.href='{{ route('payroll.workerAdvanceDetails') }}';">
                    <i class="fas fa-plus-circle mr-1"></i> Add New
                </button>
            </div>
            <div class="card-body">
                <table id="depttable" class="table table-sm table-bordered text-xs">
                    <thead class="thead-light">
                        <tr>
                            <th style="width:15%">Advance No.</th>
                            <th style="width:15%">Contractor</th>
                            <th style="width:12%">Worker</th>
                            <th style="width:15%">Contractor Bill</th>
                            <th style="width:10%" class="text-right">Amount</th>
                            <th style="width:10%" class="text-right">Adj. Amount</th>
                            <th style="width:10%" class="text-right">Balance Amount</th>
                            <th style="width:8%">Status</th>
                            <th style="width:5%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($advances as $adv)
                            @php
                                $status   = $adv['activeyn'] ?? 'N';
                                $btnColor = $status === 'Y' ? 'btn-success' : 'btn-danger';
                                $statusTxt = $status === 'Y' ? 'Active' : 'Inactive';
                            @endphp
                            <tr>
                                <td>{{ $adv['advance_no'] ?? '-' }}</td>
                                <td>{{ $adv['contractor_name'] ?? '-' }}</td>
                                <td>{{ $adv['worker_name'] ?? '-' }}</td>
                                <td>{{ $adv['contractorbillcd'] ?? '-' }}</td>
                                <td class="text-right">{{ number_format($adv['amount'] ?? 0, 2) }}</td>
                                <td class="text-right">{{ number_format($adv['adjustment_amount'] ?? 0, 2) }}</td>
                                <td class="text-right">{{ number_format($adv['balance_amount'] ?? 0, 2) }}</td>
                                <td>
                                    <button type='button' class="btn btn-xs {{ $btnColor }} btn-block"
                                        onclick="mtd.show_msg(2, '{{ route('payroll.workerAdvance.stat', ['intno' => $adv['intno'], 'actyn' => $adv['activeyn']]) }}', 'Are you sure to change its status..?', 2);"
                                    >
                                        {{ $statusTxt }}
                                    </button>
                                </td>
                                <td class="dropdown text-center">
                                    <i class="fas fa-bars ml-2 mr-1" data-toggle="dropdown" href="#"
                                        style="cursor:pointer"></i>
                                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                        <a href="{{ route('payroll.workerAdvanceDetails', ['vwedt' => 1, 'intno' => $adv['intno']]) }}" class="dropdown-item">
                                            <div class="media"><div class="media-body"><p>View</p></div></div>
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a href="{{ route('payroll.workerAdvanceDetails', ['vwedt' => 2, 'intno' => $adv['intno']]) }}" class="dropdown-item">
                                            <div class="media"><div class="media-body"><p>Edit</p></div></div>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No Data Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

@endsection
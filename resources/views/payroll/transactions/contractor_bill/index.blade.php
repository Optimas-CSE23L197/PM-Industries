@extends('layout.app', ['dept' => 'Payroll'])
@section('page_title', 'Contractor Bill')

@section('content')

<section class="content mt-3">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header py-1">
                <label class="card-title">Contractor Bill</label>
                <button class="btn btn-sm btn-secondary float-right ml-1"
                    onclick="location.href='{{ route('payroll.printContractorBillList') }}'">
                    <i class="fas fa-print mr-1"></i> Print
                </button>
                <button class="btn btn-sm btn-dark float-right"
                    onclick="location.href='{{ route('payroll.contractorBillDetails') }}';">
                    <i class="fas fa-plus-circle mr-1"></i> Add New
                </button>
            </div>
            <div class="card-body">
                <table id="depttable" class="table table-sm table-bordered text-xs">
                    <thead class="thead-light">
                        <tr>
                            <th style="width:15%">Bill No.</th>
                            <th style="width:15%">Contractor</th>
                            <th style="width:10%" class="text-right">Gross Amount</th>
                            <th style="width:10%" class="text-right">Adv. Adj.</th>
                            <th style="width:10%" class="text-right">Net Amount</th>
                            <th style="width:10%" class="text-center">Approval Status</th>
                            <th style="width:10%">Approved By</th>
                            <th style="width:10%">Approved At</th>
                            <th style="width:5%">Status</th>
                            <th style="width:5%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bills as $bill)
                            @php
                                $status   = $bill['activeyn'] ?? 'N';
                                $btnColor = $status === 'Y' ? 'btn-success' : 'btn-danger';
                                $statusTxt = $status === 'Y' ? 'Active' : 'Inactive';

                                $appStatus = strtoupper($bill['approval_status'] ?? 'PENDING');
                                $appColor = 'text-warning';
                                if ($appStatus === 'APPROVED') $appColor = 'text-success';
                                elseif ($appStatus === 'REJECTED') $appColor = 'text-danger';
                            @endphp
                            <tr>
                                <td>{{ $bill['bill_no'] ?? '-' }}</td>
                                <td>{{ $bill['contractor_name'] ?? '-' }}</td>
                                <td class="text-right">{{ number_format($bill['gross_amount'] ?? 0, 2) }}</td>
                                <td class="text-right">{{ number_format($bill['advance_adjustment'] ?? 0, 2) }}</td>
                                <td class="text-right">{{ number_format($bill['net_amount'] ?? 0, 2) }}</td>
                                <td class="text-center">
                                    <span class="{{ $appColor }} font-weight-bold">{{ ucfirst(strtolower($appStatus)) }}</span>
                                </td>
                                <td>{{ $bill['approved_by_name'] ?? '-' }}</td>
                                <td>{{ !empty($bill['approved_at']) ? date('d/m/Y h:i A', strtotime($bill['approved_at'])) : '-' }}</td>
                                <td>
                                    <button type='button' class="btn btn-xs {{ $btnColor }} btn-block"
                                        onclick="mtd.show_msg(2, '{{ route('payroll.contractorBill.stat', ['intno' => $bill['intno'], 'actyn' => $bill['activeyn']]) }}', 'Are you sure to change its status..?', 2);"
                                    >
                                        {{ $statusTxt }}
                                    </button>
                                </td>
                                <td class="dropdown text-center">
                                    <i class="fas fa-bars ml-2 mr-1" data-toggle="dropdown" href="#"
                                        style="cursor:pointer"></i>
                                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                        <a href="{{ route('payroll.contractorBillDetails', ['vwedt' => 1, 'intno' => $bill['intno']]) }}" class="dropdown-item">
                                            <div class="media"><div class="media-body"><p>View</p></div></div>
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a href="{{ route('payroll.contractorBillDetails', ['vwedt' => 2, 'intno' => $bill['intno']]) }}" class="dropdown-item">
                                            <div class="media"><div class="media-body"><p>Edit</p></div></div>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">No Data Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

@endsection
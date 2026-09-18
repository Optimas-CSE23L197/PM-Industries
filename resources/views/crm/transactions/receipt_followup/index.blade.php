@extends('layout.app', ['dept' => 'CRM'])
@section('page_title', 'Receipt Followup')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header py-1">
                    <label for="" class="card-title">Receipt Followup</label>

                    <button class="btn btn-sm btn-secondary float-right ml-1"
                        onclick="location.href='{{ Route('crm.printReceiptFollowupList') }}'">
                        <i class="fas fa-print mr-1"></i> Print
                    </button>

                    <button class="btn btn-sm btn-dark float-right"
                        onclick="location.href='{{ route('receiptFollowupDetails') }}';">
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
                                <th style="width:18%">Invoice No.</th>
                                <th style="width:22%">Customer</th>
                                <th style="width:22%">Narration</th>
                                <th style="width:14%">Next Followup Date</th>
                                <th style="width:12%">Status</th>
                                <th style="width:12%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse( $followups as $f )
                                @php
                                    $recStatus = $f['activeyn'] ?? 'N';
                                    $btnColor  = $recStatus === 'Y' ? 'btn-success' : 'btn-danger';
                                    $statusTxt = $recStatus === 'Y' ? 'Active' : 'Inactive';
                                @endphp
                                <tr>
                                    <td>
                                        {{ $f['invoice_no'] ?? $f['rcptno'] ?? 'INV-'.$f['billintno'] ?? '' }}
                                    </td>
                                    <td>{{ $f['customer_name'] ?? $f['party_name'] ?? '' }}</td>
                                    <td>{{ $f['remarks'] ?? '' }}</td>
                                    <td>{{ $f['next_followup_date'] ?? '' }}</td>
                                    <td>
                                        <button type='button' class="btn btn-xs {{ $btnColor }} btn-block"
                                            onclick="mtd.show_msg(2, '{{ route('receiptFollowup.stat', ['intno' => $f['intno'], 'actyn' => $f['activeyn']]) }}', 'Are you sure to change its status..?', 2);">
                                            {{ $statusTxt }}
                                        </button>
                                    </td>
                                    <td class="dropdown text-center">
                                        <i class="fas fa-bars ml-2 mr-1" data-toggle="dropdown" href="#" style="cursor:pointer"></i>
                                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                            <a href="{{ route('receiptFollowupDetails', ['vwedt' => 1, 'intno' => $f['intno']]) }}" class="dropdown-item">
                                                <div class="media"><div class="media-body"><p>View</p></div></div>
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="{{ route('receiptFollowupDetails', ['vwedt' => 2, 'intno' => $f['intno']]) }}" class="dropdown-item">
                                                <div class="media"><div class="media-body"><p>Edit</p></div></div>
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="{{ route('receiptFollowupDetails', ['vwedt' => 4]) }}?parent_followup_intno={{ $f['intno'] }}&billintno={{ $f['billintno'] }}" class="dropdown-item">
                                                <div class="media"><div class="media-body"><p>Follow Up</p></div></div>
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item"
                                               onclick="event.preventDefault(); mtd.show_msg(2, '{{ route('receiptFollowup.stat', ['intno' => $f['intno'], 'actyn' => $f['activeyn']]) }}', 'Are you sure to change its status..?', 2);">
                                                <div class="media"><div class="media-body">
                                                    <p>{{ $recStatus === 'Y' ? 'Deactivate' : 'Activate' }}</p>
                                                </div></div>
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
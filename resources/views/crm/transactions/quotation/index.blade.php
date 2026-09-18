@extends('layout.app', ['dept' => 'CRM'])
@section('page_title', 'Quotation')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header py-1">
                    <label for="" class="card-title">Quotation</label>

                    <button class="btn btn-sm btn-secondary float-right ml-1"
                        onclick="location.href='{{ Route('crm.printQuotationList') }}'">
                        <i class="fas fa-print mr-1"></i> Print
                    </button>

                    <button class="btn btn-sm btn-dark float-right"
                        onclick="location.href='{{ route('quotationDetails') }}';">
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
                                <th style="width:16%">Quotation No.</th>
                                <th style="width:12%">Quotation Date</th>
                                <th style="width:18%">Against Enquiry</th>
                                <th style="width:18%">Customer</th>
                                <th style="width:12%; text-align:right;">Net Amount</th>
                                <th style="width:12%">Status</th>
                                <th style="width:12%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse( $quotations as $q )
                                @php
                                    $recStatus = $q['activeyn'] ?? 'N';
                                    $btnColor  = $recStatus === 'Y' ? 'btn-success' : 'btn-danger';
                                    $statusTxt = $recStatus === 'Y' ? 'Active' : 'Inactive';
                                @endphp
                                <tr>
                                    <td>{{ $q['quotation_no'] ?? '' }}</td>
                                    <td>{{ $q['quotation_date'] ?? '' }}</td>
                                    <td>{{ $q['enquiry_no'] ?? '' }}</td>
                                    <td>{{ $q['customer_name'] ?? '' }}</td>
                                    <td style="text-align:right;">{{ number_format((float)($q['net_amount'] ?? 0), 2) }}</td>
                                    <td>
                                        <button type='button' class="btn btn-xs {{ $btnColor }} btn-block"
                                            onclick="mtd.show_msg(2, '{{ route('quotation.stat', ['intno' => $q['intno'], 'actyn' => $q['activeyn']]) }}', 'Are you sure to change its status..?', 2);">
                                            {{ $statusTxt }}
                                        </button>
                                    </td>
                                    <td class="dropdown text-center">
                                        <i class="fas fa-bars ml-2 mr-1" data-toggle="dropdown" href="#" style="cursor:pointer"></i>
                                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                            <a href="{{ route('quotationDetails', ['vwedt' => 1, 'intno' => $q['intno']]) }}" class="dropdown-item">
                                                <div class="media"><div class="media-body"><p>View</p></div></div>
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="{{ route('quotationDetails', ['vwedt' => 2, 'intno' => $q['intno']]) }}" class="dropdown-item">
                                                <div class="media"><div class="media-body"><p>Edit</p></div></div>
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="{{ route('quotationFollowupDetails', ['vwedt' => 3]) }}?quotationintno={{ $q['intno'] }}" class="dropdown-item">
                                                <div class="media"><div class="media-body"><p>Followup</p></div></div>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="text-center">No Data Found</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection
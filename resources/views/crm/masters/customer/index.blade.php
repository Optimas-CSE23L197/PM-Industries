@extends('layout.app', ['dept' => 'CRM'])
@section('page_title', 'Customer')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header py-1">
                    <label for="" class="card-title">Customer</label>

                    <button class="btn btn-sm btn-secondary float-right ml-1"
                        onclick="location.href='{{ Route('crm.printCustomerList') }}'">
                        <i class="fas fa-print mr-1"></i> Print
                    </button>

                    <button class="btn btn-sm btn-dark float-right"
                        onclick="location.href='{{ route('customerDetails') }}';">
                        <i class="fas fa-plus-circle mr-1"></i>
                        Add New
                    </button>
                </div>
                <div class="card-body">
                    <table id="depttable" class="table table-sm table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th style="width:35%">Name</th>
                                <th style="width:25%">Contact Person</th>
                                <th style="width:15%">Phone No.</th>
                                <th style="width:10%">Status</th>
                                <th style="width:15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse( $customers as $c )
                                @php
                                    $status   = $c['activeyn'] ?? 'N';
                                    $btnColor = '';
                                    if( $status === 'Y' ) {
                                        $status   = 'Active';
                                        $btnColor = 'btn-success';
                                    } elseif ( $status === 'N' ) {
                                        $status   = 'Inactive';
                                        $btnColor = 'btn-danger';
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $c['name'] ?? '' }}</td>
                                    <td>{{ $c['contact_person'] ?? '' }}</td>
                                    <td>{{ $c['phone'] ?? '' }}</td>
                                    <td>
                                        <button type='button' class="btn btn-xs {{ $btnColor }} btn-block"
                                            onclick="mtd.show_msg(2, '{{ route('customer.stat', ['code' => $c['code'], 'actyn' => $c['activeyn']]) }}', 'Are you sure to change its status..?', 2);">
                                            {{ $status }}
                                        </button>
                                    </td>
                                    <td class="dropdown text-center">
                                        <i class="fas fa-bars ml-2 mr-1" data-toggle="dropdown" href="#" style="cursor:pointer"></i>
                                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                            <a href="{{ route('customerDetails', ['vwedt' => 1, 'code' => $c['code']]) }}" class="dropdown-item">
                                                <div class="media"><div class="media-body"><p>View</p></div></div>
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="{{ route('customerDetails', ['vwedt' => 2, 'code' => $c['code']]) }}" class="dropdown-item">
                                                <div class="media"><div class="media-body"><p>Edit</p></div></div>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No Data Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection
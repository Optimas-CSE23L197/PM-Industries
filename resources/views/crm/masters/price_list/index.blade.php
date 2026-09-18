@extends('layout.app', ['dept' => 'CRM'])
@section('page_title', 'Price List')

@section('content')
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header py-1">
                    <label class="card-title">Price List</label>

                    <button class="btn btn-sm btn-secondary float-right ml-1"
                        onclick="location.href='{{ Route('crm.printPriceList') }}'">
                        <i class="fas fa-print mr-1"></i> Print
                    </button>

                    <button class="btn btn-sm btn-dark float-right"
                        onclick="location.href='{{ route('priceListDetails') }}';">
                        <i class="fas fa-plus-circle mr-1"></i> Add New
                    </button>
                </div>
                <div class="card-body">
                    <table id="depttable" class="table table-sm table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th style="width:40%">Name</th>
                                <th style="width:15%">Valid From</th>
                                <th style="width:15%">Valid To</th>
                                <th style="width:15%">Status</th>
                                <th style="width:15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse( $priceLists as $pl )
                                @php
                                    $status   = $pl['activeyn'] ?? 'N';
                                    $btnColor = $status === 'Y' ? 'btn-success' : 'btn-danger';
                                    $status   = $status === 'Y' ? 'Active' : 'Inactive';
                                @endphp
                                <tr>
                                    <td>{{ $pl['name'] ?? '' }}</td>
                                    <td>{{ $pl['valid_from'] ?? '' }}</td>
                                    <td>{{ $pl['valid_to'] ?? '' }}</td>
                                    <td>
                                        <button type='button' class="btn btn-xs {{ $btnColor }} btn-block"
                                            onclick="mtd.show_msg(2, '{{ route('priceList.stat', ['code' => $pl['code'], 'actyn' => $pl['activeyn']]) }}', 'Are you sure to change its status..?', 2);">
                                            {{ $status }}
                                        </button>
                                    </td>
                                    <td class="dropdown text-center">
                                        <i class="fas fa-bars ml-2 mr-1" data-toggle="dropdown" href="#" style="cursor:pointer"></i>
                                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                            <a href="{{ route('priceListDetails', ['vwedt' => 1, 'code' => $pl['code']]) }}" class="dropdown-item"><p>View</p></a>
                                            <div class="dropdown-divider"></div>
                                            <a href="{{ route('priceListDetails', ['vwedt' => 2, 'code' => $pl['code']]) }}" class="dropdown-item"><p>Edit</p></a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center">No Data Found</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
@extends('productions.layout.app')
@section('page_title', 'Maintenance Type')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header py-1">
                    <label for="" class="card-title">Maintenance Type</label>
                    <button class="btn btn-sm btn-dark float-right"
                        onclick="location.href='{{ route('maintenanceTypeDetails') }}';">
                        <i class="fas fa-plus-circle mr-1"></i>
                        Add New
                    </button>
                </div>
                <div class="card-body">
                    <table id="depttable" class="table table-sm table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th style="width:80%">Name</th>
                                <th style="width:10%">Status</th>
                                <th style="width:10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse( $maintenanceTypes as $mt )
                                @php
                                    $status = $mt['activeyn'] ?? 'N';
                                    $btnColor = $aedl = '';
                                    if( $status === 'Y' ) {
                                        $status = 'Active';
                                        $btnColor = 'btn-success';
                                        $aedl = 'D';
                                    } elseif ( $status === 'N' ) {
                                        $status = 'Inactive';
                                        $btnColor = 'btn-danger';
                                        $aedl = 'U';
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $mt['name'] ?? '' }}</td>
                                    <td>
                                        <button type='button' class="btn btn-xs {{ $btnColor }} btn-block"
                                            onclick="mtd.show_msg(2, '{{ route('maintenanceType.stat', ['code' => $mt['code'], 'actyn' => $mt['activeyn']]) }}', 'Are you sure to change its status..?', 2);"
                                        >
                                            {{ $status }}
                                        </button>
                                    </td>
                                    <td class="dropdown text-center">
                                        <i class="fas fa-bars ml-2 mr-1" data-toggle="dropdown" href="#"
                                            style="cursor:pointer"></i>
                                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                            <a href="{{ route('maintenanceTypeDetails', ['vwedt' => 1, 'code' => $mt['code']]) }}" class="dropdown-item">
                                                <div class="media">
                                                    <div class="media-body">
                                                        <p>View</p>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="{{ route('maintenanceTypeDetails', ['vwedt' => 2, 'code' => $mt['code']]) }}" class="dropdown-item">
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
                                    <td colspan="3" class="text-center">No Data Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection
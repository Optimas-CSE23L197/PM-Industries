@extends('productions.layout.app')
@section('page_title', 'Machine')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header py-1">
                    <label for="" class="card-title">Machine</label>
                    <button class="btn btn-sm btn-dark float-right"
                        onclick="location.href='{{ route('machineDetails') }}';">
                        <i class="fas fa-plus-circle mr-1"></i>
                        Add New
                    </button>
                </div>
                <div class="card-body">
                    <table id="depttable" class="table table-sm table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th style="width:25%">Name</th>
                                <th style="width:15%">Model No.</th>
                                <th style="width:15%">Serial No.</th>
                                <th style="width:15%">Next Maintenance Date</th>
                                <th style="width:10%">Status</th>
                                <th style="width:10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse( $machines as $m )
                                @php
                                    $status = $m['activeyn'] ?? 'N';
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
                                    <td>{{ $m['name'] ?? '' }}</td>
                                    <td>{{ $m['model_no'] ?? '' }}</td>
                                    <td>{{ $m['serial_no'] ?? '' }}</td>
                                    <td>{{ $m['next_maintenance_date'] ?? '' }}</td>
                                    <td>
                                        <button type='button' class="btn btn-xs {{ $btnColor }} btn-block"
                                            onclick="mtd.show_msg(2, '{{ route('machine.stat', ['code' => $m['code'], 'actyn' => $m['activeyn']]) }}', 'Are you sure to change its status..?', 2);"
                                        >
                                            {{ $status }}
                                        </button>
                                    </td>
                                    <td class="dropdown text-center">
                                        <i class="fas fa-bars ml-2 mr-1" data-toggle="dropdown" href="#"
                                            style="cursor:pointer"></i>
                                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                            <a href="{{ route('machineDetails', ['vwedt' => 1, 'code' => $m['code']]) }}" class="dropdown-item">
                                                <div class="media">
                                                    <div class="media-body">
                                                        <p>View</p>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="{{ route('machineDetails', ['vwedt' => 2, 'code' => $m['code']]) }}" class="dropdown-item">
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
                                    <td colspan="6" class="text-center">No Data Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection
@extends('layout.app', ['dept' => 'Payroll'])
@section('page_title', 'Worker')

@section('content')

<section class="content mt-3">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header py-1">
                <label class="card-title">Worker</label>
                <button class="btn btn-sm btn-secondary float-right ml-1"
                    onclick="location.href='{{ route('payroll.printWorkerList') }}'">
                    <i class="fas fa-print mr-1"></i> Print
                </button>
                <button class="btn btn-sm btn-dark float-right"
                    onclick="location.href='{{ route('payroll.workerDetails') }}';">
                    <i class="fas fa-plus-circle mr-1"></i> Add New
                </button>
            </div>
            <div class="card-body">
                <table id="depttable" class="table table-sm table-bordered text-xs">
                    <thead class="thead-light">
                        <tr>
                            <th style="width:45%">Name</th>
                            <th style="width:35%">Contractor</th>
                            <th style="width:12%">Status</th>
                            <th style="width:8%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($workers as $worker)
                            @php
                                $status   = $worker['activeyn'] ?? 'N';
                                $btnColor = '';
                                if ($status === 'Y') {
                                    $status   = 'Active';
                                    $btnColor = 'btn-success';
                                } elseif ($status === 'N') {
                                    $status   = 'Inactive';
                                    $btnColor = 'btn-danger';
                                }
                            @endphp
                            <tr>
                                <td>{{ $worker['name'] ?? '-' }}</td>
                                <td>{{ $worker['contractor_name'] ?? $worker['contractornm'] ?? '-' }}</td>
                                <td>
                                    <button type='button' class="btn btn-xs {{ $btnColor }} btn-block"
                                        onclick="mtd.show_msg(2, '{{ route('payroll.worker.stat', ['code' => $worker['code'], 'actyn' => $worker['activeyn']]) }}', 'Are you sure to change its status..?', 2);"
                                    >
                                        {{ $status }}
                                    </button>
                                </td>
                                <td class="dropdown text-center">
                                    <i class="fas fa-bars ml-2 mr-1" data-toggle="dropdown" href="#"
                                        style="cursor:pointer"></i>
                                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                        <a href="{{ route('payroll.workerDetails', ['vwedt' => 1, 'code' => $worker['code']]) }}" class="dropdown-item">
                                            <div class="media"><div class="media-body"><p>View</p></div></div>
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a href="{{ route('payroll.workerDetails', ['vwedt' => 2, 'code' => $worker['code']]) }}" class="dropdown-item">
                                            <div class="media"><div class="media-body"><p>Edit</p></div></div>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No Data Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

@endsection
@extends('layout.app', ['dept' => 'CRM'])
@section('page_title', 'Lead Source')

@section('content')
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header py-1">
                    <label class="card-title">Lead Source</label>

                    <button class="btn btn-sm btn-secondary float-right ml-1"
                        onclick="location.href='{{ Route('crm.printLeadSourceList') }}'">
                        <i class="fas fa-print mr-1"></i> Print
                    </button>

                    <button class="btn btn-sm btn-dark float-right"
                        onclick="location.href='{{ route('leadSourceDetails') }}';">
                        <i class="fas fa-plus-circle mr-1"></i> Add New
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
                            @forelse( $leadSources as $ls )
                                @php
                                    $status   = $ls['activeyn'] ?? 'N';
                                    $btnColor = $status === 'Y' ? 'btn-success' : 'btn-danger';
                                    $status   = $status === 'Y' ? 'Active' : 'Inactive';
                                @endphp
                                <tr>
                                    <td>{{ $ls['name'] ?? '' }}</td>
                                    <td>
                                        <button type='button' class="btn btn-xs {{ $btnColor }} btn-block"
                                            onclick="mtd.show_msg(2, '{{ route('leadSource.stat', ['code' => $ls['code'], 'actyn' => $ls['activeyn']]) }}', 'Are you sure to change its status..?', 2);">
                                            {{ $status }}
                                        </button>
                                    </td>
                                    <td class="dropdown text-center">
                                        <i class="fas fa-bars ml-2 mr-1" data-toggle="dropdown" href="#" style="cursor:pointer"></i>
                                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                            <a href="{{ route('leadSourceDetails', ['vwedt' => 1, 'code' => $ls['code']]) }}" class="dropdown-item"><p>View</p></a>
                                            <div class="dropdown-divider"></div>
                                            <a href="{{ route('leadSourceDetails', ['vwedt' => 2, 'code' => $ls['code']]) }}" class="dropdown-item"><p>Edit</p></a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center">No Data Found</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
@extends('company.layout.app')

@section('pageTitle', 'Company')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header py-1">
                    <label for="" class="card-title">Company</label>
                    <button class="btn btn-sm btn-dark float-right"
                        onclick="location.href='{{ Route("compDetails", "new") }}';"><i class="fas fa-plus-circle mr-1"></i>
                        Add New</button>
                </div>
                <div class="card-body">
                    <table id="depttable" class="table table-sm table-bordered text-xs">
                        <thead class="thead-light">
                            <tr>
                                <th style="width:80%">Name</th>
                                <th style="width:10%">Status</th>
                                <th style="width:10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($comp as $c)
                             @php
                                $status = $c['activeyn'] ?? 'N';
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
                                    <td>{{ $c['name'] }}</td>
                                    <td>
                                        <button type='button' class="btn btn-xs {{ $btnColor }} btn-block"
                                            onclick="mtd.show_msg(2, '{{route('statComp', ['code' => $c['code'], 'aedl'=>$aedl])}}', 'Are you sure to change its status..?', 2);"
                                        >
                                            {{ $status }}
                                        </button>
                                    </td>
                                    <td class="dropdown text-center">
                                        <i class="fas fa-bars ml-2 mr-1" data-toggle="dropdown" href="#"
                                            style="cursor:pointer"></i>
                                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                            <a href="{{ Route('compDetails', ['mode'=>'view', 'code'=>$c['code']]) }}" class="dropdown-item">
                                                <div class="media">
                                                    <div class="media-body">
                                                        <p>View</p>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="{{ Route('compDetails', ['mode'=>'edit', 'code'=>$c['code']]) }}" class="dropdown-item">
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
                                <tr><td colspan="3" style="text-align:center;">No data available</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection
@extends('rawMaterialsInventory.layout.app')
@section('page_title', 'Raw Item Type')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header py-1">
                    <label for="" class="card-title">Raw Item Type</label>
                    <button class="btn btn-sm btn-dark float-right"
                        onclick="location.href='{{ Route('rawMaterialsInventory.rawMaterialTypeDetails', 'new') }}';">
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
                            @forelse($rmType as $r)
                                @php
                                    $status = $r['active_yn'] ?? 'N';
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
                                    <td>{{ $r['name'] ?? '' }}</td>
                                    <td>
                                        <button type='button' class="btn btn-xs {{ $btnColor }} btn-block"
                                            onclick="mtd.show_msg(2, '{{route('rawMaterialsInventory.rawMaterialTypeStatChange', ['code' => $r['code'], 'aedl'=>$aedl])}}', 'Are you sure to change its status..?', 2);"
                                        >
                                            {{ $status }}
                                        </button>
                                    </td>
                                    <td class="dropdown text-center">
                                        <i class="fas fa-bars ml-2 mr-1" data-toggle="dropdown" href="#"
                                            style="cursor:pointer"></i>
                                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                            <a href="{{ Route('rawMaterialsInventory.rawMaterialTypeDetails', ['mode' => 'view', 'code' => $r['code']]) }}" class="dropdown-item">
                                                <div class="media">
                                                    <div class="media-body">
                                                        <p>View</p>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="{{ Route('rawMaterialsInventory.rawMaterialTypeDetails', ['mode' => 'edit', 'code' => $r['code']]) }}" class="dropdown-item">
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
@extends('layout.app', ['dept' => 'Raw Material Inventory'])

@section('page_title_link')
    {{ route('rawMaterialsInventory.issueToDeptList') }}
@endsection

@section('page_titleH', 'Issue to Departments')
@section('page_title', 'Print')

@section('content')

    <div class="card">
        <div class="card-header py-1">
            <label class="card-title">Issue to Departments</label>
            @include('includes.print_btn')
        </div>
        <div class="card-body print">
            {{-- company header --}}
            <div style="text-align: center; margin-bottom: 20px; border-bottom: 2px solid #343a40; padding-bottom: 10px;">
                <h3 style="margin: 0; font-weight: bold; letter-spacing: 1px">
                    {{ $compnm ?? 'PM-Industries' }}
                </h3>
                <h5 style="margin: 10px 0 0 0; text-transform: uppercase; letter-spacing: 2px; color: #343a40;">Issue to Departments Transaction List</h5>
            </div>
            {{-- company header end --}}

            <table class="table table-bordered" width="100%" border="1"
                data-tableName="@php echo 'Issue-to-Departments-Transaction_'.date('dmHis'); @endphp" data-pageO="p"
                data-pdfmode="download" cellspacing="0" cellpadding="4">
                <thead>
                    <tr style="background-color: #343a40; color: #fff;">
                        <th style="width:10%; text-align: center;">Sl. No</th>
                        <th style="width:30%">Issue No.</th>
                        <th style="width:25%">From Department</th>
                        <th style="width:25%">To Department</th>
                        <th style="width:10%; text-align:center;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($resp as $i => $res)
                        <tr style="{{ $i % 2 == 0 ? 'background-color: #f8f9fa' : 'background-color: #fff' }}">
                            <td style="text-align: center">{{ $i + 1 }}</td>
                            <td>{{ $res['issue_no'] ?? '' }}</td>
                            <td>{{ $res['from_department_name'] ?? '' }}</td>
                            <td>{{ $res['to_department_name'] ?? '' }}</td>
                            <td style="color: {{ ($res['activeyn'] ?? 'N') === 'Y' ? 'green' : 'red' }}; text-align: center;">
                                {{ ($res['activeyn'] ?? 'N') === 'Y' ? 'Active' : 'Inactive' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 20px;">No records found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- footer --}}
            <div style="margin-top: 20px; border-top: 2px solid #343a40; padding-top: 10px;">
                <div style="display: flex; justify-content: space-between;">
                    <div>
                        <strong>Total Records:</strong> {{ is_array($resp) ? count($resp) : 0 }}
                    </div>
                    <div>
                        <strong>Generated On:</strong> {{ date('d-m-Y H:i:s') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ asset('js/print.js') }}"></script>
    @endpush

@endsection
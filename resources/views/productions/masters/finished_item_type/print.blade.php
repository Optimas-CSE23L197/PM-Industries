@extends('layout.app', ['dept' => 'Production'])

@section('page_title_link')
    {{ route('finishedItemType') }}
@endsection

@section('page_titleH', 'Finished Item Type')
@section('page_title', 'Print')

@section('content')
    <div class="card">
        <div class="card-header py-1">
            <label class="card-title">Finished Item Type</label>
            @include('includes.print_btn')
        </div>
        <div class="card-body print">
            {{-- company header --}}
            <div style="text-align: center; margin-bottom: 20px; border-bottom: 2px solid #343a40; padding-bottom: 10px;">
                <h3 style="margin: 0; font-weight: bold; letter-spacing: 1px">
                    {{ $compnm ?? 'PM-Industries' }}
                </h3>
                <h5 style="margin: 10px 0 0 0; text-transform: uppercase; letter-spacing: 2px; color: #343a40;">
                    Finished Item Type Master List
                </h5>
            </div>
            {{-- company header end --}}

            <table class="table table-bordered" width="100%" border="1"
                data-tableName="@php echo 'Finished-Item-Type-Master_'.date('dmHis'); @endphp" data-pageO="p"
                data-pdfmode="download" cellspacing="0" cellpadding="4">
                <thead>
                    <tr style="background-color: #343a40; color: #fff;">
                        <th style="width: 10%; text-align: center;">Sl. No</th>
                        <th style="width: 70%; text-align: left;">Name</th>
                        <th style="width: 20%; text-align: center;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($finishedItemTypes as $i => $f)
                        <tr style="{{ $i % 2 == 0 ? 'background-color: #f8f9fa' : 'background-color: #fff' }}">
                            <td style="text-align: center">{{ $i + 1 }}</td>
                            <td>{{ $f['name'] ?? '' }}</td>
                            <td style="color: {{ ($f['activeyn'] ?? 'N') === 'Y' ? 'green' : 'red' }}; text-align: center;">
                                {{ ($f['activeyn'] ?? 'N') === 'Y' ? 'Active' : 'Inactive' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center; padding: 20px;">No records found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- footer --}}
            <div style="margin-top: 20px; border-top: 2px solid #343a40; padding-top: 10px;">
                <div style="display: flex; justify-content: space-between;">
                    <div>
                        <strong>Total Records:</strong> {{ is_array($finishedItemTypes) ? count($finishedItemTypes) : 0 }}
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
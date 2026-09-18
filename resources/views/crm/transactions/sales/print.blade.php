@extends('layout.app', ['dept' => 'CRM'])

@section('page_title_link')
    {{ route('sales') }}
@endsection

@section('page_titleH', 'Sales')
@section('page_title', 'Print')

@section('content')
    <div class="card">
        <div class="card-header py-1">
            <label class="card-title">Sales</label>
            @include('includes.print_btn')
        </div>
        <div class="card-body print">
            {{-- Company Header --}}
            <div style="text-align: center; margin-bottom: 20px; border-bottom: 2px solid #343a40; padding-bottom: 10px;">
                <h3 style="margin: 0; font-weight: bold; letter-spacing: 1px">
                    {{ $compnm ?? 'PM-Industries' }}
                </h3>
                <h5 style="margin: 10px 0 0 0; text-transform: uppercase; letter-spacing: 2px; color: #343a40;">
                    Sales Transaction List
                </h5>
            </div>
            {{-- Company Header End --}}

            <table class="table table-bordered" width="100%" border="1"
                data-tableName="@php echo 'Sales-List_'.date('dmHis'); @endphp" data-pageO="l"
                data-pdfmode="download" cellspacing="0" cellpadding="4">
                <thead>
                    <tr style="background-color: #343a40; color: #fff;">
                        <th style="width: 6%;  text-align: center;">Sl. No</th>
                        <th style="width: 16%; text-align: left;">Sales No.</th>
                        <th style="width: 12%; text-align: center;">Date</th>
                        <th style="width: 20%; text-align: left;">Customer</th>
                        <th style="width: 14%; text-align: left;">Quot. No.</th>
                        <th style="width: 12%; text-align: right;">Basic Amount</th>
                        <th style="width: 10%; text-align: right;">Net Amount</th>
                        <th style="width: 10%; text-align: center;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $i => $s)
                        <tr style="{{ $i % 2 == 0 ? 'background-color: #f8f9fa' : 'background-color: #fff' }}">
                            <td style="text-align: center">{{ $i + 1 }}</td>
                            <td>{{ $s['tranno'] ?? '' }}</td>
                            <td style="text-align: center">{{ $s['trandt'] ?? '' }}</td>
                            <td>{{ $s['customer_name'] ?? $s['party_name'] ?? '' }}</td>
                            <td>{{ !empty($s['qutintno']) && $s['qutintno'] != 0 ? 'QTN-'.$s['qutintno'] : '—' }}</td>
                            <td style="text-align: right">{{ number_format((float)($s['basic'] ?? 0), 2) }}</td>
                            <td style="text-align: right">{{ number_format((float)($s['basic'] ?? 0) + (float)($s['cgstamt'] ?? 0) + (float)($s['sgstamt'] ?? 0) + (float)($s['igstamt'] ?? 0) + (float)($s['localconvamt'] ?? 0) + (float)($s['otheramt'] ?? 0) - (float)($s['discamt'] ?? 0), 2) }}</td>
                            <td style="color: {{ ($s['activeyn'] ?? 'N') === 'Y' ? 'green' : 'red' }}; text-align: center;">
                                {{ ($s['activeyn'] ?? 'N') === 'Y' ? 'Active' : 'Inactive' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 20px;">No records found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Footer --}}
            <div style="margin-top: 20px; border-top: 2px solid #343a40; padding-top: 10px;">
                <div style="display: flex; justify-content: space-between;">
                    <div>
                        <strong>Total Records:</strong> {{ is_array($sales) ? count($sales) : 0 }}
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
@extends('layout.app', ['dept' => 'CRM'])

@section('page_title_link')
    {{ route('salesReturn') }}
@endsection

@section('page_titleH', 'Sales Return')
@section('page_title', 'Print')

@section('content')
    <div class="card">
        <div class="card-header py-1">
            <label class="card-title">Sales Return</label>
            @include('includes.print_btn')
        </div>
        <div class="card-body print">
            <div style="text-align: center; margin-bottom: 20px; border-bottom: 2px solid #343a40; padding-bottom: 10px;">
                <h3 style="margin: 0; font-weight: bold; letter-spacing: 1px">
                    {{ $compnm ?? 'PM-Industries' }}
                </h3>
                <h5 style="margin: 10px 0 0 0; text-transform: uppercase; letter-spacing: 2px; color: #343a40;">
                    Sales Return List
                </h5>
            </div>

            <table class="table table-bordered" width="100%" border="1"
                data-tableName="@php echo 'Sales-Return_'.date('dmHis'); @endphp" data-pageO="l"
                data-pdfmode="download" cellspacing="0" cellpadding="4">
                <thead>
                    <tr style="background-color: #343a40; color: #fff;">
                        <th style="width: 6%;  text-align: center;">Sl. No</th>
                        <th style="width: 16%; text-align: left;">SR No.</th>
                        <th style="width: 12%; text-align: center;">Date</th>
                        <th style="width: 20%; text-align: left;">Customer</th>
                        <th style="width: 14%; text-align: left;">Quot. No.</th>
                        <th style="width: 14%; text-align: right;">Basic Amount</th>
                        <th style="width: 18%; text-align: center;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($salesReturns as $i => $sr)
                        <tr style="{{ $i % 2 == 0 ? 'background-color: #f8f9fa' : 'background-color: #fff' }}">
                            <td style="text-align: center">{{ $i + 1 }}</td>
                            <td>{{ $sr['tranno'] ?? '' }}</td>
                            <td style="text-align: center">{{ $sr['trandt'] ?? '' }}</td>
                            <td>{{ $sr['customer_name'] ?? $sr['party_name'] ?? '' }}</td>
                            <td>{{ !empty($sr['qutintno']) && $sr['qutintno'] != 0 ? 'QTN-'.$sr['qutintno'] : '—' }}</td>
                            <td style="text-align: right">{{ number_format((float)($sr['basic'] ?? 0), 2) }}</td>
                            <td style="color: {{ ($sr['activeyn'] ?? 'N') === 'Y' ? 'green' : 'red' }}; text-align: center;">
                                {{ ($sr['activeyn'] ?? 'N') === 'Y' ? 'Active' : 'Inactive' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 20px;">No records found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div style="margin-top: 20px; border-top: 2px solid #343a40; padding-top: 10px;">
                <div style="display: flex; justify-content: space-between;">
                    <div>
                        <strong>Total Records:</strong> {{ is_array($salesReturns) ? count($salesReturns) : 0 }}
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
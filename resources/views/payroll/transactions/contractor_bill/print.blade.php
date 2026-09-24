@extends('layout.app', ['dept' => 'Payroll'])

@section('page_title_link')
    {{ route('payroll.contractorBill') }}
@endsection

@section('page_titleH', 'Contractor Bill')
@section('page_title', 'Print')

@section('content')
    <div class="card">
        <div class="card-header py-1">
            <label class="card-title">Contractor Bill</label>
            @include('includes.print_btn')
        </div>
        <div class="card-body print">
            {{-- company header --}}
            <div style="text-align: center; margin-bottom: 20px; border-bottom: 2px solid #343a40; padding-bottom: 10px;">
                <h3 style="margin: 0; font-weight: bold; letter-spacing: 1px">
                    {{ $compnm ?? 'PM-Industries' }}
                </h3>
                <h5 style="margin: 10px 0 0 0; text-transform: uppercase; letter-spacing: 2px; color: #343a40;">
                    Contractor Bill Register
                </h5>
            </div>
            {{-- company header end --}}

            <table class="table table-bordered" width="100%" border="1"
                data-tableName="@php echo 'Contractor-Bill_'.date('dmHis'); @endphp" data-pageO="l"
                data-pdfmode="download" cellspacing="0" cellpadding="4">
                <thead>
                    <tr style="background-color: #343a40; color: #fff;">
                        <th style="width: 5%; text-align: center;">Sl. No</th>
                        <th style="width: 12%; text-align: left;">Bill No.</th>
                        <th style="width: 10%; text-align: center;">Bill Date</th>
                        <th style="width: 18%; text-align: left;">Contractor</th>
                        <th style="width: 11%; text-align: right;">Gross Amt</th>
                        <th style="width: 11%; text-align: right;">Adv. Adj.</th>
                        <th style="width: 11%; text-align: right;">Net Amt</th>
                        <th style="width: 10%; text-align: center;">Approval</th>
                        <th style="width: 12%; text-align: left;">Approved By</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bills as $i => $bill)
                        <tr style="{{ $i % 2 == 0 ? 'background-color: #f8f9fa' : 'background-color: #fff' }}">
                            <td style="text-align: center">{{ $i + 1 }}</td>
                            <td>{{ $bill['bill_no'] ?? '' }}</td>
                            <td style="text-align: center">
                                {{ !empty($bill['bill_date']) ? date('d-m-Y', strtotime($bill['bill_date'])) : '' }}
                            </td>
                            <td>{{ $bill['contractor_name'] ?? '' }}</td>
                            <td style="text-align: right">{{ number_format($bill['gross_amount'] ?? 0, 2) }}</td>
                            <td style="text-align: right">{{ number_format($bill['advance_adjustment'] ?? 0, 2) }}</td>
                            <td style="text-align: right">{{ number_format($bill['net_amount'] ?? 0, 2) }}</td>
                            <td style="text-align: center;">
                                @php
                                    $appStatus = strtoupper($bill['approval_status'] ?? 'PENDING');
                                    $appColor = $appStatus === 'APPROVED' ? 'green' : ($appStatus === 'REJECTED' ? 'red' : 'orange');
                                @endphp
                                <span style="color: {{ $appColor }}; font-weight: bold;">
                                    {{ ucfirst(strtolower($appStatus)) }}
                                </span>
                            </td>
                            <td>{{ $bill['approved_by_name'] ?? '' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align: center; padding: 20px;">No records found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- footer --}}
            <div style="margin-top: 20px; border-top: 2px solid #343a40; padding-top: 10px;">
                <div style="display: flex; justify-content: space-between;">
                    <div>
                        <strong>Total Records:</strong> {{ is_array($bills) ? count($bills) : 0 }}
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
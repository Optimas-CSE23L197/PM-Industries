@extends('layout.app', ['dept' => 'CRM'])

@section('page_title_link')
    {{ route('quotationFollowup') }}
@endsection

@section('page_titleH', 'Quotation Followup')
@section('page_title', 'Print')

@section('content')
    <div class="card">
        <div class="card-header py-1">
            <label class="card-title">Quotation Followup</label>
            @include('includes.print_btn')
        </div>
        <div class="card-body print">
            {{-- Company Header --}}
            <div style="text-align: center; margin-bottom: 20px; border-bottom: 2px solid #343a40; padding-bottom: 10px;">
                <h3 style="margin: 0; font-weight: bold; letter-spacing: 1px">
                    {{ $compnm ?? 'PM-Industries' }}
                </h3>
                <h5 style="margin: 10px 0 0 0; text-transform: uppercase; letter-spacing: 2px; color: #343a40;">
                    Quotation Followup List
                </h5>
            </div>
            {{-- Company Header End --}}

            <table class="table table-bordered" width="100%" border="1"
                data-tableName="@php echo 'Quotation-Followup_'.date('dmHis'); @endphp" data-pageO="l"
                data-pdfmode="download" cellspacing="0" cellpadding="4">
                <thead>
                    <tr style="background-color: #343a40; color: #fff;">
                        <th style="width: 6%;  text-align: center;">Sl. No</th>
                        <th style="width: 12%; text-align: center;">Date</th>
                        <th style="width: 16%; text-align: left;">Quotation No.</th>
                        <th style="width: 20%; text-align: left;">Customer</th>
                        <th style="width: 10%; text-align: left;">Mode</th>
                        <th style="width: 12%; text-align: left;">Follow-up By</th>
                        <th style="width: 10%; text-align: center;">Status</th>
                        <th style="width: 14%; text-align: center;">Next Followup</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($followups as $i => $f)
                        <tr style="{{ $i % 2 == 0 ? 'background-color: #f8f9fa' : 'background-color: #fff' }}">
                            <td style="text-align: center">{{ $i + 1 }}</td>
                            <td style="text-align: center">{{ $f['followup_date'] ?? '' }}</td>
                            <td>{{ $f['quotation_no'] ?? '' }}</td>
                            <td>{{ $f['customer_name'] ?? '' }}</td>
                            <td>{{ $f['followup_mode'] ?? '' }}</td>
                            <td>{{ $f['user_name'] ?? $f['assigned_to_name'] ?? '' }}</td>
                            <td style="text-align: center">{{ $f['status'] ?? '' }}</td>
                            <td style="text-align: center">{{ $f['next_followup_date'] ?? '' }}</td>
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
                        <strong>Total Records:</strong> {{ is_array($followups) ? count($followups) : 0 }}
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
@extends('layout.app', ['dept' => 'CRM'])

@section('page_title_link')
    {{ route('priceList') }}
@endsection

@section('page_titleH', 'Price List')
@section('page_title', 'Print')

@section('content')
    <div class="card">
        <div class="card-header py-1">
            <label class="card-title">Price List</label>
            @include('includes.print_btn')
        </div>
        <div class="card-body print">
            {{-- company header --}}
            <div style="text-align: center; margin-bottom: 20px; border-bottom: 2px solid #343a40; padding-bottom: 10px;">
                <h3 style="margin: 0; font-weight: bold; letter-spacing: 1px">
                    {{ $compnm ?? 'PM-Industries' }}
                </h3>
                <h5 style="margin: 10px 0 0 0; text-transform: uppercase; letter-spacing: 2px; color: #343a40;">
                    Price List Master
                </h5>
            </div>
            {{-- company header end --}}

            @forelse($priceLists as $pl)
                {{-- Price List Header --}}
                <div style="background-color: #e9ecef; padding: 8px 12px; margin-top: 15px; border-left: 4px solid #343a40;">
                    <div style="display: flex; justify-content: space-between;">
                        <div>
                            <strong style="font-size: 14px;">{{ $pl['name'] ?? '' }}</strong>
                            <span style="margin-left: 15px; color: #666; font-size: 11px;">
                                ({{ $pl['valid_from'] ?? '' }} to {{ $pl['valid_to'] ?? '' }})
                            </span>
                        </div>
                        <div>
                            <span style="color: {{ ($pl['activeyn'] ?? 'N') === 'Y' ? 'green' : 'red' }}; font-weight: bold;">
                                {{ ($pl['activeyn'] ?? 'N') === 'Y' ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Details Table --}}
                <table class="table table-bordered" width="100%" border="1"
                    cellspacing="0" cellpadding="4" style="margin-top: 5px;">
                    <thead>
                        <tr style="background-color: #343a40; color: #fff;">
                            <th style="width: 10%; text-align: center;">Sl. No</th>
                            <th style="width: 60%; text-align: left;">Finished Item</th>
                            <th style="width: 15%; text-align: right;">Rate</th>
                            <th style="width: 15%; text-align: right;">Min Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pl['details'] as $i => $d)
                            <tr style="{{ $i % 2 == 0 ? 'background-color: #f8f9fa' : 'background-color: #fff' }}">
                                <td style="text-align: center">{{ $i + 1 }}</td>
                                <td>{{ $d['finisheditemnm'] ?? '' }}</td>
                                <td style="text-align: right">{{ number_format((float)($d['rate'] ?? 0), 2) }}</td>
                                <td style="text-align: right">{{ rtrim(rtrim(number_format((float)($d['min_qty'] ?? 0), 3, '.', ''), '0'), '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 15px;">No items in this price list</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @empty
                <div style="text-align: center; padding: 30px; color: #999;">
                    No Price Lists found
                </div>
            @endforelse

            {{-- footer --}}
            <div style="margin-top: 20px; border-top: 2px solid #343a40; padding-top: 10px;">
                <div style="display: flex; justify-content: space-between;">
                    <div>
                        <strong>Total Price Lists:</strong> {{ is_array($priceLists) ? count($priceLists) : 0 }}
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
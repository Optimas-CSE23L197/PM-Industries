@extends('layout.app', ['dept' => 'CRM'])
@section('page_title_link', route('quotationFollowup'))
@section('page_titleH', 'Quotation Followup')
@section('page_title', 'Details')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form id="quotationFollowupForm" method="post" data-no-global-submit="1">
                        @csrf
                        <input type="hidden" name="intno" value="{{ $followup['intno'] ?? 0 }}"/>

                        @if($vwedt == 4 && !empty($parentFollowup))
                            <input type="hidden" name="parent_followup_intno"
                                   value="{{ $parentFollowup['intno'] ?? '' }}"/>
                        @endif

                        <div class="form-group row">
                            <label for="followup_date" class="col-md-2 required">Date</label>
                            <div class="col-md-4">
                                <input type="date" name="followup_date" id="followup_date"
                                       class="form-control form-control-sm date_today" required autofocus
                                       value="{{ old('followup_date', isset($followup['followup_date']) && $followup['followup_date'] ? date('Y-m-d', strtotime($followup['followup_date'])) : date('Y-m-d')) }}"
                                       {{ $vwedt == 1 ? 'readonly' : '' }}/>
                            </div>

                            <label for="quotationintno" class="col-md-2 required">Quotation</label>
                            <div class="col-md-4">
                                <select name="quotationintno" id="quotationintno"
                                        class="form-control form-control-sm select2" required
                                        {{ ($vwedt == 1 || $vwedt == 3 || $vwedt == 4) ? 'disabled' : '' }}>
                                    <option value="" selected disabled>Select</option>
                                    @foreach($quotations as $q)
                                        <option value="{{ $q['intno'] }}"
                                            {{ ($followup['quotationintno'] ?? '') == $q['intno'] ? 'selected' : '' }}>
                                            {{ $q['quotation_no'] ?? '' }} - {{ $q['customer_name'] ?? '' }} - {{ $q['quotation_date'] ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @if($vwedt == 1 || $vwedt == 3 || $vwedt == 4)
                                    <input type="hidden" name="quotationintno" value="{{ $followup['quotationintno'] ?? '' }}">
                                @endif
                            </div>

                            <label for="followup_mode" class="col-md-2 required">Follow-up Mode</label>
                            <div class="col-md-4">
                                <select name="followup_mode" id="followup_mode"
                                        class="form-control form-control-sm select2" required
                                        {{ $vwedt == 1 ? 'disabled' : '' }}>
                                    <option value="" selected disabled>Select</option>
                                    @foreach(['CALL', 'EMAIL', 'VISIT', 'WHATSAPP', 'MEETING'] as $mode)
                                        <option value="{{ $mode }}"
                                            {{ ($followup['followup_mode'] ?? '') == $mode ? 'selected' : '' }}>
                                            {{ $mode }}
                                        </option>
                                    @endforeach
                                </select>
                                @if($vwedt == 1)
                                    <input type="hidden" name="followup_mode" value="{{ $followup['followup_mode'] ?? '' }}">
                                @endif
                            </div>

                            <label for="assigned_to" class="col-md-2 required">Follow-up By</label>
                            <div class="col-md-4">
                                <select name="assigned_to" id="assigned_to"
                                        class="form-control form-control-sm select2" required
                                        {{ $vwedt == 1 ? 'disabled' : '' }}>
                                    <option value="" selected disabled>Select</option>
                                    @foreach($users as $u)
                                        <option value="{{ $u['code'] }}"
                                            {{ ($followup['assigned_to'] ?? '') == $u['code'] ? 'selected' : '' }}>
                                            {{ $u['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @if($vwedt == 1)
                                    <input type="hidden" name="assigned_to" value="{{ $followup['assigned_to'] ?? '' }}">
                                @endif
                            </div>

                            <label for="talked_with" class="col-md-2 required">Talked With</label>
                            <div class="col-md-4">
                                <input type="text" name="talked_with" id="talked_with"
                                       class="form-control form-control-sm" required
                                       value="{{ old('talked_with', $followup['talked_with'] ?? '') }}"
                                       {{ $vwedt == 1 ? 'readonly' : '' }}/>
                            </div>

                            <label for="remarks" class="col-md-2 required">Follow-up Details</label>
                            <div class="col-md-4">
                                <textarea name="remarks" id="remarks" rows="3"
                                          class="form-control form-control-sm"
                                          {{ $vwedt == 1 ? 'readonly' : '' }}>{{ old('remarks', $followup['remarks'] ?? '') }}</textarea>
                            </div>

                            <hr class="col-12">

                            <label for="next_followup_date" class="col-md-2">Next Follow-up Date</label>
                            <div class="col-md-4">
                                <input type="date" name="next_followup_date" id="next_followup_date"
                                       class="form-control form-control-sm"
                                       value="{{ old('next_followup_date', $followup['next_followup_date'] ?? '') }}"
                                       {{ $vwedt == 1 ? 'readonly' : '' }}/>
                            </div>

                            <label for="status" class="col-md-2">Quotation Status</label>
                            <div class="col-md-4">
                                <select name="status" id="status"
                                        class="form-control form-control-sm"
                                        {{ $vwedt == 1 ? 'disabled' : '' }}>
                                    <option value="OPEN"     {{ ($followup['status'] ?? 'OPEN') == 'OPEN'     ? 'selected' : '' }}>OPEN</option>
                                    <option value="WON"      {{ ($followup['status'] ?? '') == 'WON'      ? 'selected' : '' }}>WON</option>
                                    <option value="LOST"     {{ ($followup['status'] ?? '') == 'LOST'     ? 'selected' : '' }}>LOST</option>
                                    <option value="CLOSED"   {{ ($followup['status'] ?? '') == 'CLOSED'   ? 'selected' : '' }}>CLOSED</option>
                                </select>
                                @if($vwedt == 1)
                                    <input type="hidden" name="status" value="{{ $followup['status'] ?? 'OPEN' }}">
                                @endif
                            </div>
                        </div>

                        <button type="submit" id="saveBtn" class="btn btn-sm btn-dark float-right"
                                {{ $vwedt == 1 ? 'hidden' : '' }}>
                            <i class="fas fa-save mr-1"></i>
                            {{ $vwedt == 2 ? 'Update' : 'Save' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('js')
<script>
    $(document).ready(function () {
        $('.select2').select2();

        $('#quotationFollowupForm').off('submit').on('submit', function (e) {
            e.preventDefault();
            e.stopPropagation();

            if ($('#saveBtn').prop('disabled')) return;
            $('#saveBtn').prop('disabled', true);

            var formData = new FormData(this);

            $.ajax({
                url : '/crm/save-quotation-followup',
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                beforeSend: function () { mtd.show_msg(3, '', 'Saving, Please Wait...', 4); },
                success: function (resp) {
                    Swal.close();
                    $('#saveBtn').prop('disabled', false);
                    var isError = !!resp.error;
                    var message = (resp.data && resp.data.message)
                                    ? resp.data.message
                                    : (resp.message || 'Saved successfully!');
                    if (!isError) {
                        let msg = message.split(/<br\s*\/?>/i)[0];
                        mtd.show_msgT(1, '/crm/quotation-followup', msg, 1);
                    } else {
                        mtd.show_msgT(0, '', message, 0);
                    }
                },
                error: function () {
                    Swal.close();
                    $('#saveBtn').prop('disabled', false);
                    mtd.show_msgT(0, '', 'Something went wrong!', 0);
                }
            });
        });
    });
</script>
@endpush
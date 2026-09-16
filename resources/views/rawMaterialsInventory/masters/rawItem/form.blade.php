@extends('layout.app', ['dept' => 'Raw Material Inventory'])

@section('page_title_link')
    {{ route('rawMaterialsInventory.rawItemList') }}
@endsection

@section('page_titleH', 'Raw Item')
@section('page_title', 'Details')

@section('content')

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form id="rawItemForm" method="post">
                        @csrf

                        <input type="hidden" name="code" value="{{ $rawItem['code'] ?? '' }}"/>
                        <input type="hidden" name="active_yn" value="{{ $rawItem['active_yn'] ?? 'Y' }}"/>

                        <div class="form-group row">
                            <label for="name" class="col-md-2 required">Name</label>
                            <div class="col-md-4">
                                <input type="text" name='name' id="name" class="form-control form-control-sm" autofocus required value="{{ old('name', $rawItem['name'] ?? '') }}"/>
                            </div>

                            <label for="typecd" class="col-md-2 required">Type</label>
                            <div class="col-md-4">
                                <select name="typecd" class="form-control form-control-sm select2" id="typecd" required>
                                    @if($mode === 'new')
                                        <option value="" selected disabled>Select</option>
                                    @endif
                                    @forelse($rmType as $r)
                                        <option value="{{ $r['code'] }}" {{ (($rawItem['typecd'] ?? '') === ($r['code'] ?? '')) ? 'selected' : '' }}>
                                            {{ $r['name'] }}
                                        </option>
                                    @empty
                                        <option selected disabled>No types available</option>
                                    @endforelse 
                                </select>
                            </div>

                            <label for="reorder_level" class="col-md-2">Reorder Level</label>
                            <div class="col-md-4">
                                <input type="text" name="reorder_level" id="reorder_level" value="{{ old('reorder_level', $rawItem['reorder_level'] ?? '') }}" class="form-control form-control-sm"/>
                            </div>

                            <label for="min_stock" class="col-md-2">Minimum Stock</label>
                            <div class="col-md-4">
                                <input type="text" name="min_stock" id="min_stock" value="{{ old('min_stock', $rawItem['min_stock'] ?? '') }}" class="form-control form-control-sm"/>
                            </div>

                            <label for="lastpurrate" class="col-md-2">Last Purchase Rate</label>
                            <div class="col-md-4">
                                <input type="text" name="lastpurrate" id="lastpurrate" value="{{ old('lastpurrate', $rawItem['lastpurrate'] ?? '') }}" class="form-control form-control-sm"/>
                            </div>
                        </div>

                        <button type="submit" id="saveBtn" class="btn btn-sm btn-dark float-right">
                            <i class="fas fa-save mr-1"></i>
                            Save
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    @push('js')
        <script>
            const mode = @json($mode);
            $(function(){
                if(mode === 'view'){
                    $('input, textarea, select').attr('disabled', true);
                    $('#saveBtn').hide();
                }
            });

            $('#rawItemForm').submit(function(e){
                e.preventDefault();
                var $saveBtn = $('#saveBtn');
                var originalBtnHtml = $saveBtn.html();
                $saveBtn.prop('disabled', true);
                $saveBtn.html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');

                var formData = $(this).serialize();

                $.ajax({
                    url : "{{ Route('rawMaterialsInventory.rawItemSave') }}",
                    type: 'post',
                    data: formData,
                    beforeSend:function(){
                        mtd.show_msg(3, '', 'Saving, Please Wait...',4);
                    },
                    success:function(resp){
                        Swal.close();
                        let message = resp.message.split(/<br\s*\/?>/i)[0];

                        if (!resp.error) {
                            mtd.show_msgT(1, "{{Route('rawMaterialsInventory.rawItemList')}}", message, 1);
                        } else {
                            mtd.show_msgT(0, '', message, 0);
                        }
                    },

                    error: function(xhr){
                        Swal.close();
                        mtd.show_msgT(0, '', 'Something went wrong. Please try again.', 0);
                    },
                    complete: function(){
                        $saveBtn.prop('disabled', false);
                        $saveBtn.html(originalBtnHtml);
                    }
                });
            });
        </script>
         
    @endpush

@endsection
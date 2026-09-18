<div class="modal fade" id="issueModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header py-2 bg-dark text-white">
                <h6 class="modal-title font-weight-bold">Item Details</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <label for="itemcd" class="col-md-2 required">Item</label>
                    <div class="col-md-4">
                        <select name="itemcd" class="form-control form-control-sm select2" id="itemcd" required>
                            <option value="" selected disabled>Select</option>
                            @forelse ( $items as $i )
                                <option value="{{ $i['code'] ?? '' }}">{{ $i['name'] ?? '' }}</option>
                            @empty
                                <option value="" selected disabled>No item found</option>
                            @endforelse
                        </select>
                    </div>
                    <label for="qty" class="col-md-2 required">Quantity</label>
                    <div class="col-md-4">
                        <input type="text" name="qty" id="qty" class="form-control form-control-sm text-right" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer py-1">
                <button type="button" class="btn btn-sm btn-dark" id="addBtn">
                    <i class="fas fa-save mr-1"></i> Add 
                </button>
            </div>
        </div>
    </div>
</div>
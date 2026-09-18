<div class="modal fade" id="adjModal" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <label for="raw_finished" class="col-md-2 required">Item Type</label>
                    <div class="col-md-4">
                        <select name="raw_finished" id="raw_finished" class="form-control form-control-sm select2" required>
                            <option value="R">Raw</option>
                            <option value="F">Finished</option>
                        </select>
                    </div>

                    <label for="itmItemcd" class="col-md-2 required">Item</label>
                    <div class="col-md-4">
                        <select name="itemcd" id="itmItemcd" class="form-control form-control-sm select2" required>
                            <option value="" selected disabled>Select</option>
                            @forelse ( $item as $i )
                                <option value="{{ $i['code'] ?? '' }}">{{ $i['name'] ?? '' }}</option>
                            @empty
                                <option value="" selected disabled>No item found</option>
                            @endforelse
                        </select>
                    </div>

                    <label for="itmRate" class="col-md-2 required">Rate</label>
                    <div class="col-md-4">
                        <input type="text" name="rate" id="itmRate" class="form-control form-control-sm text-right" required/>
                    </div>

                    <label for="itmQty" class="col-md-2 required">Quantity</label>
                    <div class="col-md-4">
                        <input type="text" name="qty" id="itmQty" class="form-control form-control-sm text-right" required/>
                    </div>

                    <label for="itmReason" class="col-md-2 required">Reason</label>
                    <div class="col-md-4">
                        <textarea name="reason" class="form-control form-control-sm" rows="3" id="itmReason"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer py-1">
                <button type="button" class="btn btn-sm btn-dark" id="addBtn">
                    <i class="fas fa-save mr-1"></i> Save
                </button>
            </div>
        </div>
    </div>
</div>
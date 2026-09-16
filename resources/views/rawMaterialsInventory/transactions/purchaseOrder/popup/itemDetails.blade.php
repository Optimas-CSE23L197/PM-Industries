<div class="modal fade" id="poModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header py-2 bg-dark text-white">
                <h6 class="modal-title font-weight-bold">Item Details</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="familyForm">
                    <div class="row">

                        <input type="hidden" name="activeyn" id="activeyn">
                        
                        <label for="rawitemcd" class="col-md-2 required">Item</label>
                        <div class="col-md-4">
                            <select name="rawitemcd" class="form-control form-control-sm select2" id="rawitemcd">
                                <option value="" selected disabled>Select</option>
                                @forelse ( $rawItems as $ri )
                                    <option value="{{ $ri['code'] ?? 0 }}">{{ $ri['name'] ?? '' }}</option>
                                @empty
                                    <option>No item found</option>
                                @endforelse
                            </select>
                        </div>

                        <label for="ordered_qty" class="col-md-2 required">Quantity</label>
                        <div class="col-md-4">
                            <input type="number" name="ordered_qty" id="ordered_qty"  class="form-control form-control-sm text-right" step="0.01" min="0"/>
                        </div>

                        <label for="rate" class="col-md-2 required">Rate</label>
                        <div class="col-md-4">
                            <input type="number" name="rate" id="rate" class="form-control form-control-sm text-right" step="0.001" min="0"/>
                        </div>

                        <label for="gst" class="col-md-2 required">GST</label>
                        <div class="col-md-4">
                            <input type="number" name="gst" id="gst" class="form-control form-control-sm text-right" step="0.01" min="0"/>
                        </div>

                        <label for="item_amount" class="col-md-2 required">Amount</label>
                        <div class="col-md-4">
                            <input type="text" name="item_amount" id="item_amount" class="form-control form-control-sm text-right" disabled/>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer py-1">
                <button type="button" class="btn btn-sm btn-dark" id="addBtn">
                    <i class="fas fa-save mr-1"></i>
                    Add
                </button>
            </div>
        </div>
    </div>
</div>

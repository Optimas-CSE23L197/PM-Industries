<div class="modal fade" id="purchaseModal" tabindex="-1" role="dialog" aria-hidden="true">
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
                            @forelse ( $item as $i )
                                <option value="{{ $i['code'] }}">{{ $i['name'] }}</option>
                            @empty
                                <option value="" selected disabled>No active items found</option>
                            @endforelse
                        </select>
                    </div>

                    <label for="serialno" class="col-md-2 required">Serial No.</label>
                    <div class="col-md-4">
                        <input type="text" id="serialno" name="serialno" class="form-control form-control-sm text-right" required/>
                    </div>

                    <label for="qty" class="col-md-2 required">Quantity</label>
                    <div class="col-md-4">
                        <input type="number" step="0.01" min="0" name="qty" id="qty" class="form-control form-control-sm text-right" required/>
                    </div>

                    <label for="rate" class="col-md-2 required">Rate</label>
                    <div class="col-md-4">
                        <input type="number" min="0" step="0.01" name="rate" id="rate" class="form-control form-control-sm text-right" required/>
                    </div>

                    <label for="discount" class="col-md-2">Discount</label>
                    <div class="col-md-4">
                        <div class="btn-group w-100">
                            <input type="number" min="0" step="0.01" name="discper" id="discper" class="form-control form-control-sm text-right" placeholder="%">
                            <input type="number" min="0" step="0.01" name="discamt" id="discamt" class="form-control form-control-sm text-right" placeholder="₹">
                        </div>
                    </div>
                    
                    <label for="sgst" class="col-md-2">SGST</label>
                    <div class="col-md-4">
                        <div class="btn-group w-100">
                            <input type="number" min="0" step="0.01" name="sgstper" id="sgstper" class="form-control form-control-sm text-right" placeholder="%">
                            <input type="number" min="0" step="0.01" name="sgstamt" id="sgstamt" class="form-control form-control-sm text-right" placeholder="₹">
                        </div>
                    </div>

                    <label for="cgst" class="col-md-2">CGST</label>
                    <div class="col-md-4">
                        <div class="btn-group w-100">
                            <input type="number" min="0" step="0.01" name="cgstper" id="cgstper" class="form-control form-control-sm text-right" placeholder="%"/>
                            <input type="number" min="0" step="0.01" name="cgstamt" id="cgstamt" class="form-control form-control-sm text-right" placeholder="₹"/>
                        </div>
                    </div>
                    <label for="" class="col-md-2">IGST</label>
                    <div class="col-md-4">
                        <div class="btn-group w-100">
                            <input type="number" min="0" step="0.01" name="igstper" id="igstper" class="form-control form-control-sm text-right" placeholder="%"/>
                            <input type="number" min="0" step="0.01" name="igstamt" id="igstamt" class="form-control form-control-sm text-right" placeholder="₹"/>
                        </div>
                    </div>
                    <label for="amount" class="col-md-2">Amount</label>
                    <div class="col-md-4">
                        <input type="number" min="0" step="0.01" name="amount" id="amount" class="form-control form-control-sm text-right" disabled/>
                    </div>

                    <label for="" class="col-md-2">Item Description</label>
                    <div class="col-md-4">
                        <textarea name="itemdescr" class="form-control form-control-sm" rows="3" id="itemdescr"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer py-1">
                <button type="button" class="btn btn-sm btn-dark" id="">
                    <i class="fas fa-save mr-1"></i>
                     Save
                </button>
            </div>
        </div>
    </div>
</div>
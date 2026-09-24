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
                    <label for="itmItemcd" class="col-md-2 required">Item</label>
                    <div class="col-md-4">
                        <select name="itemcd" class="form-control form-control-sm select2" id="itmItemcd" required>
                            <option value="" selected disabled>Select</option>
                            @forelse ( $item as $i )
                                <option value="{{ $i['code'] }}">{{ $i['name'] }}</option>
                            @empty
                                <option value="" selected disabled>No active items found</option>
                            @endforelse
                        </select>
                    </div>

                    <label for="itmSerialno" class="col-md-2 required">Serial No.</label>
                    <div class="col-md-4">
                        <input type="text" id="itmSerialno" name="serialno" class="form-control form-control-sm text-right" required/>
                    </div>

                    <label for="itmQty" class="col-md-2 required">Quantity</label>
                    <div class="col-md-4">
                        <input type="number" step="0.01" min="0" name="qty" id="itmQty" class="form-control form-control-sm text-right" required/>
                    </div>

                    <label for="itmRate" class="col-md-2 required">Rate</label>
                    <div class="col-md-4">
                        <input type="number" min="0" step="0.01" name="rate" id="itmRate" class="form-control form-control-sm text-right" required/>
                    </div>

                    <label for="itmDiscper" class="col-md-2">Discount</label>
                    <div class="col-md-4">
                        <div class="btn-group w-100">
                            <input type="number" min="0" step="0.01" name="discper" id="itmDiscper" class="form-control form-control-sm text-right" placeholder="%">
                            <input type="number" min="0" step="0.01" name="discamt" id="itmDiscamt" class="form-control form-control-sm text-right" placeholder="₹">
                        </div>
                    </div>

                    <label for="itmSgstper" class="col-md-2">SGST</label>
                    <div class="col-md-4">
                        <div class="btn-group w-100">
                            <input type="number" min="0" step="0.01" name="sgstper" id="itmSgstper" class="form-control form-control-sm text-right" placeholder="%">
                            <input type="number" min="0" step="0.01" name="sgstamt" id="itmSgstamt" class="form-control form-control-sm text-right" placeholder="₹">
                        </div>
                    </div>

                    <label for="itmCgstper" class="col-md-2">CGST</label>
                    <div class="col-md-4">
                        <div class="btn-group w-100">
                            <input type="number" min="0" step="0.01" name="cgstper" id="itmCgstper" class="form-control form-control-sm text-right" placeholder="%"/>
                            <input type="number" min="0" step="0.01" name="cgstamt" id="itmCgstamt" class="form-control form-control-sm text-right" placeholder="₹"/>
                        </div>
                    </div>
                    <label for="itmIgstper" class="col-md-2">IGST</label>
                    <div class="col-md-4">
                        <div class="btn-group w-100">
                            <input type="number" min="0" step="0.01" name="igstper" id="itmIgstper" class="form-control form-control-sm text-right" placeholder="%"/>
                            <input type="number" min="0" step="0.01" name="igstamt" id="itmIgstamt" class="form-control form-control-sm text-right" placeholder="₹"/>
                        </div>
                    </div>
                    <label for="itmAmount" class="col-md-2">Amount</label>
                    <div class="col-md-4">
                        <input type="number" min="0" step="0.01" name="amount" id="itmAmount" class="form-control form-control-sm text-right" disabled/>
                    </div>

                    <label for="itmItemdescr" class="col-md-2">Item Description</label>
                    <div class="col-md-4">
                        <textarea name="itemdescr" class="form-control form-control-sm" rows="3" id="itmItemdescr"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer py-1">
                <button type="button" class="btn btn-sm btn-dark" id="addBtn">
                    <i class="fas fa-save mr-1"></i>
                     Save
                </button>
            </div>
        </div>
    </div>
</div>
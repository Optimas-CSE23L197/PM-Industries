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
                        <label for="" class="col-md-2 required">Item</label>
                        <div class="col-md-4">
                            <select name="" class="form-control form-control-sm select2" id="">
                                <option value="" selected disabled>Select</option>
                                <option value="">Item 1</option>
                                <option value="">Item 2</option>
                                <option value="">Item 3</option>
                            </select>
                        </div>

                        <label for="" class="col-md-2 required">Quantity</label>
                        <div class="col-md-4">
                            <input type="number" class="form-control form-control-sm text-right" step="0.01" min="0"/>
                        </div>

                        <label for="" class="col-md-2 required">Rate</label>
                        <div class="col-md-4">
                            <input type="number" class="form-control form-control-sm text-right" step="0.001" min="0"/>
                        </div>

                        <label for="" class="col-md-2 required">GST</label>
                        <div class="col-md-4">
                            <input type="number" class="form-control form-control-sm text-right" step="0.01" min="0"/>
                        </div>

                        <label for="" class="col-md-2 required">Amount</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control form-control-sm text-right" disabled/>
                        </div>
                    </div>
                </form>
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

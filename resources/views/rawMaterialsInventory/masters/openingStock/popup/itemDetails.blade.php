<div class="modal fade" id="opstkModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header py-2 bg-dark text-white">
                <h6 class="modal-title font-weight-bold" id="opstkModalTitle">Item Details</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="opstkForm" method="POST">
                    @csrf

                    <input type="hidden" name="intno" id="intno"/>
                    <input type="hidden" name="activeyn" id="activeyn"/>

                    <div class="row">
                        <label class="col-md-2 required">Item Type</label>
                        <div class="col-md-4">
                            <select name="item_type" id="item_type" class="form-control form-control-sm">
                                <option value="raw">Raw Item</option>
                                <option value="finished">Finished Item</option>
                            </select>
                        </div>

                        <label class="col-md-2 required">Item</label>
                        <div class="col-md-4">
                            <select name="item_id" id="item_id" class="form-control form-control-sm select2">
                                <option value="" selected disabled>Select</option>
                                <option value="1">Item 1</option>
                                <option value="2">Item 2</option>
                                <option value="3">Item 3</option>
                            </select>
                        </div>

                        <label class="col-md-2 required">Quantity</label>
                        <div class="col-md-4">
                            <input type="text" name="qty" id="qty" class="form-control form-control-sm text-right">
                        </div>

                        <label class="col-md-2 required">Rate</label>
                        <div class="col-md-4">
                            <input type="text" name="rate" id="rate" class="form-control form-control-sm text-right">
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="modal-footer py-1">
                <button type="submit" class="btn btn-sm btn-dark" id="saveBtn">
                    <i class="fas fa-save mr-1"></i> Save
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">Create City</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="cityForm">
                    <input type="hidden" name="id" form="cityForm">
                    <div class="box-body">
                        @csrf
                        <div class="form-group">
                            <label for="Name" class="col-sm-3 control-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" autofocus form="cityForm" name="name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="delivery_charge" class="col-sm-3 control-label">Dilivery Charge</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" autofocus form="cityForm"
                                    name="delivery_charge" min="0">
                            </div>
                        </div>
                        <div>
                            <div class="row" id="cityFormErrors"> </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" form="noForm" class="btn btn-primary FormSubmit"
                    data-form="cityForm">Save</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

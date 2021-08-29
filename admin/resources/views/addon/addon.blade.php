<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">Create Add-on</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="addonForm">
                    <input type="hidden" name="id" form="addonForm">
                    <div class="box-body">
                        @csrf
                        <div class="form-group">
                            <label for="menu_name" class="col-sm-3 control-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" autofocus form="addonForm" name="name">
                            </div>
                        </div>
                        <div>
                        <div class="row" id="addonFormErrors"> </div>
                    </div> 
                    </div>                   
                    <!-- /.box-body -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" form="noForm" class="btn btn-primary FormSubmit"
                    data-form="addonForm">Save</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

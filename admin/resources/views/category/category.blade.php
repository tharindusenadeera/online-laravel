<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">Create category</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="categoryForm">
                    <input type="hidden" name="id" form="categoryForm">
                    <div class="box-body">
                        @csrf
                        <div class="form-group">
                            <label for="menu_name" class="col-sm-3 control-label">Category Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" autofocus form="categoryForm" name="name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="category_type" class="col-sm-3 control-label">Category Type</label>
                            <div class="col-sm-9">
                                <select name="category_type" id="" class="form-control" form="categoryForm">
                                    <option value="Food">Food Category</option>
                                    <option value="Beverage">Beverage Category</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <div class="row" id="categoryFormErrors"> </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" form="noForm" class="btn btn-primary FormSubmit"
                    data-form="categoryForm">Save</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

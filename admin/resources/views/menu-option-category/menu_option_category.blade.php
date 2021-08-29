<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">Create menu option category</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="menuOptionCategoryForm">
                    <input type="hidden" name="id" form="menuOptionCategoryForm">
                    <div class="box-body">
                        @csrf
                        <div class="form-group">
                            <label for="menu_name" class="col-sm-3 control-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" autofocus form="menuOptionCategoryForm" name="name">
                            </div>
                        </div>
                        <div>
                        <div class="form-group">
                            <label for="menu_name" class="col-sm-3 control-label">Options </label>
                            <div class="col-sm-9">
                                <select  class="select2" name="menu_options[]" multiple="multiple">
                                    @foreach ($menuoptions as $key => $menuoption)
                                    <option value="{{ $menuoption->id }}" > {{ $menuoption->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row" id="menuOptionCategoryFormErrors"> </div>
                    </div> 
                    </div>                   
                    <!-- /.box-body -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" form="noForm" class="btn btn-primary FormSubmit"
                    data-form="menuOptionCategoryForm">Save</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

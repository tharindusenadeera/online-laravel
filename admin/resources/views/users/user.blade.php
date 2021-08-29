<div class="modal fade" id="addModal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">User</h4>
              </div>
              <div class="modal-body">
                <form class="form-horizontal" id="userForm">
                  <input type="hidden" name="id" form="userForm">
              <div class="box-body">
                <div class="form-group">
                  <label for="name" class="col-sm-3 control-label">Name</label>

                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="name" autofocus form="userForm" placeholder="User Name">
                  </div>
                </div>
                <div class="form-group">
                  <label for="location" class="col-sm-3 control-label">Email</label>

                  <div class="col-sm-9">
                  <input type="email" class="form-control" name="email" autofocus form="userForm"  placeholder="User Email">
                  </div>
                </div>
                <div class="form-group">
                  <label for="location" class="col-sm-3 control-label">Username</label>

                  <div class="col-sm-9">
                  <input type="text" class="form-control" name="username" autofocus form="userForm"  placeholder="Username">
                  </div>
                </div>
                <div class="form-group">
                  <label for="location" class="col-sm-3 control-label">User Level</label>

                  <div class="col-sm-9">
                  <select name="user_level" class="form-control" autofocus form="userForm">
                      <option value="manager">Manager</option>
                      <option value="pos-user">POS User</option>
                      <option value="waiter">Waiter</option>
                  </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="location" class="col-sm-3 control-label">Password</label>

                  <div class="col-sm-9">
                  <input type="password" class="form-control" name="password" autofocus form="userForm"  placeholder="User Password">
                  </div>
                </div>
                <div class="form-group">
                  <label for="location" class="col-sm-3 control-label">Confirm Password</label>

                  <div class="col-sm-9">
                  <input type="password" class="form-control" name="password_confirmation" autofocus form="userForm"  placeholder="User Confirm Password">
                  </div>
                </div>


              </div>
              <div class="row" id="userFormErrors">

          </div>
            </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" form="noForm" class="btn btn-primary FormSubmit" data-form="userForm">Save</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

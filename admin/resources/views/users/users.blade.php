@extends('includes.app')
@section('title', 'Users')
@section('content')
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Users
        <small>All the Users</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Users</li>
      </ol>
    </section>
    <div class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <div class="box-tools pull-right" style="position: inherit;">
                <button type="button" onclick="showForm()" class="btn bg-navy ">Add New</button>
          </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>User Level</th>
              <th class="text-center">Status</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($users as $user)
              <tr>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->user_level}}</td>
                <td class="text-center">
                @if ($user->status == 1)
                    <small class="label  bg-green">Active</small>
                  @elseif ($user->status ==  0)
                    <small class="label  bg-yellow">Inactive</small>
                  @endif
                </td>
                <td class="text-center">
                @if (auth()->user()->user_level == 'admin')
                  <button type="button"  onclick="getData({{$user->id}})"  class="btn  btn-info btn-xs ">Edit/ View</button>
                  @endif

                  @if ($user->status == 1)
                    <button type="button" onclick="toggleStatus(this)" data-status="0"  data-id="{{$user->id}}"  class="btn  btn-warning btn-xs ">Inactivate</button>
                  @elseif ($user->status ==  0)
                    <button type="button"  onclick="toggleStatus(this)" data-status="1"  data-id="{{$user->id}}"  class="btn  btn-success btn-xs ">Activate</button>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
</div>
</div>
      </div>
    </div>
    </div>
    @include('users.user')
@endsection

@section('aditionalJs')
  <script type="text/javascript">
  // start use for request js
    baseUrl =  "{{url("users")}}";
      url =  baseUrl;
      primaryKey = "id"; // use to set update url
      reloadAfterSubmit = true;
      formId = "userForm";
      useSwal = true


 $('.table').DataTable({
   'paging'      : true,
   'lengthChange': false,
   'searching'   : false,
   'ordering'    : true,
   'info'        : true,
   'autoWidth'   : false
 });


function toggleStatus(ele) {
  if(confirm("Are you sure ?")){
    var id = $(ele).data("id");
    var status = $(ele).data("status");
    var xhttp;
    if (window.XMLHttpRequest) {
      xhttp = new XMLHttpRequest();
    } else {
      // code for IE6, IE5
      xhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xhttp.addEventListener("load", function() {
      data = JSON.parse(this.responseText);
      if (data.hasOwnProperty('errors')) {
        oops();
      } else if (data.hasOwnProperty('success') && data.success == "19199212") {
        window.location.reload();
   }

    });
    xhttp.addEventListener("error", function() {
      oops();
    });

      xhttp.open("POST", baseUrl +"/"+id+"/status/"+status, false);
  xhttp.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
    xhttp.send();
  }
}
  </script>
@endsection

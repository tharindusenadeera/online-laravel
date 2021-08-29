@extends('includes.app')
@section('title', 'Kitchen')
@section('content')
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Kitchen
        <small>All Kitchen Orders</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Kitchen</li>
      </ol>
    </section>
    <div class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <div class="box-tools pull-right" style="position: inherit;">
               Last Refreshed @ <label style="font-size: 18px;"  id="last-refreshed"></label>
          </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>Order ID</th>
              <th>Table NO</th>
              <th>Items Summary</th>
              <th>Order Type</th>
              <th>Placed By</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
</div>
</div>
      </div>
    </div>
    </div>
    @include('order.order-summary')
@endsection

@section('aditionalJs')
  <script type="text/javascript">
  // start use for request js
    baseUrl =  "{{url("kitchen")}}";
      url =  baseUrl;
      primaryKey = "id"; // use to set update url
      reloadAfterSubmit = true;
      formId = "userForm";


 var orderTable = $('.table').DataTable({
   'paging'      : true,
   'lengthChange': false,
   'searching'   : false,
   'ordering'    : true,
   'info'        : true,
   'autoWidth'   : false,
   ajax: baseUrl + "/orders",
   "drawCallback": function(settings) {
    setRefreshedTime();
    }
 });


 window.setInterval(function(){
  orderTable.ajax.reload();
}, 30000);


function setRefreshedTime() {
    let d = new Date();
  $("#last-refreshed").html(d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds());
}
  </script>
@endsection

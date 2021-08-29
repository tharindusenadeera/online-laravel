@extends('includes.app')
@section('title', 'Dashboard | Category')
@section('aditionalCss')
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Menu
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <div class="box-tools pull-right" style="position: inherit;">
                            <a  href="{{route('menu-item.create')}}" class="btn bg-navy ">Add New</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Menu Name</th>
                                    <th>Image</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($menuitems as $key=> $menuitem)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $menuitem->name }}</td>
                                    <td><img style="max-width:100px;"  src="{{ URL::to('/') }}/assets/uploads/images/{{ $menuitem->main_image }}" ></td>
                                    <td>{{ $menuitem->price }}</td>
                                    <td>{{ $menuitem->qty }}</td>
                                    <td class="text-center">
                                        @if ($menuitem->status == 1)
                                        <small class="label  bg-green">Active</small>
                                        @elseif ($menuitem->status == 0)
                                        <small class="label  bg-yellow">Inactive</small>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button type="button" onclick="window.location='{{route('menu-item.edit', ['menu_item' => $menuitem->id])}}';" class="btn  btn-info btn-xs ">Edit/ View</button>

                                            @if ($menuitem->status == 1)
                                                <button type="button" onclick="toggleStatus(this)" data-status="0"  data-id="{{$menuitem->id}}"  class="btn  btn-warning btn-xs ">Inactivate</button>
                                            @elseif ($menuitem->status ==  0)
                                                <button type="button"  onclick="toggleStatus(this)" data-status="1"  data-id="{{$menuitem->id}}"  class="btn  btn-success btn-xs ">Activate</button>
                                            @endif
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">


                        </div>

                </div>
            </div>
        </div>

    </section>
@endsection

@section('aditionalJs')
  <script type="text/javascript">

    baseUrl           = "{{url("menu-item")}}";

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
            var id     = $(ele).data("id");
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

            xhttp.open("POST", baseUrl +"/"+id+"/"+status, false);
            xhttp.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
            xhttp.send();
        }
    }

  </script>
@endsection

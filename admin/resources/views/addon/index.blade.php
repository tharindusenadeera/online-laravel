@extends('includes.app')
@section('title', 'Dashboard | Category')
@section('aditionalCss')
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Add-on
            <small>All the Add-on</small>
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
                            <button type="button" onclick="showForm()" class="btn bg-navy ">Add New</button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($addons as $key=> $addon)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $addon->name }}</td>
                                    <td class="text-center">
                                        @if ($addon->status == 1)
                                        <small class="label  bg-green">Active</small>
                                        @elseif ($addon->status == 0)
                                        <small class="label  bg-yellow">Inactive</small>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button type="button" onclick="getData({{$addon->id}})"
                                            class="btn  btn-info btn-xs ">Edit/ View</button>

                                            @if ($addon->status == 1)
                                                <button type="button" onclick="toggleStatus(this)" data-status="0"  data-id="{{$addon->id}}"  class="btn  btn-warning btn-xs ">Inactivate</button>
                                            @elseif ($addon->status ==  0)
                                                <button type="button"  onclick="toggleStatus(this)" data-status="1"  data-id="{{$addon->id}}"  class="btn  btn-success btn-xs ">Activate</button>
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
        <div class="modal imagecrop fade bd-example-modal-lg" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 class="modal-title">Image cropper</h5>
                    </div>
                    <div class="modal-body">
                        <div class="img-cotainer">
                            <div class="row">
                                <div class="col-md-11">
                                    <img src="" class='getimg' id='image'>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="crop">Crop</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@include('addon.addon')
@section('aditionalJs')
  <script type="text/javascript">
    // start use for request js
    baseUrl           = "{{url("addon")}}";
    url               = baseUrl;
    primaryKey        = "id"; // use to set update url
    reloadAfterSubmit = true;
    formId = "addonForm";
    useSwal = 1;
    // end use for request js
    function showForm() {
        resetForm("addonForm");

        $('#addModal').modal('show')

    }

    $('.table').DataTable({
        'paging'      : true,
        'lengthChange': false,
        'searching'   : false,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false
    });

    function GetResultHandler(data) { // overiding ajax request js function
        if (data.hasOwnProperty('errors')) {
            oops();
        } else if (data.hasOwnProperty('success') && data.success == "19199212") {
            resetForm("addonForm");
            Object.keys(data.data).forEach(function(key) {
            $('input[name="name"]').val(data.data["name"]);
            $('input[name="id"]').val(data.data["id"]);
            });

            $('#addModal').modal('show');
        }
    }

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

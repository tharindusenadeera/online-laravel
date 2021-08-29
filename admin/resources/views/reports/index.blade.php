@extends('includes.app')
@section('title', 'Dashboard | Daily Order Summary')
@section('aditionalCss')
<link rel="stylesheet" href="{{ url('assets/bootstrap-daterangepicker/daterangepicker.css') }}">

<style>
    .box-too {
        padding:0px;
    }
    .badge{
        padding:10px 10px;
        font-size: 15px;
    }
</style>

@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Reports
        <small>Daily Summary Report</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Reports</a></li>
        <li class="active">Daily Summary Report</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            

            <div class="box box-primary">
                <div class="box-header">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="box-tools" style="position: inherit;">
                                <button type="button" class="btn btn-primary">
                                    EOD Total Sales : <span class="badge badge-light"> ${{ $total }}</span>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{-- <label>Date and time range:</label> --}}
                
                                {{-- <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="reservationtime">
                                </div> --}}
                                <!-- /.input group -->
                            </div>
                        </div>
                        
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Order ID</th>
                                <th>Customer Name</th>
                                <th>Order Type</th>
                                <th>Order Status</th>
                                <th>Amount</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $key => $order)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->customer->first_name }}</td>
                                    <td>{{strtoupper(str_replace('_', ' ', $order->order_type))  }}</td>
                                    <td>{{strtoupper(str_replace('_', ' ', $order->status))  }}</td>
                                    <td>{{ $order->total }}</td>
                                    <td>{{ $order->created_at }}</td>

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
<script src="{{ url('/assets/moment/min/moment.min.js') }}"></script>
<script src="{{ url('/assets/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        changeOption(0);
    });

    var array = [];
    // start use for request js
    baseUrl = "{{ url('menu-item') }}";
    url = baseUrl;
    primaryKey = "id"; // use to set update url
    reloadAfterSubmit = true;
    formId = "menuItemForm";
    useSwal = 1;
    // end use for request js
    function showForm() {
        resetForm("menuItemForm");
        $("#item-table").html('');
        $('#addModal').modal('show')

    }

    $('.table').DataTable({
        'paging': true,
        'lengthChange': false,
        'searching': false,
        'ordering': true,
        'info': true,
        'autoWidth': false
    });

    function GetResultHandler(data) { // overiding ajax request js function
        if (data.hasOwnProperty('errors')) {
            oops();
        } else if (data.hasOwnProperty('success') && data.success == "19199212") {
            resetForm("menuItemForm");
            Object.keys(data.data).forEach(function(key) {
                $('input[name="name"]').val(data.data["name"]);
                $('input[name="price"]').val(data.data["price"]);
                $('input[name="qty"]').val(data.data["qty"]);
                $('input[name="id"]').val(data.data["id"]);

                $('#menu_category').val(data.data["menu_category"]);
                $('#menu_category').trigger('change');

            });
            $("#item-table").html('');
            $.each(data.data["menu_iitem_menu_option_category_menu_option"], function(key, value) {
                if (value.menu_option_category_menu_option) {
                    array.push(value.menu_option_category_menu_option.id);
                    $("#item-table").append($(
                        '<tr><td><input type="hidden" class="hidden"  name="options[]" value=' + value
                        .menu_option_category_menu_option.id + '>' + value
                        .menu_option_category_menu_option.menu_option_category.name + '</td><td>' +
                        value.menu_option_category_menu_option.menu_option.name +
                        '</td><td><button type="button" onclick="removeOption(this)" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></td></tr>'
                    ));
                }
            });
            $('#addModal').modal('show');
        }
    }


    $('#menu_categories').change(function() {
        var index = $(this).children('option:selected').data('index');
        changeOption(index);
    });
    /*
    |--------------------------------------------------------------------------
    |Change Options
    |--------------------------------------------------------------------------
    */

    function changeOption(index) {

        var item = menuoption[index].category_menuoption;

        var childCategoriesDdl = $('#menu_options');
        childCategoriesDdl.empty();

        $.each(item, function(index, childCategory) {

            childCategoriesDdl.append(

                $('<option/>', {
                    value: childCategory.menu_option.id,
                    text: childCategory.menu_option.name
                })
            );
        });

    }

    /*
    |--------------------------------------------------------------------------
    |Add options
    |--------------------------------------------------------------------------
    */
    function addOption() {
        var index = $('#menu_categories').children('option:selected').data('index');
        var data = menuoption[index].category_menuoption;

        var val1 = $('#menu_categories').val();
        var val2 = $('#menu_options').val();
        var text1 = $("#menu_categories option:selected").text();
        var text2 = $("#menu_options option:selected").text()

        function findIndexInData(data, property, value, property2, value2) {
            var result = -1;
            data.some(function(item, i) {
                if (item[property] == value && item[property2] == value2) {
                    result = i;
                    return true;
                }
            });
            return result;
        }

        var index = findIndexInData(data, 'menu_option_category_id', val1, 'menu_option_id', val2); // shows index of

        if ($.inArray(data[index].id, array) != -1) {
            return;
        }

        array.push(data[index].id);

        $("#item-table").append($('<tr><td><input type="hidden" class="hidden"  name="options[]" value=' + data[index]
            .id + '>' + text1 + '</td><td>' + text2 +
            '</td><td><button type="button" onclick="removeOption(this)" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></td></tr>'
        ));

    };

    /*
    |--------------------------------------------------------------------------
    |Remove Options
    |--------------------------------------------------------------------------
    */
    function removeOption(ele) {
        var element = $(ele).closest('tr');
        let remove_value = parseInt(element.find('.hidden').val());
        var index = array.indexOf(remove_value);

        if (index !== -1) {
            array.splice(index, 1);
        }

        $(element).remove();

    }

    function toggleStatus(ele) {
        if (confirm("Are you sure ?")) {
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

            xhttp.open("POST", baseUrl + "/" + id + "/" + status, false);
            xhttp.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
            xhttp.send();
        }
    }
</script>
<script>
    $(function() {
        
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            locale: {
                format: 'MM/DD/YYYY hh:mm A'
            }
        })
        

       
    })
</script>
@endsection

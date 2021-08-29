@extends('includes.app')
@section('title', 'Kitchen')
@section('aditionalCss')
<style>
    .widget-user-2 .widget-user-username,
    .widget-user-2 .widget-user-desc {
        margin-left: 0px;
    }

    .badge {
        padding: 10px;
    }

</style>
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Kitchen
        <small>All Kitchen Prepared Orders</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"><i class="fa fa-cutlery"></i> Kitchen</a></li>
        <li class="active">

            @if ($status == 'prepared')
            <i class="fa fa-check-square-o"></i> Prepared Orders
            @elseif($status=="placed")
            <i class="fa fa-list-alt"></i> Placed Orders
            @elseif($status=="draft")
            <i class="fa fa-pencil-square-o"></i> Draft Orders
             @endif</li>
    </ol>
</section>
<div class="content">

    <div class="row">
        <div class="col-md-12">
            <div class="box-tools pull-right" style="position: inherit;">
                Last Refreshed @ <label style="font-size: 18px;" id="last-refreshed"></label>
            </div>
        </div>
    </div>

    @foreach ($orders->chunk(3) as $chunk)
        <div class="row">

            @foreach ($chunk as $order)

                <div class="col-md-4">
                    <div class="box box-widget widget-user-2">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header
                        @if ($order->status == 'prepared') bg-green
                        @elseif($order->status=="placed")
                            bg-yellow
                        @elseif($order->status=="draft")
                            bg-red @endif
                            ">

                            <h3 class="widget-user-username">Order No: {{ $order->id }} <span
                                    class="pull-right badge bg-blue">{{ strtoupper(str_replace('_', ' ', $order->order_type)) }}</span>
                            </h3>
                            {{-- {{ ($order->customer->first_name  != null) ? '<h5 class="widget-user-desc">Customer Name:'.$order->customer->first_namw.'</h5>' : ''}} --}}
                            @if ($order->customer != null)
                                <h5 class="widget-user-desc">Customer Name: {{ $order->customer->first_name }} {{ $order->customer->last_name }} </h5>
                            @endif
                            <h5 class="widget-user-desc">Order Status: {{ $order->status }}</h5>
                            <h5 class="widget-user-desc">Order Placed Time:
                                {{ Carbon\Carbon::parse($order->created_at)->format('H:i:s A') }}</h5>
                            @if ($order->table_id != null)
                                <h5 class="widget-user-desc">Table No: {{ $order->table_id }}</h5>
                            @endif
                        </div>
                        <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                                @foreach ($order->order_menu_items_full as $menu_item)
                                    <li>
                                        <a href="#">
                                            <span class="badge
                                            @if ($order->status == 'prepared') bg-green
                                            @elseif($order->status=="placed")
                                                bg-yellow
                                            @elseif($order->status=="draft")
                                                bg-red @endif
                                                ">
                                                {{ $menu_item->order_menu_item_qty }}
                                            </span> X {{ strtoupper($menu_item->name) }}

                                        </a>
                                    </li>
                                    @foreach ($menu_item->order_menu_item_option_categories as $menu_item_option_category)
                                        <ul>
                                            <li class="card-text">
                                                {{-- <span> --}}
                                                {{-- <a href="#"> --}}
                                                {{ $menu_item_option_category->name }} |
                                                @foreach ($menu_item_option_category->order_menu_item_options as $menu_item_option)
                                                    {{ $menu_item_option->name }}
                                                    {{-- </a> --}}
                                                    {{-- </span> --}}
                                            </li>
                                    @endforeach
                            </ul>
            @endforeach
    @endforeach

    {{-- <li><a href="#">Followers <span class="pull-right badge bg-red">842</span></a></li> --}}
    <li>
        <a href="#" class="card-text">
            {{-- <span class="pull-right badge bg-red"> --}}
            @if ($order->status == 'placed')
                <button type="button" onclick="toggleStatus(this)" data-status="prepared" data-id="{{ $order->id }}"
                    class="btn  btn-warning btn-xs ">Prepared</button>
            @elseif ($order->status == 'prepared')
                <small class="text-muted"> Order prepared {{ $order->updated_at->diffForHumans() }}</small>
            @endif
            {{-- </span> --}}
        </a>
    </li>



    </ul>

</div>
</div>
</div>

@endforeach
</div>

@endforeach
</div>

</div>
</div>
@include('order.order-summary')
@endsection

@section('aditionalJs')
<script type="text/javascript">
    // start use for request js
    baseUrl = "{{ url('kitchen') }}";
    // baseUrl = "{{ url('order') }}";
    url = baseUrl;
    primaryKey = "id"; // use to set update url
    reloadAfterSubmit = true;
    formId = "userForm";


    var orderTable = $('.table').DataTable({
        'paging': true,
        'lengthChange': false,
        'searching': false,
        'ordering': true,
        'info': true,
        'autoWidth': false,
        ajax: baseUrl + "/orders",
        "drawCallback": function(settings) {
            setRefreshedTime();
        }
    });


    window.setInterval(function() {
        orderTable.ajax.reload();
    }, 10000);


    function setRefreshedTime() {
        let d = new Date();
        $("#last-refreshed").html(d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds());
    }


    function toggleStatus(ele) {
        console.log($(ele).data("id"));
        console.log($(ele).data("status"));
        console.log(setRefreshedTime());
        setRefreshedTime();
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
@endsection

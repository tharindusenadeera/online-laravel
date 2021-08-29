<html>
    <head>
      <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>

 @include('includes.basicCss')

 <style>
     body{
         font-size: 13px;
     }
     #bill-layout{
         box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
  padding:1mm;
  padding-top: 0;
  margin: 0 auto;
  background: #FFF;
     }
     @media print {
    @page {
      width: 99%;
    height: 99%;
    }
}

.items-table tbody th, .items-table tbody td{
    font-size: 12px;
    width: 75%;
}
.item-price {
    padding-right: 4px;
    padding-left: 4px;
    width: 25%;
    text-align: right;
}

.sub-total {
    padding-right: 5px;
    width: 75%;
    font-size: 12px;
    text-align: right;
}
.sub-total-value {
    font-size: 12px;
    text-align: right;
}
.total-table{
    width: 100%;
}
.total {
    padding-right: 5px;
    width: 75%;
    font-size: 13px;
    text-align: right;
}
.total-value {
    font-size: 13px;
    text-align: right;
}
hr{
    border-top: 1px solid #000;
}
@media print {
    .pagebreak {
        clear: both;
        page-break-after: always;
    }
}
 </style>
</head>
<body class="" onload="window.print()">
<div id="bill-layout">
<h4 class="text-center" style="margin-top: 0">Spice Garden</h4>
<h5 class="text-center"> No :2, Pavonia Place,<br>Nightcliff 0810<br>
(08) 8900 8068<br>
book@spicegarden.com.au
</h5>
<div class="col-xs-12">
    <table style="width: 100%;">
        <tr>
            <td style="width: 70%"><strong>Oder No : </strong>{{$order->id}}</td>
            <td><strong>Type : </strong>{{\Str::of($order->order_type)->snake()->replace('_', ' ')->title()}} {{ $order->table_id != "" ? "(".$order->table_id.")" : "" }}</td>
        </tr>
        <tr>

            @if (isset($order->customer))
            <td><strong>Customer : </strong> {{$order->customer->first_name}}</td>
        @endif
            @if (isset($order->user))
            <td><strong>Cashier : </strong> {{$order->user->name}}</td>
            @endif
        </tr>

    </table>
</div>
<strong>Order Time : </strong>{{$order->created_at}}
<hr style="margin-bottom: 3px; margin-top:3px;">
<table class="items-table">
    <tbody>
        @foreach ($order->order_menu_items_full as $key => $order_menu_item)
        <tr @if ($key > 0) style="border-top: 1px dashed; margin-top:3px; margin-bottom:3px;"  @endif>
             <th>{{$order_menu_item->name}}</th>
             <td>{{$order_menu_item->order_menu_item_qty}} X </td>
             <td class="item-price">{{number_format($order_menu_item->order_menu_item_price, 2)}}</td>
        </tr>
        @if (isset($order_menu_item->comment))
            <tr>
                <td>{{$order_menu_item->comment}}</td>
                <td></td>
            <td></td>
            </tr>
        @endif

        @foreach ($order_menu_item->order_menu_item_addons as $order_menu_item_addon)

            <tr>
                <th>{{$order_menu_item_addon->name}}</th>
                <td>{{$order_menu_item->order_menu_item_qty}} X </td>
                <td class="item-price">{{number_format($order_menu_item_addon->order_menu_item_addon_price, 2)}}</td>
            </tr>

        @endforeach

        @php
            $orderOptions = "";
        @endphp
        @foreach ($order_menu_item->order_menu_item_option_categories as $order_menu_item_option_category)

            @foreach ($order_menu_item_option_category->order_menu_item_options as $order_menu_item_option)
                @php
                    $orderOptions = $orderOptions." | ".$order_menu_item_option_category->name." : ".$order_menu_item_option->name;
                @endphp
            @endforeach

        @endforeach
         <tr>
            <td>{{\Str::replaceFirst(" | ", "", $orderOptions)}}</td>
            <td></td>
            <td></td>
        </tr>

        <tr class="  text-right">
            <td></td>
            <td></td>
            <td class="text-right"><strong>{{number_format(($order_menu_item->order_menu_item_total), 2)}}</strong></td>
        </tr>
        @endforeach


    </tbody>
</table>
<hr style="margin-bottom: 3px; margin-top:3px;">
<table class="total-table">
    <tbody >
        <tr class="">
            <th class="sub-total">Sub Total</th>
            <td class="sub-total-value">{{number_format($order->order_menu_items_total, 2)}}</td>
        </tr>
        <tr class="">
            <th class="sub-total">Tax (0%)</th>
            <td class="sub-total-value">{{number_format($order->order_tax_amount, 2)}}</td>
        </tr>
        <tr class="">
            <th class="sub-total">Delivery</th>
            <td class="sub-total-value">{{number_format($order->delivery_charge, 2)}}</td>
        </tr>
    </tbody>
</table>
<hr style="margin-bottom: 3px; margin-top:3px;">
<table class="total-table">
    <tbody >
        <tr class="">
            <th class="total">TOTAL</th>
            <th class="total-value">{{number_format($order->order_total, 2)}}</th>
        </tr>
    </tbody>
</table>

<hr style="margin-bottom: 3px; margin-top:3px;">
<div class="row text-center">
    !! Thank You, Order Again !!
</div>
</div>
<div class="pagebreak"> </div>

    </body>
</html>

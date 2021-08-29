<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Order;
use Illuminate\Http\Request;

class KitchenController extends Controller
{
  public function index()
  {

    $orders = $this->getOrdersByStatus(["placed"], "desc", "created_at");
    return view("kitchen.kitchen_display",['status' => 'placed'], compact("orders"));
  }

  /*
    |--------------------------------------------------------------------------
    |Public function / get all placed orders
    |@function getOrdersByStatus($status, $orderBy, $time)
    |--------------------------------------------------------------------------
    */
  public function getPlacedOrders()
  {

    $orders = $this->getOrdersByStatus(["placed"], "desc", "created_at");
    return view("kitchen.kitchen_display", ['status' => 'placed'],compact("orders"));
  }

  /*
    |--------------------------------------------------------------------------
    |Public function / get all prepared orders
    |@function getOrdersByStatus($status, $orderBy, $time)
    |--------------------------------------------------------------------------
    */
  public function getPreaparedOrders()
  {
    $orders = $this->getOrdersByStatus(["prepared"], "asc", "updated_at");

    return view("kitchen.kitchen_display", ['status' => 'prepared'],compact("orders"));
  }

  /*
    |--------------------------------------------------------------------------
    |Public function / get all draft orders
    |@function getOrdersByStatus($status, $orderBy, $time)
    |--------------------------------------------------------------------------
    */
    public function getDraftOrders()
    {
      $orders = $this->getOrdersByStatus(["draft"], "asc", "updated_at");


      
      return view("kitchen.kitchen_display",['status' => 'draft'], compact("orders"));
    }

  /*
    |--------------------------------------------------------------------------
    |Public function / get orders by status
    |@param array $status (placed|prepared|settled|draft)
    |@param string $orderBy (asc|desc)
    |@param string $time (created_at|updated_at)
    |--------------------------------------------------------------------------
    */
  public function getOrdersByStatus($status, $orderBy, $time)
  {
    $orders = Order::whereIn('status', $status)->with('customer', 'ordermenuitems')->orderBy($time, $orderBy)->get();
    $orders->makeHidden('ordermenuitems');

    return $orders;
  }

  /*
    |--------------------------------------------------------------------------
    |Public function / toggle status
    |--------------------------------------------------------------------------
    */
  public function toggleStatus($id, $status, Request $request)
  {
    if ($status == 'prepared') {

      $order = Order::find($id);
      if ($order) {
        $order->status = $status;
      }
      if ($order->save()) {
        return response()->json(['success' => "19199212", "message" => "Order status updated successfully"], 200);
      }
    }
  }
}

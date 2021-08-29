<?php

namespace App\Http\Controllers\v1;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customers;
use App\Models\Order;
use App\Models\OrderMenuItem;
use App\Models\MenuItem;
use App\Models\City;
use App\Models\MenuItemAddon;
use App\Models\OrderMenuItemAddon;
use App\Models\OrderMenuOptionCategoryMenuOption;
use Validator;
use Log;
use Throwable;

class OrderController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    |Public function / Create Order
    |--------------------------------------------------------------------------
    */
    public function createOrder(Request $request){


        $validator = $this->validateInputs($request->all());

        if($validator->fails()){
          return response()->json(['data' => null, "status" => "false", "status_code" => "200", "message" => $validator->getMessageBag()->toArray()], 200);
        }
        // find customer from contact number
        $customer =Customers::where('contact_number',$request->contact_number)->first();

        try {

            DB::beginTransaction();
            //add customer from contact number when already not exist.
            if(empty($customer)){
                $customer =Customers::create([
                    'first_name'      => $request->first_name,
                    'last_name'       => $request->last_name,
                    'contact_number'  => $request->contact_number,
                    'email'           => $request->email,
                    'status'          => '1',
                ]);
            }

            $delivery_charge = 0.00;
            // set delivery charge
            if(isset($request->delivery_city_id) && $request->delivery_city_id !=null ){
              $city = City::find($request->delivery_city_id);
              $delivery_charge =  $city->delivery_charge;
            }
            // create order
            $order =Order::create([
                'order_type'              => $request->order_type,
                'payment_type'            => $request->payment_type,
                'customer_id'             => $customer->id,
                'status'                  => 'placed',
                'total'                   => 100,
                'delivery_first_name'     => $request->delivery_first_name,
                'delivery_last_name'      => $request->delivery_last_name,
                'delivery_city_id'        => $request->delivery_city_id,
                'delivery_address_line_1' => $request->delivery_address_line_1,
                'delivery_address_line_2' => $request->delivery_address_line_2,
                'delivery_phone_number'   => $request->delivery_phone_number,
                'delivery_charge'         => $delivery_charge,
                'payment_status'          => "pending"
              ]);

              // Add order menu items
              foreach($request->order_menu_items as $key=> $order_menu_item){

                $menuitem =MenuItem::find($order_menu_item['id']);
                $ordermenuitem = OrderMenuItem::create([
                    'order_id'     => $order->id,
                    'menu_item_id' => $order_menu_item['id'],
                    'price'        => $menuitem->price,
                    'qty'          => $order_menu_item['qty'],
                    'comment'      => $order_menu_item['menu_item_comment'],
                ]);

                  foreach($order_menu_item['menu_option_category_menu_option_id'] as $key=> $menu_option_category_menu_option_id){

                    OrderMenuOptionCategoryMenuOption::create([
                      'order_menu_item_id'                  => $ordermenuitem->id,
                      'menu_option_category_menu_option_id' => $menu_option_category_menu_option_id,
                    ]);
                  }

                  foreach($order_menu_item['addon_id'] as $key=> $addon_id){

                    $addon =MenuItemAddon::where('menu_item_id',$order_menu_item['id'])->where('addon_id',$addon_id)->first();

                    OrderMenuItemAddon::create([
                      'order_menu_item_id'     => $ordermenuitem->id,
                      'menu_item_addon_id'     => $addon_id,
                      'price'                  => $addon['amount'],
                    ]);
    
                  }

              }

            DB::commit();

            if (!empty($order)) {

                $order_id =array(
                  "order_id" =>$order->id
                );

                return response()->json(['data' => $order_id,"status" => "success", "status_code" => "200", "message" => "Order created successfully"], 200);
            }

          } catch (Throwable $e) {
              DB::rollback();
                report($e);
              return response()->json(['data' => null, "status" => "false", "status_code" => "500", "message" =>  ""], 500);
          }


    }

    /*
    |--------------------------------------------------------------------------
    |Private function / Input validation
    |--------------------------------------------------------------------------
    */
    private function validateInputs($inputs)
    {
      $rules =[
        'first_name'       => 'required|max:64',
        'last_name'        => "required|max:64",
        'email'            => "required|email:rfc,dns",
        'contact_number'   => "required",

        'order_type'              => "required",
        'payment_type'            => "required",

        'order_menu_items.*.id'   => "required",
        'order_menu_items.*.qty'  => "required",
        'order_menu_items.*.menu_option_category_menu_option_id' => "required",
        'order_menu_items.*.menu_item_comment' => "nullable",

        'delivery_first_name'     => 'required_if:order_type,deliver',
        'delivery_last_name'      => 'required_if:order_type,deliver',
        'delivery_city_id'        => 'required_if:order_type,deliver',
        'delivery_address_line_1' => 'required_if:order_type,deliver',
        'delivery_address_line_2' => 'required_if:order_type,deliver',
        'delivery_phone_number'   => 'required_if:order_type,deliver',
      ];

      return Validator::make($inputs, $rules);
    }

}

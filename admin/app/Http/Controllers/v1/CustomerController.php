<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Customers;
use Validator;
use Response;

class CustomerController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    |Public function / Create Customer
    |--------------------------------------------------------------------------
    */
    public function createCustomer(Request $request){
      

        $validator = $this->validateInputs($request->all());

        if($validator->fails()){
          return response()->json(['data' => null, "status" => "false", "status_code" => "200", "message" => $validator->getMessageBag()->toArray()], 200);
        }

        try
        {
            $customer =Customers::create([
              'first_name'      => $request->first_name,
              'last_name'       => $request->last_name,
              'contact_number'  => $request->contact_number,
              'address_line_1'  => $request->address_line_1,
              'address_line_2'  => $request->address_line_2,
              'email'           => $request->email,
              'status'          => '1',
          ]);
          
          if (!empty($customer)) {
            $customer =Customers::find($customer->id);
            return response()->json(['data' => $customer, "status" => "success", "status_code" => "200", "message" => "Customer added successfully"], 200);
          }
        }
        catch(\Illuminate\Database\QueryException  $e)
        {
            return response()->json(['data' => null, "status" => "false", "status_code" => "500", "message" => 'Customer not created'], 500);
        }      

    }

    /*
    |--------------------------------------------------------------------------
    |Public function / get all customers
    |--------------------------------------------------------------------------
    */
    public function getAllCustomer(Request $request){

      $customers = Customers::all();

      if($customers->isEmpty()){
          return response()->json(['data' => null, "status" => "success", "status_code" => "200", "message" => "No results found"], 200);
      }
      return response()->json(['data' => $customers, "status" => "success", "status_code" => "200", "message" => "All customers"], 200);
      
    }

    /*
    |--------------------------------------------------------------------------
    |Public function / get customer by id
    |--------------------------------------------------------------------------
    */
    public function getCustomer(Request $request){

      $customer = Customers::find($request->id);

      if(empty($customer)){
        return response()->json(['data' => null, "status" => "success", "status_code" => "200", "message" => "No result found"], 200);
      }
      
      return response()->json(['data' => $customer, "status" => "success", "status_code" => "200", "message" => "Customer"], 200);
    }

    
    
    /*
    |--------------------------------------------------------------------------
    |Private function / Input validation
    |--------------------------------------------------------------------------
    */
    private function validateInputs($inputs)
    {
      $rules =[
        'first_name'      => "required",
        'last_name'       => "required",
        'contact_number'  => "required|numeric",
        'address_line_1'  => "nullable",
        'address_line_2'  => "nullable",
        'email'           => "nullable",
      ];

      return Validator::make($inputs, $rules);
    }
}

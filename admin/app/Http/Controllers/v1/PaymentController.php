<?php

namespace App\Http\Controllers\v1;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Log;
use Illuminate\Http\Request;
use Validator;

class PaymentController extends Controller
{
    public function doTransaction(Request $request)
    {
        try {
            Log::info("Starting do transaction", $request->all());
            $validator = $this->validateInputs($request->all());

            if ($validator->fails()) {
                Log::warning("Do transaction Validation failed", $validator->getMessageBag()->toArray());
                return response()->json(['data' => null, "status" => "false", "status_code" => "200", "message" => "Invalid Request"], 200);
            }

            Log::warning("Do transaction Validation success", $request->all());
            $order = Order::find($request->order_id);
            if ($request->payment_type == "stripe") {
                return $this->doStripePayment($request, $order);
            }
            return response()->json(['data' => null, "status" => "false", "status_code" => "200", "message" => "Invalid Request"], 200);
        } catch (\Throwable $th) {
            Log::error("Exception in do transaction", [$request->all(), $th->getMessage()]);
            return response()->json(['data' => null, "status" => "false", "status_code" => "500", "message" => "Server error"], 500);
        }

    }

    public function doStripePayment(Request $request, Order $order)

    {
        Log::info("Start doing stripe payment", [$order->id, $order->order_total]);
        if ($order->payment_status != "pending") {
            Log::error("Order payment status is not pending", ["order-id" => $order->id]);
            return response()->json(['data' => null, "status" => "false", "status_code" => "200", "message" => "Invalid Request"], 200);
        }
        \Stripe\Stripe::setApiKey('sk_test_51JQjZpBWE2OUZhePSN0QwtNKJL9F1xrZPb4NUlLVeGpHwgEtyEHm9osWb9jFy2lOrbClWDQRZAzEqM3SVn0SMBci000RRKujXT');
        $order->update([
            "payment_method" => "stripe"
        ]);

        $stripeCharge = \Stripe\Charge::create([
            "amount" => 100 * ($order->order_total),
            "currency" => "AUD",
            "source" => $request->stripeToken,
            "description" => "#". $order->id." Payment"
        ]);
        Log::info("Start doing stripe payment", ["reponse" => $stripeCharge]);
        if($stripeCharge->status == "succeeded"){
            Log::info("Stripe payment succeeded", ["order-id" => $order->id]);
            $order->update([
                "amount_paid" => ($stripeCharge->amount_captured)/100,
                "payment_reference" => $stripeCharge->id,
                'payment_status' => 'success'
            ]);
            return response()->json(['data' => null, "status" => "success", "status_code" => "200", "message" => "Payment Success"], 200);
        }else{
            Log::error("Stripe payment NOT SUCCESS", ["order-id" => $order->id]);
            $order->update([
                "amount_paid" => 0,
                'payment_status' => 'failed'
            ]);
            return response()->json(['data' => null, "status" => "failed", "status_code" => "200", "message" => "Payment failed"], 200);
        }
    }

    private function validateInputs($inputs)
    {
        $rules = [
            'payment_type'      => "required|string|in:stripe",
            'order_id'       => "required|exists:orders,id",
            'stripeToken'  => "required_if:payment_type,stripe"
        ];

        return Validator::make($inputs, $rules);
    }

}

<?php

namespace App\Http\Controllers\v1;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Hash;
use Log;

class ApiAuthController extends Controller
{

    public function login(Request $request){
        try {
            Log::info("API login request", [$request->all()]);
            $request->validate([

                'username' => 'required|exists:users,username',

                'password' => 'required|min:6',

                'device_name' => 'required',

            ]);

            $user = User::where('username', $request->username)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(['errors' => [
                    "auth_error" => 'The provided credentials are incorrect.'
                ]], 200);
            }

            return response()->json(['data' => ["token" => $user->createToken($request->device_name)->plainTextToken], "status" => "success", "status_code" => "200", "message" => ""], 200);
        } catch (\Throwable $th) {
            Log::debug("Error in logging", [$th->getMessage()]);
            return response()->json(['errors' => [
                "auth_error" => 'The provided credentials are incorrect.'
            ]], 200);
        }

    }
}

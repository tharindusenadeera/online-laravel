<?php

namespace App\Http\Controllers;

use Validator;
use Response;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;


class UserController extends Controller
{
    public function handleLoginView()
    {
        if(auth()->check()){
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function handleLogOut()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    /*
    |--------------------------------------------------------------------------
    |Public function /  login
    |--------------------------------------------------------------------------
    */
    public function login(Request $request)
    {
      $validator = Validator::make($request->all(), $this->getUserValidations());

      if($validator->fails()){
        return Response::json(['errors' => $validator->getMessageBag()->toArray()], 200);
      }else{
        $userdata = array(
                 'username'   => $request->user_name,
                 'password'   => $request->password
        );

        if(Auth::attempt($userdata)){
            return Response::json(['success' => "19199212", "message" => "Loged in successfully."], 200);
        }else{
            return Response::json(['errors' => ["error" => "Sorry, we coudn't find your details"]], 200);
        }
      }
    }

    /*
    |--------------------------------------------------------------------------
    |Public function / User Validation
    |--------------------------------------------------------------------------
    */
    public function getUserValidations()
    {
      $rules = array(
         'user_name' => 'required',
         'password'  => 'required'
      );

      return $rules;
    }

    public function index()
    {
            $users = User::where("user_level", "!=", "admin")->get();
            Log::info("Loading all users");
            return view(
                "users.users",
                ["users" => $users]
            );

    }

    public function store(Request $request)
    {
        Log::info("Start creating new user");

        $validator = $this->validateInputs($request->all());
        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 200);
        }

        $user = User::create([
            "name" => $request->name,
            "username" => $request->username,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "user_level" => $request->user_level

        ]);

        if ($user) {
            return Response::json(['success' => "19199212", "message" => "User added successfully"], 200);
        }
    }

    public function validateInputs($inputs, $id = -1)
    {
        $rules = [
            "name" => "required|min:3",
            "email" => "required|email|unique:users,email," . $id,
            "username" => "required|min:3|unique:users,username," . $id,
            "password" => "required|confirmed|min:6",
            "user_level" => "required|in:manager,waiter,pos-user"
        ];
        if ($id  != -1 && $inputs["password"] == null && $inputs["password_confirmation"] == null){
            unset($rules["password"]);
        }

        return Validator::make($inputs, $rules);
    }

    public function show($id)
    {
        $user = User::where("user_level", "!=", "admin")
        ->findOrFail($id);

        return Response::json(['success' => "19199212", "data" => $user], 200);
    }

    public function update($id, Request $request)
    {
        Log::info("Start updating user", [$id]);
        $validator = $this->validateInputs($request->all(), $id);
        if ($validator->fails()) {
            return Response::json(['errors' => $validator->getMessageBag()->toArray()], 200);
        }

        $user = User::where("user_level", "!=", "admin")
            ->findOrFail($id);

        if ($user) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->user_level = $request->user_level;

            if ($request->password != null && $request->password_confirmation != null) {
                $user->password = Hash::make($request->password);
                Log::info("Updating the user : ". $user->id. " password");
            }
        }


        if ($user->save()) {
            return Response::json(['success' => "19199212", "message" => "User updated successfully"], 200);
        }
    }

    public function toggleStatus($id, $status, Request $request)
    {
        if( $status == 0 || $status == 1){
            $user = User::where("user_level", "!=", "admin")
            ->findOrFail($id);

            if ($user) {
                $user->status = $status;
            }

            if ($user->save()) {
                return Response::json(['success' => "19199212", "message" => "User updated successfully"], 200);
            }
        }
    }
}

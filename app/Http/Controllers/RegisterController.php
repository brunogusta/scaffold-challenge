<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


use App\User;

class RegisterController extends Controller
{
  public function register(Request $request) {
    try {
      $messages = [
        'required' => 'The :attribute field is required.',
        'unique' => 'The :attribute field already exists',
      ];

      $validator = Validator::make($request->all(), [
          'email' => 'required|unique:users',
          'name' => 'required',
          'password' => 'required',
      ], $messages);

      if ($validator->fails()) {
          return response($validator->errors()->first(), 400);
      }

      $user = new User();

      $user->email = $request->email;
      $user->name = $request->name;
      $user->password = Hash::make($request->password);

      $user->save();

      Auth::login($user, true);

      return response()->json(['user' => $user], 200);

    }catch (Exception $e) {
        var_dump($e);
        return response('Register internal error', 500);
    }
  }
}

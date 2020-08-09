<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


use App\User;

class LoginController extends Controller
{
  public function init() {
    try {
      $user = Auth::user();
      return response()->json(['user' => $user], 200);
    }catch (Exception $e){
      return response('Login internal error', 500);
    }
  }

  public function login(Request $request) {
    try {
      $credentials = $request->only('email', 'password');

      $user = User::where('email', $request->email)->first();

      $messages = [
          'required' => 'The :attribute field is required.',
          'exists' => 'The :attribute not exist.',
        ];

      $validator = Validator::make($request->all(), [
          'email' => 'required|exists:users',
          'password' => 'required',
      ], $messages);


      if ($validator->fails()) {
        return response($validator->errors()->first(), 400);
      }

      if (!Hash::check($request->password, $user->password)) {
        return response('Incorrect Password', 400);
      }

      if (!$user->confirmed) {
        return response('User is not confirmed.', 400);
      }

      Auth::attempt($credentials, true);

      $user = Auth::user();

      return response()->json(['user' => $user], 200);

    }catch (Exception $e) {
        return response('Login internal error', 500);
    }
  }

  public function logout() {
    try {
      Auth::logout();
    }catch (Exception $e) {
      return response('Login internal error', 500);
    }
  }
}

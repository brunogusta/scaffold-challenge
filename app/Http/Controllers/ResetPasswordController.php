<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


use App\User;
class ResetPasswordController extends Controller
{
  public function reset(Request $request, $hash) {
    try {
      User::where('password_reset_token', $hash)
          ->update([
            'password' => Hash::make($request->password),
            'password_reset_token' => null
            ]);

      return response()
          ->json(['message' => 'Password updated successfully.']);

    }catch(Exception $e) {
      return response($e, 500);
    }
  }
}

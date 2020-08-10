<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\User;

class ConfirmEmailController extends Controller
{
  public function confirm(Request $request, $hash) {
    try{
      User::where('email_confirm_token', $hash)
        ->update([
          'confirmed' => true,
          'email_confirm_token' => null
          ]);

      return response()->json(['message' => 'E-mail confirmed.']);
    }catch(Exception $e) {
      return response('Unexpected error on email confirmation, try again', 500);
    }
  }
}

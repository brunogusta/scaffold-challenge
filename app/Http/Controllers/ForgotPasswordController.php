<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPasswordEmail;

use App\User;

class ForgotPasswordController extends Controller
{
  public function forgot(Request $request) {
    try {

      $messages = [
        'required' => 'The :attribute field is required.',
        'exists' => 'The :attribute not exist.',
      ];

      $validator = Validator::make($request->all(), [
        'email' => 'required|exists:users',
      ], $messages);

      if ($validator->fails()) {
        return response($validator->errors()->first(), 400);
      }

      $user = User::where('email', $request->email)->first();

      $hash = md5(uniqid(rand(), true));

      $baseUrl = URL::to('/');

      $link = $baseUrl . '/#/reset-password/' . $hash;

      User::where('id', $user->id)
          ->update(['password_reset_token' => $hash]);


      Mail::mailer('smtp')->to($user->email)->send(new ForgotPasswordEmail($link, $user->name));


      return response()
          ->json(['message' => 'Email send successfully'], 200);

    }catch(Exception $e) {
      return response('Unexpected error on request, try again', 500);
    }
  }
}

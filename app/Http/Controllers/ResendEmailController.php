<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmationEmail;

use App\User;

class ResendEmailController extends Controller
{
  public function send(Request $request) {
    try{
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

      if($user->confirmed) {
        return response('User already confirmed.', 400);
      }

      $hash = md5(uniqid(rand(), true));

      $baseUrl = URL::to('/');

      $link = $baseUrl . '/#/confirm-email/' . $hash;

      User::where('id', $user->id)->update(['email_confirm_token' => $hash]);


      Mail::mailer('smtp')->to($user->email)->send(new ConfirmationEmail($link, $user->name));

      return response()->json(['message' => 'Email successfully sent.'], 200);

    }catch (Exception $e) {
      return response('Unexpected error resend email requestion, try again', 500);
    }
  }
}

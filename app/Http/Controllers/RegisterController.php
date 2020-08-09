<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmationEmail;

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

      $hash = md5(uniqid(rand(), true));

      $baseUrl = URL::to('/');

      $link = $baseUrl . '/#/confirm-email/' . $hash;

      $user = new User();
      $user->email = $request->email;
      $user->name = $request->name;
      $user->password = Hash::make($request->password);
      $user->email_confirm_token = $hash;
      $user->save();

      Mail::mailer('smtp')->to($user->email)->send(new ConfirmationEmail($link, $user->name));


      return response()->json(['message' => 'Success'], 200);

    }catch (Exception $e) {
      return response('Register internal error', 500);
    }
  }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use app\User;

class ForgotPasswordController extends Controller
{
    public function forgot(Request $request) {
        $email = $request->only('email');

        $user = User::where('email', $email)->first();

        if (!$user) {
            return response.json(['error' => 'Email not found.'], 400);
          }

        if ($user->confirmed) {
            return response.json(['error' => 'Email already confirmed.'], 400);
          }

        $bytes = random_bytes(15);

        $resetPasswordToken = bin2hex($bytes);

        User::where('email', $email)
            ->update(['password_reset_token' => $resetPasswordToken]);


        //send email

        return response()
            ->json('Email to reset password send successfuly', 200);
    }
}

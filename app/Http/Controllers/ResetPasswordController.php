<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function reset(Request $request) {
        $data = $request->only('token', 'password');

        $user = User::where('password_reset_token', $data->token)->first();

        if (!$user) {
            return response.json(['error' => 'User not found.'], 400);
          }

        User::where('id', $user->id)
            ->update([
                    'password' => Hash::make($data->password),
                    'password_reset_token' => null
                ]);


        return response()
            ->json('Password changed successfuly', 200);
    }
}

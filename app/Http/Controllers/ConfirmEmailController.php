<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ConfirmEmailController extends Controller
{
    public function confirm() {
        $token = Input::get('token');
        info($token);
    }
}

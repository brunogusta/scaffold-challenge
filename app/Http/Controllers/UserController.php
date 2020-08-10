<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UserController extends Controller
{
  public function index() {
    try {
      $users = User::all();

      return response()->json($users);
    }catch (Exception $e){
      return response('Unexpected error on fetch all users, try again', 500);
    }
  }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

use App\Models\User;

class CheckController extends Controller
{
  public function checkNickname(Request $request)
  {
      $nickname = $request->input('nickname');

      $isAvailable = !User::where('nickname', $nickname)->exists();

      return response()->json(['isAvailable' => $isAvailable]);
  }
  public function checkEmail(Request $request)
  {
      $email = $request->input('email');

      $isAvailable = !User::where('email', $email)->exists();

      return response()->json(['isAvailable' => $isAvailable]);
  }
}

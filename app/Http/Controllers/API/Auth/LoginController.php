<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class LoginController extends AppBaseController
{
  public function login(Request $request)
  {
    $email = $request->email;
    $password = $request->password;

    $user = User::where('email', $email)->first();

    if (! $user || ! Hash::check($password, $user->password)) {
      throw ValidationException::withMessages([
        'email' => ['ログイン認証に失敗しました。'],
      ]);
    }
    $access_token = $user->createToken('token')->plainTextToken;

    return response(compact('access_token'),200);
  }

  public function me(Request $request)
  {
    $user = $request->user();
    $ret = array(
      'uuid'  => $user->uuid,
      'name'  => $user->name,
      'email'  => $user->email,
    );

    return response(['user' => $ret], 200);
  }

  public function logout (Request $request) {
    $request->user()->token()->revoke();
    return response(['message' => 'You have been successfully logged out.'], 200);
  }
}
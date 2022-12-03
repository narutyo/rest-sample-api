<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\Sanctum\PersonalAccessToken;
use App\Models\User;

class LoginController extends AppBaseController
{
  public function me(Request $request)
  {
    $user = $request->user();
    $ret = array(
      'uuid'  => $user->uuid,
      'name'  => $user->name,
    );

    return response(['user' => $ret], 200);
  }

  public function logout (Request $request) {
    $request->user()->token()->revoke();
    return response(['message' => 'You have been successfully logged out.'], 200);
  }
}
<?php

namespace App\Http\Requests\API\Auth;

use App\Http\Requests\API\BaseRequest;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ResetPasswordRequest extends BaseRequest
{
  public function rules()
  {
    $rules = [
      'email' => 'required|email|exists:users,email',
      'token' => 'required',
      'password' => 'required|confirmed',
    ];
    return $rules;
  }

  public function messages()
  {
    return [
    ];
  }
}

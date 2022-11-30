<?php

namespace App\Http\Requests\API\Auth;

use App\Http\Requests\API\BaseRequest;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ForgetPasswordRequest extends BaseRequest
{
  public function rules()
  {
    $rules = [
      User::EMAIL => 'required|email|exists:users,email',
    ];
    return $rules;
  }

  public function messages()
  {
    return [
    ];
  }
}

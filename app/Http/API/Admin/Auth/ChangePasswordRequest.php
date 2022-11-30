<?php

namespace App\Http\Requests\API\Admin\Auth;

use App\Http\Requests\API\BaseRequest;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ChangePasswordRequest extends BaseRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    $rules = [
      'current_password' => 'required',
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

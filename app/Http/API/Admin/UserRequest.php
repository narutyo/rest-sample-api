<?php

namespace App\Http\Requests\API\Admin;

use App\Http\Requests\API\BaseRequest;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserRequest extends BaseRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    $rules = [
      User::NAME => 'required',
      User::EMAIL => 'required|email|unique:users,email,' . $this->uuid . ',uuid',
      User::COMPANY_ID => 'required',
    ];
    return $rules;
  }

  public function messages()
  {
    return [
    ];
  }
}

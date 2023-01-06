<?php

namespace App\Http\Requests\API\Auth;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\API\BaseRequest;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserRequest extends BaseRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules(Request $request)
  {
    $user = $this->user;
    $rules = [
      User::NAME => 'required',
      User::IDENTIFICATION_CODE => [
        'required',
        Rule::unique('users')->where(function ($query) use($user, $request) {
          return $query->where('identification_code', $request->input('identification_code'))
            ->whereNull('deleted_at')
            ->when(isset($user), function($query) use($user) {
              return $query->whereNot('uuid', $user->uuid);
            });
        }),
      ],
      User::PASSWORD => 'sometimes|required',
      User::ADMIN_FLG => 'sometimes',
    ];
    return $rules;
  }

  public function messages()
  {
    return [
    ];
  }
}

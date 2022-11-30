<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\AppBaseController;
use App\Http\Requests\API\Auth\ChangePasswordRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ChangePasswordController extends AppBaseController
{
    public function update(ChangePasswordRequest $request)
    {
      $request->validated();

      $user = $request->user();
      if (!Hash::check($request->input('current_password'), $user->password)) {
        return $this->sendError('現在のパスワードが正しくありません', 422);
      }

      try {
        $user->fill([
            'password' => Hash::make($request->input('password'))
        ])->save();

        return $this->sendSuccess('パスワードの変更が完了しました');
      } catch (\Throwable $e) {
        return $this->sendError($e->getMessage(), 500);
      }
  }
}

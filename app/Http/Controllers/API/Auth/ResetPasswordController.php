<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\AppBaseController;
use App\Http\Requests\API\Auth\ResetPasswordRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends AppBaseController
{
    public function reset(ResetPasswordRequest $request)
    {
      $request->validated();
      
      $status = Password::reset(
        $request->only('email', 'password', 'token'),
        function ($user, $password) {
          $user->forceFill([
            'password' => Hash::make($password)
          ])->setRememberToken(Str::random(60));

          $user->save();

          event(new PasswordReset($user));
        }
      );

      return $status === Password::PASSWORD_RESET
          ? $this->sendSuccess('パスワード再設定が完了しました')
          : $this->sendError('パスワードの再設定が完了しませんでした', 401);
  }
}

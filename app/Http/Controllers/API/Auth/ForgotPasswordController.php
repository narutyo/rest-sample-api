<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\AppBaseController;
use App\Http\Requests\API\Admin\Auth\ForgetPasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends AppBaseController
{
  public function sendResetLinkEmail(ForgetPasswordRequest $request)
  {
    $request->validated();

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status == Password::RESET_LINK_SENT
        ? $this->sendSuccess('パスワード再設定メールを送信しました')
        : $this->sendError('パスワード再設定メールを送信できませんでした', 401);
  }
}
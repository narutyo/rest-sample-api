<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class LoginController extends Controller
{
  public function login()
  {
    $query = http_build_query([
        'client_id' => '3', // 作成したクライアントの「Cliend ID」を指定
        'redirect_uri' => config('auth_server.passport_callback'),
        'response_type' => 'code',
        'scope' => '',
    ]);

    // Passportサーバーの認可エンドポイントにリダイレクト
    return redirect(config('auth_server.passport_redirect').'/oauth/authorize?' . $query);
  }

  public function callback(Request $request)
  {
    $http = new Client;
    $response = $http->post(config('auth_server.passport_api').'/oauth/token', [
        'form_params' => [
          'grant_type' => 'authorization_code',
          'client_id' => '3', // 作成したクライアントの「Cliend ID」を指定
          'client_secret' => 'hJ0AzuZ6kHlIMUAXUl9rYCi4HRSczLLdAelSjrmy', // 作成したクライアントの「Client secret」を指定
          'redirect_uri' => config('auth_server.passport_callback'),
          'code' => $request->input('code')
        ],
    ]);

    $token = json_decode((string)$response->getBody(), true);

    session()->put('access_token', $token['access_token']);
    return redirect('/');
  }

}

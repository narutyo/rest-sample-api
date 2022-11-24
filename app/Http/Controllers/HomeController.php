<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class HomeController extends Controller
{
  public function index()
  {
    $access_token = session()->get('access_token');
    if (isset($access_token)) {
        $http = new Client;
        $response = $http->request('GET', config('auth_server.passport_api').'/api/user', [
            'headers' => [
                'Accept'     => 'application/json',
                'Authorization' => 'Bearer '.$access_token,
            ]
        ]);
        $user = json_decode((string)$response->getBody(), true);
        return view('home', ['name' => $user['name']]);
    } else {
        return redirect('login');
    }
  }
}

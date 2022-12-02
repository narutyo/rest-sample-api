<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class HomeController extends Controller
{
  public function index()
  {
    abort(403);
  }
}

<?php

namespace App\Http\Controllers\GEMBA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sample;

class SampleController extends Controller
{
  public function store(Request $request)
  {
    $obj = new Sample;
    $obj->store($request->all());
    return;
  }
}

<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserController extends ApiBaseController
{
    protected function model()
    {
      return User::class;
    }

    protected function getTypeIndex($request)
    {
      return $this->apiSpecBaseUrl . '/get_User';
    }

    protected function getTypeShow()
    {
      return $this->apiSpecBaseUrl . '/get_User';
    }

    protected function getTypeDestroy()
    {
      return $this->apiSpecBaseUrl . '/delete_User';
    }
}

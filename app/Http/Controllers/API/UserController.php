<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests\API\Auth\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserController extends ApiBaseController
{
    public function store(UserRequest $request)
    {
      Log::info('Start create user');
      try {
        $user = User::createUser($request->validated());
        Log::info('Create user success');
        return $this->success(
          'create_user',
          'User saved successfully',
          $this->apiSpecBaseUrl . '/create_user',
          $request,
          collect([$user])->count(),
          $user->toArray()
        );
      } catch (\Throwable $e) {
        return $this->sendError($e->getMessage(), 500);
      }
    }

    public function update(User $user, UserRequest $request)
    {
      Log::info('Start update user');
      try {
        $user = User::updateUser($request->validated(), $user);
        Log::info('update user success');
        return $this->success(
          'update_user',
          'User updated successfully',
          $this->apiSpecBaseUrl . '/update_user',
          $request,
          collect([$user])->count(),
          $user->toArray()
        );
      } catch (\Throwable $e) {
        return $this->sendError($e->getMessage(), 500);
      }
    }

    public function delete(User $user, Request $request)
    {
      Log::info('Start delete user');
      try {
        $user->delete();
        Log::info('delete user success');
        return $this->success(
          'delete_user',
          'User deleted successfully',
          $this->apiSpecBaseUrl . '/delete_user',
          $request,
          0,
          null
        );
      } catch (\Throwable $e) {
        return $this->sendError($e->getMessage(), 500);
      }
    }

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

    protected function where($request)
    {
      $criteria = $request->all();
      $criteria = array_merge($criteria, [
          User::SYSTEM_USER => false
      ]);
      return $criteria;
    }
}

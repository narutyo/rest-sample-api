<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use App\Traits\UuidTrait;

class User extends BaseModel implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;
    use HasApiTokens, Notifiable;
    use UuidTrait;

    public const NAME = 'name';
    public const EMAIL = 'email';
    public const IDENTIFICATION_CODE = 'identification_code';
    public const ADMIN_FLG = 'admin_flg';
    public const SYSTEM_USER = 'system_user';
    public const PASSWORD = 'password';
  
    public $fillable = [
      self::NAME,
      self::EMAIL,
      self::IDENTIFICATION_CODE,
      self::ADMIN_FLG,
      self::PASSWORD,
    ];
  
    protected $casts = [
      self::ID => 'string',
      self::EMAIL => 'string',
      self::IDENTIFICATION_CODE => 'string',
      self::ADMIN_FLG => 'boolean',
    ];
  
    protected $hidden = [
      self::ID,
      self::PASSWORD,
    ];
  
    public function findForPassport($username)
    {
        return $this->where('identification_code', $username)->first();
    }

    public static function createUser($input)
    {
      $user = self::create($input)->fresh();
      return $user;
    }

    public static function updateUser($input, $user)
    {
      $user->update($input);
      return $user;
    }

    public function setPasswordAttribute($value)
    {
      $this->attributes['password'] = Hash::make($value);
    }  
}

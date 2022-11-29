<?php
namespace App\Traits;

use Webpatser\Uuid\Uuid;

trait UuidTrait
{
  public static function bootUuidTrait()
  {
    static::creating(function ($model) {
      $model->uuid = Uuid::generate()->string;
    });
  }
}

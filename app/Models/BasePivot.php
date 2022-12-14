<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\AuthorObservable;
use App\Traits\UuidTrait;

class BasePivot extends Pivot
{
  use AuthorObservable;
  use UuidTrait;
  use SoftDeletes;
  use HasFactory;

  public const ID = 'id';
  public const UUID = 'uuid';
  public const CREATED_AT = 'created_at';
  public const UPDATED_AT = 'updated_at';
  public const CREATED_BY = 'created_by';
  public const UPDATED_BY = 'updated_by';
  public const DELETED_AT = 'deleted_at';

  public static $rules = [
    self::ID => 'required|integer',
    self::UUID => 'required|string|max:36',
    self::CREATED_AT => 'nullable',
    self::UPDATED_AT => 'nullable',
    self::UPDATED_BY => 'nullable',
    self::CREATED_BY => 'nullable',
    self::DELETED_AT => 'nullable',
  ];

  public $fillable = [
    self::UUID,
  ];

  protected $casts = [
    self::ID => 'integer',
    self::UUID => 'string',
  ];

  protected $hidden = [
    self::ID,
    self::CREATED_BY,
    self::UPDATED_BY,
    self::DELETED_AT,
  ];

  protected $dates = [
    self::CREATED_AT,
    self::UPDATED_AT
  ];
}

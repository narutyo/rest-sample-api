<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\AuthorObservable;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BaseModel extends Model
{
  use AuthorObservable;
  use UuidTrait;
  use SoftDeletes;
  use HasFactory;

  protected $dates = [
    'created_at',
    'updated_at',
    'deleted_at',
  ];

  protected $hidden = [
    'id',
    'created_at',
    'updated_at',
    'deleted_at',
  ];


  public const DATE_FORMAT_ISO8601 = 'c';
  public const DATE_FORMAT_DATETIME = 'Y-m-d H:i:s';
  public const DATE_FORMAT = self::DATE_FORMAT_ISO8601;

  protected $casts = [
    'id' => 'integer',
    'uuid' => 'string',
    'created_at'  => 'datetime:' . self::DATE_FORMAT,
    'created_by'  => 'integer',
    'updated_at'  => 'datetime:' . self::DATE_FORMAT,
    'updated_by'  => 'integer',
    'deleted_at'  => 'datetime:' . self::DATE_FORMAT,
  ];

  public function getRouteKeyName()
  {
      return 'uuid';
  }
  
  public function store($input)
  {
    $fillable = $this->getFillable();
    foreach($input as $data) {
      $json = (!empty($data['json'])) ? json_decode($data['json'], true) : array();
      if (count($json)>0) {
        $result = array_filter($data, function($element) use ($fillable) {
          return in_array($element, $fillable);
        }, ARRAY_FILTER_USE_KEY);
        $result = array_merge($result, 
          array_filter($json, function($element) use ($fillable) {
            return in_array($element, $fillable);
          }, ARRAY_FILTER_USE_KEY)
        );

        $exists = $this->where('_documentId', $result['_documentId'])
                      ->where('_pageId', $result['_pageId'])
                      ->where('_objectId', $result['_objectId'])
                      ->first();
        if (is_object($exists)) {
          $exists->update($result);
        } else {
          $this->create($result)->fresh();
        }
      }
    }
    return;
  }
}

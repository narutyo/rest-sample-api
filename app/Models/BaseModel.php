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

  public const ID = 'id';
  public const UUID = 'uuid';
  public const CREATED_AT = 'created_at';
  public const UPDATED_AT = 'updated_at';
  public const CREATED_BY = 'created_by';
  public const UPDATED_BY = 'updated_by';
  public const DELETED_AT = 'deleted_at';

  public const DATE_FORMAT_ISO8601 = 'c';
  public const DATE_FORMAT_DATETIME = 'Y-m-d H:i:s';
  public const DATE_FORMAT = self::DATE_FORMAT_ISO8601;

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
    // self::ID,
    self::CREATED_BY,
    self::UPDATED_BY,
    self::DELETED_AT,
  ];

  protected $dates = [
    self::CREATED_AT,
    self::UPDATED_AT
  ];

  public function getRouteKeyName()
  {
      return self::UUID;
  }
  
  public static function findByKey($key, $criteria)
  {
    $model = new static();
    $query = static::queryByKey($key);
    $query = $model->addRelations($query, $criteria);
    $data = $query->get()->first();
    return $data ? $data : null;
  }

  public static function queryByKey($key, $criteria = null)
  {
    $model = new static();
    $query = $model->newQuery();
    if (is_array($key)) {
      $query = $query->whereIn('uuid', $key);
    } else {
      $query = $query->where('uuid', $key);
    }
    if ($criteria) {
      $query = $query->where($criteria);
    }
    return $query;
  }

  public static function count($search = [])
  {
    $model = new static();
    $query = $model->search($search);
    return $query->count();
  }

  public static function all(
    $search = [],
    $skip = null,
    $limit = null,
    $columns = ['*'],
    $sort_trg = array('created_at', 'DESC')
  ) {
    $model = new static();
    $query = $model->search($search, $skip, $limit)
        ->orderBy($sort_trg[0], $sort_trg[1]);
    return $query->get($columns);
  }

  public function search($criteria = [])
  {
    $model = new static();
    $query = $model->newQuery();
    $attributes = \Schema::getColumnListing($model->getTable());

    if (count($criteria)) {
      foreach ($criteria as $key => $value) {
        if (in_array($key, $attributes)) {
          if (is_array($value)) {
            $query->whereIn($key, $value);
          } else {
            $query->where($key, $value);
          }
        }
      }
      $query = $model->addRelations($query, $criteria);
    }
    if (!empty($criteria['since'])) {
      $query->where('created_at', '>=', date('Y-m-d', strtotime($criteria['since'])));
    }
    if (!empty($criteria['until'])) {
      $query->where('created_at', '<=', date('Y-m-d', strtotime($criteria['until'])));
    }

    $sort = (
      !empty($criteria['sort']) &&
      \Schema::hasColumn($model->getTable(), $criteria['sort'])
    ) ? $criteria['sort'] : self::CREATED_AT;
    $order = (
      !empty($criteria['order']) &&
      (strtolower($criteria['order']) === 'asc' || strtolower($criteria['order']) === 'desc')
    ) ? $criteria['order'] : 'DESC';
    return $query->orderBy($sort, $order);
  }

  public function addRelations($query, $criteria)
  {
    $model = new static();
    $attributes = \Schema::getColumnListing($model->getTable());
    if (!empty($criteria['fields']) && count($criteria['fields'])) {
      foreach($criteria['fields'] as $key) {
        if (!in_array($key, $attributes) && method_exists($model, $key)) {
          $query->with($key);
        }
      }
    }
    return $query;
  }

  public function bulkStore($input)
  {
    $fillable = $this->getFillable();
    logger('fillable', $this->fillable);
    foreach($input as $data) {
      $result = array_filter($data, function($element) use ($fillable) {
        return in_array($element, $fillable);
      }, ARRAY_FILTER_USE_KEY);
      $json = (!empty($data['json'])) ? json_decode($data['json'], true) : array();
      $exists = $this->where('_documentId', $result['_documentId'])
                    ->where('_pageId', $result['_pageId'])
                    ->where('_objectId', $result['_objectId'])
                    ->first();
      if (count($json)>0) {
        $result = array_merge($result, 
          array_filter($json, function($element) use ($fillable) {
            return in_array($element, $fillable);
          }, ARRAY_FILTER_USE_KEY)
        );
  
        if (is_object($exists)) {
          $exists->update($result);
        } else {
          $this->create($result)->fresh();
        }
      } elseif (is_object($exists)) {
        $exists->delete();
      }
    }
    return;
  }
}

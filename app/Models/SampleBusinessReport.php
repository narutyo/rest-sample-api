<?php

namespace App\Models;

use Carbon\Carbon;

class SampleBusinessReport extends BaseModel
{
    public const TABLE_NAME = 'sample_business_reports';
    public $table = self::TABLE_NAME;

    protected $dates = [
      self::VISIT_DATE_TIME,
      self::NEXT_DATE_TIME,
    ];

    // ユニークキー
    public $unique_key = [
      self::REPORT_ID,
    ];

    public const REPORT_ID = 'reportId';
    public const NAME = 'name';
    public const CUSTOMER = 'customer';
    public const VISIT_DATE_TIME = 'visitDateTime';
    public const NEXT_DATE_TIME = 'nextDateTime';
    public const STATUS = 'status';
    public const RANK = 'rank';
    public const DETAILS = 'details';

    public const _DRIVER_ID = '_driveId';
    public const _DOCUMENT_ID = '_documentId';
    public const _OBJECT_TYPE = '_objectType';
    public const _OBJECT_ID = '_objectId';
    public const _PAGE_ID = '_pageId';
  
    public $fillable = [
      self::REPORT_ID,
      self::NAME,
      self::CUSTOMER,
      self::VISIT_DATE_TIME,
      self::NEXT_DATE_TIME,
      self::STATUS,
      self::RANK,
      self::DETAILS,

      self::_DRIVER_ID,
      self::_DOCUMENT_ID,
      self::_OBJECT_TYPE,
      self::_OBJECT_ID,
      self::_PAGE_ID,
    ];

    protected $casts = [
      self::REPORT_ID => 'string',
      self::NAME => 'string',
      self::CUSTOMER => 'string',
      self::VISIT_DATE_TIME => 'timestamp',
      self::NEXT_DATE_TIME => 'timestamp',
      self::STATUS => 'string',
      self::RANK => 'integer',
      self::DETAILS => 'string',
      
      self::_DRIVER_ID => 'string',
      self::_DOCUMENT_ID => 'string',
      self::_OBJECT_TYPE => 'string',
      self::_OBJECT_ID => 'string',
      self::_PAGE_ID => 'string',
    ];

    public function setVisitDateTimeAttribute($value)
    {
      $this->attributes['visitDateTime'] = (!$value) ? null : new Carbon($value);
    }

    public function setNextDateTimeAttribute($value)
    {
      $this->attributes['nextDateTime'] = (!$value) ? null : new Carbon($value);
    }
}

<?php

namespace App\Models;

class Sample extends GembaBase
{
    public const TABLE_NAME = 'samples';
    public $table = self::TABLE_NAME;

    public const NAME = 'name';

    public const _DRIVER_ID = '_driveId';
    public const _DOCUMENT_ID = '_documentId';
    public const _OBJECT_TYPE = '_objectType';
    public const _OBJECT_ID = '_objectId';
    public const _PAGE_ID = '_pageId';

    public $fillable = [
      self::NAME,

      self::_DRIVER_ID,
      self::_DOCUMENT_ID,
      self::_OBJECT_TYPE,
      self::_OBJECT_ID,
      self::_PAGE_ID,
    ];

    protected $casts = [
      self::NAME => 'string',
      
      self::_DRIVER_ID => 'string',
      self::_DOCUMENT_ID => 'string',
      self::_OBJECT_TYPE => 'string',
      self::_OBJECT_ID => 'string',
      self::_PAGE_ID => 'string',
    ];
}

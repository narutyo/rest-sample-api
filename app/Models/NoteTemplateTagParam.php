<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NoteTemplateTagParam extends BaseModel
{
    public const TABLE_NAME = 'note_template_tag_params';
    public $table = self::TABLE_NAME;

    public const NOTE_TEMPLATE_MASTER_ID = 'note_template_master_id';
    public const SEQUENCE = 'sequence';
    public const NAME = 'name';
    public const CREATE = 'create';
    public const OPEN = 'open';
    public const TYPE = 'type';
    public const SERIAL_NUMBER = 'serial_number';
    public const VALUE = 'value';

    public $fillable = [
      self::SEQUENCE,
      self::NAME,
      self::CREATE,
      self::OPEN,
      self::TYPE,
      self::SERIAL_NUMBER,
      self::VALUE,
    ];

    protected $casts = [
      self::SEQUENCE => 'string',
      self::NAME => 'string',
      self::CREATE  => 'boolean',
      self::OPEN  => 'boolean',
      self::TYPE => 'string',
      self::SERIAL_NUMBER => 'integer',
      self::VALUE => 'string',
    ];
}

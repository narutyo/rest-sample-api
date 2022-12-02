<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NoteAlignmentMaster extends BaseModel
{
    public const TABLE_NAME = 'note_alignment_masters';
    public $table = self::TABLE_NAME;

    // リレーション
    public const NOTE_TEMPLATE_MASTER = 'note_template_master';

    // フィールド
    public const NOTE_TEMPLATE_MASTER_ID = 'note_template_master_id';
    public const NAME = 'name';
    public const NOTE_URI = 'note_uri';

    public $fillable = [
      self::NOTE_TEMPLATE_MASTER_ID,
      self::NAME,
      self::NOTE_URI,
    ];

    protected $casts = [
      self::NAME => 'string',
      self::NOTE_URI => 'string',
    ];

    public function note_template_master() {
      return $this->belongsTo(NoteTemplateMaster::class, self::NOTE_TEMPLATE_MASTER_ID);
    }

    public function setNoteTemplateMasterIdAttribute($value)
    {
      if (!$value) {
        $this->attributes['note_template_master_id'] = 0;
      } elseif ($value == (string)(int)$value && is_object(NoteTemplateMaster::find('id'))) {
        $this->attributes['note_template_master_id'] = $value;
      } else {
        $obj = NoteTemplateMaster::where('uuid', $value)->first();
        $this->attributes['note_template_master_id'] = (is_object($obj)) ? $obj->id : 0;
      }
    }  
  
    public static function add($input)
    {
      $note = DB::transaction(function () use($input) {
        $note = self::create($input)->fresh();
        return $note;
      });
      return $note;
    }

    public static function edit($input, $note)
    {
      $note = DB::transaction(function () use($input, $note) {
        $note->update($input);
        return $note;
      });
      return $note;
    }
}

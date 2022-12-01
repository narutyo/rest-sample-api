<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NoteTemplateMaster extends BaseModel
{
    public const TABLE_NAME = 'note_template_masters';
    public $table = self::TABLE_NAME;

    public const NAME = 'name';
    public const ACCESS_ID = 'access_id';
    public const TEMPLATE_ID = 'template_id';
    public const FOLDER_URI = 'folder_uri';

    public $fillable = [
      self::NAME,
      self::ACCESS_ID,
      self::TEMPLATE_ID,
      self::FOLDER_URI,
    ];

    protected $casts = [
      self::NAME => 'string',
      self::ACCESS_ID => 'string',
      self::TEMPLATE_ID => 'string',
      self::FOLDER_URI => 'string',
    ];

    public static function add($input)
    {
      $template = DB::transaction(function () use($input) {
        $input[self::ACCESS_ID] = Str::random(26);
        $template = self::create($input)->fresh();
        return $template;
      });
      return $template;
    }

    public static function edit($input, $template)
    {
      $template = DB::transaction(function () use($input, $template) {
        $template->update($input);
        return $template;
      });
      return $template;
    }
}

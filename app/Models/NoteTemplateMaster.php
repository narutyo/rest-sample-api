<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NoteTemplateMaster extends BaseModel
{
    public const TABLE_NAME = 'note_template_masters';
    public $table = self::TABLE_NAME;

    // リレーション
    public const NOTE_TEMPLATE_TAG_PARAMS = 'note_template_tag_params';

    public const NAME = 'name';
    public const TEMPLATE_ID = 'template_id';
    public const FOLDER_URI = 'folder_uri';
    public const RECORDSET_MODEL = 'recordset_model';
    public const RECORDSET_TAGNAME_SPACE = 'recordset_tagname_space';

    public $fillable = [
      self::NAME,
      self::TEMPLATE_ID,
      self::FOLDER_URI,
      self::RECORDSET_MODEL,
      self::RECORDSET_TAGNAME_SPACE,
    ];

    protected $casts = [
      self::NAME => 'string',
      self::TEMPLATE_ID => 'string',
      self::FOLDER_URI => 'string',
      self::RECORDSET_MODEL => 'string',
      self::RECORDSET_TAGNAME_SPACE => 'string',
    ];

    public function note_template_tag_params() {
      return $this->hasMany(NoteTemplateTagParam::class, NoteTemplateTagParam::NOTE_TEMPLATE_MASTER_ID)
                  ->orderBy('serial_number', 'ASC');
    }

    public static function add($input)
    {
      $template = DB::transaction(function () use($input) {
        $template = self::create($input)->fresh();
        if ($input['createParams']) {
          $template->syncTagParams($template, 'create', $input['createParams']);
        }
        if ($input['supplyParams']) {
          $template->syncTagParams($template, 'supply', $input['supplyParams']);
        }
        return $template;
      });
      return $template;
    }

    public static function edit($input, $template)
    {
      $template = DB::transaction(function () use($input, $template) {
        $template->update($input);
        if ($input['createParams']) {
          $template->syncTagParams($template, 'create', $input['createParams']);
        }
        if ($input['supplyParams']) {
          $template->syncTagParams($template, 'supply', $input['supplyParams']);
        }
        return $template;
      });
      return $template;
    }

    public function syncTagParams($template, $sequence, $params)
    {
      $uuids = array_filter(array_column($params, 'uuid'));
      $template->note_template_tag_params()
              ->whereNotIn('uuid', $uuids)
              ->where('sequence', $sequence)
              ->delete();
      foreach($params as $param) {
        $model = $template->note_template_tag_params()->where('uuid', $param['uuid'])->first();
        if (!$model) {
          $model = new NoteTemplateTagParam;
          $model->note_template_master_id = $template->id;
          $model->sequence = $sequence;
        }
        $model->fill($param)->save();
      }
    }
}

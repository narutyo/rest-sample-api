<?php

namespace App\Models;

use Carbon\Carbon;
use Webpatser\Uuid\Uuid;
use App\Models\User;

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

    public function setRankAttribute($value)
    {
      $this->attributes['rank'] = (!$value) ? 0 : $value;
    }

    public static function aggregate($y, $m)
    {
      $start = strtotime(date('Y-m-d', mktime(0, 0, 0, $m, 1, $y)));
      $end = strtotime(date('Y-m-t', $start) . ' 23:59:59');
      $records = static::where('visitDateTime', '>=', date('Y-m-d H:i:s', $start))
                      ->where('visitDateTime', '<=', date('Y-m-d H:i:s', $end))
                      ->select('name')
                      ->selectRaw('DATE_FORMAT(visitDateTime, "%e") AS date')
                      ->selectRaw('COUNT(id) AS count')
                      ->groupBy('name')
                      ->groupBy('date')
                      ->orderBy('name')
                      ->get();
      $tmp = $ret = array();
      foreach($records as $record) {
        $tmp[$record->name][$record->date] = $record->count;
      }
      foreach($tmp as $name => $vals) {
        for($i=1; $i<=date('d', $end); $i++) {
          $ret[$name][$i] = (empty($tmp[$name][$i])) ? null : $tmp[$name][$i];
        }  
      }
      return $ret;
    }

    public static function generate($input)
    {
      $initialCount = static::where(self::REPORT_ID, 'like', 'Gen-%')->count();
      $users = User::whereIn('uuid', $input['users'])->get()->pluck('name')->toArray();
      $status = [
        '初回',
        '商談中',
        '成約見込み',
        '商談成立',
        '来期見送り',
        'ロスト',
      ];

      $days = 0;
      switch ($input['range']) {
        case 'week':
          $days = 7;
          break;
        case 'month':
          $days = 30;
          break;
        case 'quarter':
          $days = 90;
          break;
        case 'year':
          $days = 365;
          break;
      }

      $generates = [];
      for ($i = 0; $i < $input['count']; $i++) {
        $tmp = [];
        $period = rand(1, $days);
        $tmp[self::UUID] = Uuid::generate()->string;
        $tmp[self::REPORT_ID] = 'Gen-' . str_pad(($initialCount + $i + 1), 6, 0, STR_PAD_LEFT);
        $tmp[self::NAME] = $users[array_rand($users, 1)];
        $tmp[self::CUSTOMER] = '訪問先' . ($initialCount + $i + 1);
        $tmp[self::VISIT_DATE_TIME] = date('Y-m-d H:00:00', (time() - $period*24*60*60) + rand(9, 18)*60*60);
        $tmp[self::NEXT_DATE_TIME] = date('Y-m-d H:00:00', (time() - ($period - 1)*24*60*60) + rand(9, 18)*60*60);
        $tmp[self::STATUS] = $status[array_rand($status, 1)];
        $tmp[self::RANK] = rand(1, 5);
        $tmp[self::CREATED_AT] = date('Y-m-d H:i:s');
        $tmp[self::UPDATED_AT] = date('Y-m-d H:i:s');
        $tmp[self::CREATED_BY] = \Auth::user()->id;
        $tmp[self::UPDATED_BY] = \Auth::user()->id;
        $generates[] = $tmp;
      }
      $model = new static();
      $model->insert($generates);
      return static::all();
    }

    public static function recordset()
    {
      $records = static::all();
      $ret = [];
      foreach($records as $record) {
        $ret[] = $record->toArray();
      }
      return $ret;
    }
}

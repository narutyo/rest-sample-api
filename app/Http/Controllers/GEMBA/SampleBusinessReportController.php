<?php

namespace App\Http\Controllers\GEMBA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SampleBusinessReport;

class SampleBusinessReportController extends Controller
{
  public function index(Request $request)
  {
    $page = $request->get('targetPage', 1);
    $query = $this->search($request);
    $reports = $query->orderBy('reportId')
                     ->limit(25)
                     ->offset(($page - 1) * 25)
                     ->get();
    $ret = array();
    foreach($reports as $report) {
      $ret[] = array(
        SampleBusinessReport::REPORT_ID => $report->{SampleBusinessReport::REPORT_ID},
        SampleBusinessReport::NAME => $report->{SampleBusinessReport::NAME},
        SampleBusinessReport::CUSTOMER => $report->{SampleBusinessReport::CUSTOMER},
        SampleBusinessReport::VISIT_DATE_TIME => $report->{SampleBusinessReport::VISIT_DATE_TIME},
        SampleBusinessReport::NEXT_DATE_TIME => $report->{SampleBusinessReport::NEXT_DATE_TIME},
        SampleBusinessReport::STATUS => $report->{SampleBusinessReport::STATUS},
        SampleBusinessReport::RANK => $report->{SampleBusinessReport::RANK},
      );
    }
    return array(
      'keys'  => [
        SampleBusinessReport::REPORT_ID,
        SampleBusinessReport::NAME,
        SampleBusinessReport::CUSTOMER,
        SampleBusinessReport::VISIT_DATE_TIME,
        SampleBusinessReport::NEXT_DATE_TIME,
        SampleBusinessReport::STATUS,
        SampleBusinessReport::RANK,
      ],
      'records' => $ret,
    );
  }

  public function record_count(Request $request)
  {
    $query = $this->search($request);
    return array(
      'keys'  => [
        'count',
      ],
      'records' => [
        [ 'count' => $query->count() ]
      ],
    );
  }

  public function search($request)
  {
    $query = new SampleBusinessReport;
    if ($request->get('name')) $query = $query->where(SampleBusinessReport::NAME, $request->get('name'));
    if ($request->get('visitDateMin')) $query = $query->where(SampleBusinessReport::VISIT_DATE_TIME, '>=', $request->get('visitDateMin'));
    if ($request->get('visitDateMax')) $query = $query->where(SampleBusinessReport::VISIT_DATE_TIME, '<=', $request->get('visitDateMax'));
    return $query;
  }

  public function names(Request $request)
  {
    $data = SampleBusinessReport::select(SampleBusinessReport::NAME)
                 ->groupBy(SampleBusinessReport::NAME)
                 ->orderBy(SampleBusinessReport::NAME, 'asc')
                 ->get();
    $ret = [];
    foreach($data as $v) {
      $ret[][SampleBusinessReport::NAME] = $v->{SampleBusinessReport::NAME};
    }
    return array(
      'keys'  => [
        SampleBusinessReport::NAME,
      ],
      'records' => $ret,
    );
  }

  public function find($report)
  {
    $obj = SampleBusinessReport::where('reportId', $report)->first();
    return array(
      'keys' => [
        SampleBusinessReport::REPORT_ID,
        SampleBusinessReport::NAME,
        SampleBusinessReport::CUSTOMER,
        SampleBusinessReport::VISIT_DATE_TIME,
        SampleBusinessReport::NEXT_DATE_TIME,
        SampleBusinessReport::STATUS,
        SampleBusinessReport::RANK,
      ],
      'records' => [
        [
          SampleBusinessReport::REPORT_ID => $report,
          SampleBusinessReport::NAME => optional($obj)->{SampleBusinessReport::NAME},
          SampleBusinessReport::CUSTOMER => optional($obj)->{SampleBusinessReport::CUSTOMER},
          SampleBusinessReport::VISIT_DATE_TIME => optional($obj)->{SampleBusinessReport::VISIT_DATE_TIME},
          SampleBusinessReport::NEXT_DATE_TIME => optional($obj)->{SampleBusinessReport::NEXT_DATE_TIME},
          SampleBusinessReport::STATUS => optional($obj)->{SampleBusinessReport::STATUS},
          SampleBusinessReport::RANK => optional($obj)->{SampleBusinessReport::RANK},
        ]
      ],
    );
}

  public function store(Request $request)
  {
    $obj = new SampleBusinessReport;
    $obj->bulkStore($request->all());
    return;
  }
}

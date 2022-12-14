<?php

namespace App\Http\Controllers\GEMBA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SampleBusinessReport;

class SampleBusinessReportController extends Controller
{
  public function index(Request $request)
  {
    $reports = SampleBusinessReport::orderBy('reportId')->get();
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

  public function store(Request $request)
  {
    $obj = new SampleBusinessReport;
    $obj->bulkStore($request->all());
    return;
  }
}

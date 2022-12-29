<?php

namespace App\Http\Controllers\API\Sample;

use App\Http\Controllers\API\ApiBaseController;
use App\Http\Requests\API\Sample\BusinessReportRequest;
use App\Http\Requests\API\Sample\BusinessReportAggregateRequest;
use Illuminate\Http\Request;
use App\Events\Notification;
use App\Models\SampleBusinessReport;
use Illuminate\Support\Facades\Log;

class BusinessReportController extends ApiBaseController
{
    public function aggregate(BusinessReportAggregateRequest $request)
    {
      Log::info('Start aggregate BusinessReportData');
      try{
        $validated = $request->validated();
        list($y, $m) = explode('-', $validated['period']);
        if (!$y || !$m) {
          $y = date('Y');
          $m = date('n');
        }
        $reports = SampleBusinessReport::aggregate($y, $m);
        Log::info('Aggregate BusinessReportData success');

        return $this->success(
          'aggregate_businessReportData',
          'BusinessReportData aggregate successfully',
          $this->apiSpecBaseUrl . '/aggregate_businessReportData',
          $request,
          count($reports),
          $reports
        );
      } catch (\Throwable $e) {
        return $this->sendError($e->getMessage(), 500);
      }
    }

    public function suggest(Request $request)
    {
      $fields = $request->has('fields') ? $request->get('fields') : [];
      $data = $this->search($request->all(), $fields)
                   ->select($fields)
                   ->groupBy('name')
                   ->get();
      Log::info('Get industry company success');
      return $this->success(
          'company_master',
          'Retrieved successfully',
          $this->apiSpecBaseUrl . '/company_master',
          $request,
          $data->count(),
          $data->toArray()
      );
    }

    public function generate(BusinessReportRequest $request)
    {
      Log::info('Start generate BusinessReportData');
      try{
        $reports = SampleBusinessReport::generate($request->validated());
        Log::info('Generate BusinessReportData success');

        return $this->success(
          'generate_businessReportData',
          'BusinessReportData generated successfully',
          $this->apiSpecBaseUrl . '/generate_businessReportData',
          $request,
          collect([$reports])->count(),
          $reports->toArray()
        );
      } catch (\Throwable $e) {
        return $this->sendError($e->getMessage(), 500);
      }
    }

    public function truncate(Request $request)
    {
      Log::info('Start truncate SampleBusinessReport');
      try{
        $businessReport = SampleBusinessReport::truncate();
        Log::info('Truncate SampleBusinessReport success');
        event(new Notification());

        return $this->success(
          'truncat_sampleBusinessReport',
          'SampleBusinessReport truncated successfully',
          $this->apiSpecBaseUrl . '/truncate_sampleBusinessReport',
          $request,
          collect([$businessReport])->count(),
          []
        );
      } catch (\Throwable $e) {
        return $this->sendError($e->getMessage(), 500);
      }
    }

    protected function model()
    {
      return SampleBusinessReport::class;
    }

    protected function getTypeIndex($request)
    {
      return $this->apiSpecBaseUrl . '/get_SampleBusinessReport';
    }

    protected function getTypeShow()
    {
      return $this->apiSpecBaseUrl . '/get_SampleBusinessReport';
    }

    protected function getTypeDestroy()
    {
      return $this->apiSpecBaseUrl . '/delete_SampleBusinessReport';
    }
    
    protected function search($criteria, $fields)
    {
      $data = $this->model->search($criteria);
      if (!empty($criteria['filter_name'])) {
        $data = $data->where(SampleBusinessReport::NAME, 'like', '%' . $criteria['filter_name'] . '%');
      }
      if (!empty($criteria['visit_start'])) {
        $data = $data->whereDate(SampleBusinessReport::VISIT_DATE_TIME, '>=', $criteria['visit_start']);
      }
      if (!empty($criteria['visit_end'])) {
        $data = $data->whereDate(SampleBusinessReport::VISIT_DATE_TIME, '<=', $criteria['visit_end']);
      }
      return $data;
    }
}

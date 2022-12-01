<?php

namespace App\Http\Controllers\API\Sample;

use App\Http\Controllers\API\ApiBaseController;
use Illuminate\Http\Request;
use App\Models\RssSample;
use Illuminate\Support\Facades\Log;

class RssController extends ApiBaseController
{
    protected function model()
    {
      return RssSample::class;
    }

    protected function getTypeIndex($request)
    {
      return $this->apiSpecBaseUrl . '/get_RssSample';
    }

    protected function getTypeShow()
    {
      return $this->apiSpecBaseUrl . '/get_RssSample';
    }

    protected function getTypeDestroy()
    {
      return $this->apiSpecBaseUrl . '/delete_RssSample';
    }

    protected function search($criteria, $fields)
    {
      $data = $this->model->search($criteria);
      if (!empty($criteria['filter_title'])) {
        $data = $data->where('title', 'like', '%'.$criteria['filter_title'].'%');
      }
      return $data;
    }
}

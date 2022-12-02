<?php

namespace App\Http\Controllers\API\Note;

use App\Http\Controllers\API\ApiBaseController;
use App\Http\Requests\API\Note\TemplateMasterRequest;
use App\Models\NoteTemplateMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TemplateMasterController extends ApiBaseController
{
    public function store(TemplateMasterRequest $request){
      Log::info('Start create NoteTemplate');
      try{
        $template = NoteTemplateMaster::add($request->validated());
        Log::info('Create NoteTemplate success');

        return $this->success(
          'create_noteTemplate',
          'NoteTemplate saved successfully',
          $this->apiSpecBaseUrl . '/create_noteTemplate',
          $request,
          collect([$template])->count(),
          $template->toArray()
        );
      } catch (\Throwable $e) {
        return $this->sendError($e->getMessage(), 500);
      }
    }

    public function update(NoteTemplateMaster $note_template, TemplateMasterRequest $request)
    {
      Log::info('Start update NoteTemplate');
      try {
        $template = NoteTemplateMaster::edit($request->validated(), $note_template);
        Log::info('Update NoteTemplate success');

        return $this->success(
          'update_noteTemplate',
          'NoteTemplate updated successfully',
          $this->apiSpecBaseUrl . '/update_noteTemplate',
          $request,
          collect([$template])->count(),
          $template->toArray()
        );
      } catch (\Throwable $e) {
        return $this->sendError($e->getMessage(), 500);
      }
    }

    public function destroy(NoteTemplateMaster $note_template, Request $request)
    {
      Log::info('Start delete NoteTemplate');
      try {
        // ToDo: 作成済ノートが存在する場合のエラー処理を追加
        $note_template->delete();

        Log::info('delete SurveyItem success');
        return $this->success(
          'delete_noteTemplate',
          'NoteTemplate delete successfully',
          $this->apiSpecBaseUrl . '/delete_noteTemplate',
          $request,
          collect([$note_template])->count(),
          $note_template->toArray()
        );
      } catch (\Throwable $e) {
        return $this->sendError($e->getMessage(), 500);
      }
    }

    protected function model()
    {
      return NoteTemplateMaster::class;
    }

    protected function getTypeIndex($request)
    {
      return $this->apiSpecBaseUrl . '/get_NoteTemplateMaster';
    }

    protected function getTypeShow()
    {
      return $this->apiSpecBaseUrl . '/get_NoteTemplateMaster';
    }

    protected function getTypeDestroy()
    {
      return $this->apiSpecBaseUrl . '/delete_NoteTemplateMaster';
    }

    protected function search($criteria, $fields)
    {
      $data = $this->model->search($criteria);
      if (!empty($criteria['filter_name'])) {
        $data = $data->where('name', 'like', '%'.$criteria['filter_name'].'%');
      }
      return $data;
    }
}

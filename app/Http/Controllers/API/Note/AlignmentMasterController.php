<?php

namespace App\Http\Controllers\API\Note;

use App\Http\Controllers\API\ApiBaseController;
use App\Http\Requests\API\Note\AlignmentMasterRequest;
use App\Models\NoteAlignmentMaster;
use App\Models\NoteTemplateMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


use App\Models\RssSample;

class AlignmentMasterController extends ApiBaseController
{
    public function store(AlignmentMasterRequest $request){
      Log::info('Start create NoteTemplate');
      try{
        $template = NoteAlignmentMaster::add($request->validated());
        Log::info('Create NoteTemplate success');

        return $this->success(
          'create_noteAlignment',
          'NoteAlignment saved successfully',
          $this->apiSpecBaseUrl . '/create_noteAlignment',
          $request,
          collect([$template])->count(),
          $template->toArray()
        );
      } catch (\Throwable $e) {
        return $this->sendError($e->getMessage(), 500);
      }
    }

    public function update(NoteAlignmentMaster $note_alignment, AlignmentMasterRequest $request)
    {
      Log::info('Start update NoteTemplate');
      try {
        $template = NoteAlignmentMaster::edit($request->validated(), $note_alignment);
        Log::info('Update NoteTemplate success');

        return $this->success(
          'update_noteAlignment',
          'NoteAlignment updated successfully',
          $this->apiSpecBaseUrl . '/update_noteAlignment',
          $request,
          collect([$template])->count(),
          $template->toArray()
        );
      } catch (\Throwable $e) {
        return $this->sendError($e->getMessage(), 500);
      }
    }

    public function destroy(NoteAlignmentMaster $note_alignment, Request $request)
    {
      Log::info('Start delete NoteTemplate');
      try {
        $note_alignment->delete();

        Log::info('delete SurveyItem success');
        return $this->success(
          'delete_noteAlignment',
          'NoteAlignment delete successfully',
          $this->apiSpecBaseUrl . '/delete_noteAlignment',
          $request,
          collect([$note_alignment])->count(),
          $note_alignment->toArray()
        );
      } catch (\Throwable $e) {
        return $this->sendError($e->getMessage(), 500);
      }
    }

    public function callback(Request $request)
    {
      Log::info('Start accept callback');
      try {
        $tmpParam = $request->all();
        $param =  (!is_array($tmpParam)) ? $tmpParam : $tmpParam[0];
        $note_alignment = NoteAlignmentMaster::where('uuid', $param['internal_id'])->first();
        if (!is_object($note_alignment)) abort(404);
        
        $note_alignment->note_uri = $param['noteid'];
        $note_alignment->save();

        Log::info('Accept callback success');
        return true;
      } catch (\Throwable $e) {
        abort(500);
      }
    }

    public function supply_info(Request $request)
    {
      Log::info('Start accept supplyInfo');
      try {
        $ret = array();
        $ret['completedAt'] = time();

        Log::info('Accept supplyInfo success');
        // return response()->json([])->withHeaders($ret);
        echo http_build_query($ret);
      } catch (\Throwable $e) {
        abort(500);
      }
    }

    public function recordset(Request $request)
    {
      Log::info('Start accept recordset response');
      try {
        $ret = array();
        $records = RssSample::all();
        foreach($records as $record) {
          $ret[] = array(
            'title' => $record->title,
            'attention' => $record->attention,
            'importance'  => $record->importance,
          );
        }

        Log::info('Response recordset success');
        return $ret;
      } catch (\Throwable $e) {
        abort(500);
      }
    }

    protected function model()
    {
      return NoteAlignmentMaster::class;
    }

    protected function getTypeIndex($request)
    {
      return $this->apiSpecBaseUrl . '/get_noteAlignmentMaster';
    }

    protected function getTypeShow()
    {
      return $this->apiSpecBaseUrl . '/get_noteAlignmentMaster';
    }

    protected function getTypeDestroy()
    {
      return $this->apiSpecBaseUrl . '/delete_noteAlignmentMaster';
    }

    protected function search($criteria, $fields)
    {
      $with = [
        NoteAlignmentMaster::NOTE_TEMPLATE_MASTER  => function($query) {
          $query->with([
            NoteTemplateMaster::NOTE_TEMPLATE_TAG_PARAMS
          ]);
        }
      ];
      $with = $this->mapSearchableFieldsToRelation($with, $fields);
      return $this->model->search($criteria)
                  ->with($with);
    }
}

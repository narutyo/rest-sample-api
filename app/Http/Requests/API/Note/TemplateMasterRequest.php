<?php

namespace App\Http\Requests\API\Note;

use App\Http\Requests\API\BaseRequest;
use App\Models\NoteTemplateMaster;

class TemplateMasterRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
          NoteTemplateMaster::NAME => 'required',
          NoteTemplateMaster::TEMPLATE_ID => 'required',
          NoteTemplateMaster::FOLDER_URI => 'required',
          NoteTemplateMaster::RECORDSET_MODEL => 'sometimes',
          NoteTemplateMaster::RECORDSET_PAGE_TEMPLATE_ID => 'sometimes',
          NoteTemplateMaster::RECORDSET_TAGNAME_SPACE => 'sometimes',
          'createParams'  => 'sometimes|array', // リレーション
          'supplyParams'  => 'sometimes|array', // リレーション
        ];
        return $rules;
    }

    public function messages()
    {
      return [
      ];
    }
}

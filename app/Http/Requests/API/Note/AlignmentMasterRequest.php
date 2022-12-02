<?php

namespace App\Http\Requests\API\Note;

use App\Http\Requests\API\BaseRequest;
use App\Models\NoteAlignmentMaster;

class AlignmentMasterRequest extends BaseRequest
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
          NoteAlignmentMaster::NAME => 'required',
          NoteAlignmentMaster::NOTE_TEMPLATE_MASTER_ID => 'sometimes|required',
        ];
        return $rules;
    }

    public function messages()
    {
      return [
      ];
    }
}

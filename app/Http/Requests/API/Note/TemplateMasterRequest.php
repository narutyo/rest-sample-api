<?php

namespace App\Http\Requests\API\Note;

use App\Http\Requests\API\BaseRequest;
use App\Models\NoteTemplateMaster;
use Illuminate\Foundation\Http\FormRequest;

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
        ];
        return $rules;
    }

    public function messages()
    {
      return [
      ];
    }
}

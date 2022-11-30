<?php

namespace App\Http\Requests\API\Admin;

use App\Http\Requests\API\BaseRequest;
use App\Models\SurveyMaster;
use Illuminate\Foundation\Http\FormRequest;

class SurveyMasterRequest extends BaseRequest
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
            SurveyMaster::TITLE => 'required',
            SurveyMaster::DESCRIPTION => 'max:60',
            //
        ];
        return $rules;
    }

    public function messages()
    {
      return [
      ];
    }
}

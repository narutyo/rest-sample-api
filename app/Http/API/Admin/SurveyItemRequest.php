<?php

namespace App\Http\Requests\API\Admin;

use App\Http\Requests\API\BaseRequest;
use App\Models\SurveyItem;
use Illuminate\Foundation\Http\FormRequest;

class SurveyItemRequest extends BaseRequest
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
            SurveyItem::UUID => 'sometimes| required|',
            SurveyItem::TITLE => 'sometimes| required|',
            SurveyItem::EXPLANATION => 'max:100',
            SurveyItem::SURVEY_MASTER_ID => 'sometimes| required|',
            SurveyItem::ANSWER_OPTION_MASTER_ID => 'sometimes| required|',
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

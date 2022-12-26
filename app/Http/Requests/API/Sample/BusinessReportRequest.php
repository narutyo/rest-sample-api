<?php

namespace App\Http\Requests\API\Sample;

use App\Http\Requests\API\BaseRequest;
use App\Models\NoteAlignmentMaster;

class BusinessReportRequest extends BaseRequest
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
          'users' => 'required|array',
          'range' => 'required',
          'count' => 'required|integer',
        ];
        return $rules;
    }

    public function messages()
    {
      return [
      ];
    }
}

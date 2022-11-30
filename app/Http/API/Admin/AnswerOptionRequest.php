<?php

namespace App\Http\Requests\API\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\API\BaseRequest;
use App\Models\AnswerOption;

class AnswerOptionRequest extends BaseRequest
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
            AnswerOption::UUID => 'required',
            AnswerOption::TITLE => 'max:60',
        ];
        return $rules;
    }
}

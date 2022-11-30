<?php

namespace App\Http\Requests\API\Admin;

use App\Http\Requests\API\BaseRequest;
use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends BaseRequest
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
            Company::NAME => 'required',
            Company::INDUSTRIES => 'required',
            Company::HEAD_COUNT => 'required',
        ];
        return $rules;
    }

    public function messages()
    {
      return [
      ];
    }
}

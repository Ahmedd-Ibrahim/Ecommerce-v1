<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class languageRequests extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:100',
            'abbr' => 'required|string|max:10',
//            'active' => 'required|in:0,1',
            'direction' => 'required|in:rtl,ltr',


        ];
    }
    public function messages()
    {
        return [
            'required' => 'هذا الحقل مطلوب',
            'string' => 'أسم اللغة لابد أن يكون احرف',
            'name.max' => 'أسم اللغة لابد الا يزيد عن 100 حرف',
            'abbr.max' => 'أسم اللغة لابد الا يزيد عن 10 حرف',
            'in'=>            'القيم غير صحيحة'
        ];
    }
}

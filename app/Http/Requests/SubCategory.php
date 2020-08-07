<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubCategory extends FormRequest
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
           'photo' => 'required_without:id|mimes:jpg,png,jpeg',
            'category'=> 'required|array|min:1',
            'category.*.name' =>'required|string|max:100',

            'category.*.abbr' =>'required',
            'parent' =>'required|integer',


        ];
    }
    public function messages()
    {
        return [
            'required' => 'هذا الحقل مطلوب',
            'string' => 'أسم القسم لابد أن يكون احرف',
            'name.max' => 'أسم القسم لابد الا يزيد عن 100 حرف',
            'abbr.max' => 'أسم اللغة لابد الا يزيد عن 10 حرف',
            'photo.mimes'=>    'فقط يسمح بالامتدادات التالية:jpg , png, jpeg',
            'parent.integer' => 'من فضلك أختار القسم الرئيسي ',
        ];
    }
}

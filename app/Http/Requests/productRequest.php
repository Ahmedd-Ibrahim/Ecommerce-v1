<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class productRequest extends FormRequest
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
            'category'=> 'required|integer',
            'vendor' => 'required|integer',
            'product.*.name' => 'required|string|max:100',
            'count' => 'required|integer',
        ];
    }
    public function messages()
    {
        return [
            'required' => 'هذا الحقل مطلوب',
            'string' => 'أسم القسم لابد أن يكون احرف',
            'photo.mimes'=>    'فقط يسمح بالامتدادات التالية:jpg , png, jpeg',
            'integer' => 'رجاء اختر',
            'photo.required_without' => 'رجاء اختر الصورة المناسبة',
            'product.*.required' => 'هناك خطأ ما فى هذا الحقل'
        ];
    }
}

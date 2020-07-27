<?php

namespace App\Http\Requests;

use http\Env\Request;
use Illuminate\Foundation\Http\FormRequest;

class vendorsRequest extends FormRequest
{
    /**
     * @var mixed
     */
    /**
     * @var mixed
     */



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
            "name"=> "required",
            "category_id"=> "required|int",
            "mobile"=> "required|unique:vendors,mobile,".$this->id,
            "address"=> "required|string|max:100",
            "email"=> "required_without:id|email|unique:vendors,email,".$this->id,
            "logo" => "mimes:jpg,png,jpeg",
            "password" => "required_without:id",


        ];
    }
    public function messages()
    {
        return [
            "required" => "هذا الحقل مطلوب",
            "category_id.integer"=> "من فضلك ادخل القسم",
            "email.email" => "ادخل البريد الاكتروني صحيح",
            "logo.mimes"=> "فقط الصيغ المسموح بها (jpg,png,jpeg) ",
            "email.unique"=> "هذا الاميل موجود بالفعل",

        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordUserRequest extends FormRequest
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
            'password' => ['required','min:8','max:100','confirmed'],
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'password.required' => "Mật khẩu không được để trống!",
            'password.min' => "Mật khẩu phải từ 8 kí tự trở lên",
            'password.max' => "Mật khẩu không được quá 100 kí tự",
            'password.confirmed' => "Nhập lại mật khẩu phải trùng nhau",
        ];
    }
}

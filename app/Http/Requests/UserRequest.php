<?php

namespace App\Http\Requests;

use App\Domains\Auth\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use LangleyFoxall\LaravelNISTPasswordRules\PasswordRules;

class UserRequest extends FormRequest
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
            'name' => ['required', 'max:100'],
            'email' => ['required', 'max:255', 'email', Rule::unique('users')],
            'password' => ['required','min:8','max:100','confirmed'],
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => "Họ tên không được để trống!",
            'name.max' => "Họ tên không được quá 100 kí tự",
            'email.required' => "Email không được để trống!",
            'email.max' => "Email không được quá 255 kí tự",
            'email.email' => "Nhập đúng dạng email",
            'email.unique' => "Email đã tồn tại",
            'password.required' => "Mật khẩu không được để trống!",
            'password.min' => "Mật khẩu phải từ 8 kí tự trở lên",
            'password.max' => "Mật khẩu không được quá 100 kí tự",
            'password.confirmed' => "Nhập lại mật khẩu phải trùng nhau",
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'email' => ['required', 'max:255', 'email', 'unique:users,email,' . $this->id]
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
        ];
    }
}

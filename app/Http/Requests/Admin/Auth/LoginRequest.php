<?php

namespace App\Http\Requests\Admin\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email'    => 'required|email',
            'password' => 'required|max:8|min:8',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput()
            ->with('flashError', 'Đăng nhập thất bại');
    }
}

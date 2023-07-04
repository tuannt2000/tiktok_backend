<?php

namespace App\Http\Requests\Admin\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'password'    => 'required|max:8|min:8|same:re-password',
            're-password' => 'required|max:8|min:8',
            'token'       => ''
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput()
            ->with('flashError', 'Đổi mật khẩu thất bại');
    }
}

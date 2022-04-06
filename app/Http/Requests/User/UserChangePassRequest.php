<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserChangePassRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_pass' => 'required|min:8|max:100',
            'password' => 'required|min:8|max:100',
            're_password' => 'required|min:8|max:100|same:password',
        ];
    }

    public function attributes()
    {
        return [
            'old_pass' => 'Old password',
            'password' => 'New password',
            're_password' => 'Confirm passowrd',
        ];
    }
}

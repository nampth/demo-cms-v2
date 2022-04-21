<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
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
            'id' => 'required|numeric',
            'password' => 'nullable|min:8|max:100',
            // 're_password' => 'nullable|min:8|max:100|same:password',
            'name' => 'required|max:100',
            'role' => 'required|numeric'
        ];
    }

    public function attributes()
    {
        return [
            'id' => 'ID',
            'password' => 'Password',
            // 're_password' => 'Confirm password',
            'name' => 'Fullname',
            'role' => 'Role'
        ];
    }
}

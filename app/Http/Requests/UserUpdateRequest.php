<?php

namespace Ancora\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$this->route('user')->id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$this->route('user')->id,
            'password' => 'string|min:6|confirmed',
            'roles' => 'required',
        ];
    }

    /**
     * Override: Get all of the input and files for the request.
     *
     * @param  array|mixed  $keys
     * @return array
     */
    public function all($keys = null)
    {
        $attributes = parent::all($keys);

        if(!$attributes['password'])
            unset($attributes['password']);

        if(!$attributes['password_confirmation'])
            unset($attributes['password_confirmation']);

        return $attributes;
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('user_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        if (request()->routeIs('users.store')) {

            $passwordRule = ['required', 'confirmed'];
            $emailRule = ['required', 'unique:users'];

        } elseif (request()->routeIs('users.update')) {

            $passwordRule = ['sometimes', 'confirmed'];
            $emailRule = ['required', Rule::unique('users')->ignore($this->user->id)];

        }

        return [
            'name' => ['required'],
            'email' => $emailRule,
            'password' => $passwordRule,
            'phone_number' => ['required'],
            'function' => ['required'],
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->password == null) {
            $this->request->remove('password');
        }
    }

    public function failedValidation(Validator $validator)
    {
        dd($validator->errors());
    }
}

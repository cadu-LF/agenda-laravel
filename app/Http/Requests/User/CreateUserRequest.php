<?php

namespace App\Http\Requests\User;

use Waavi\Sanitizer\Laravel\FormRequest;
use Waavi\Sanitizer\Laravel\SanitizesInput;

class CreateUserRequest extends FormRequest
{
    use SanitizesInput;

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
     *  Validation rules to be applied to the input.
     *
     *  @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6'
        ];
    }

    /**
     *  Filters to be applied to the input.
     *
     *  @return array
     */
    public function filters()
    {
        return [
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => 'Email precisa ser inserido',
            'email.email' => 'O campo deve ser preenchido com um email válido',
            'email.unique' => 'Email já cadastrado',
            'name.required' => 'Nome precisa ser inserido',
            'password.required' => 'Senha precisa ser inserida',
            'password.min' => 'Senha precisa ter pelo menos 6 caracteres',
            'password.confirmed' => 'Senha precisa ser confirmada',
        ];
    }
}

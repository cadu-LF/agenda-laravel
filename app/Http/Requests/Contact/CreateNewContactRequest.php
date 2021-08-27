<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;
use Waavi\Sanitizer\Laravel\SanitizesInput;

class CreateNewContactRequest extends FormRequest
{
    use SanitizesInput;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     *  Validation rules to be applied to the input.
     *
     *  @return array
     */
    public function rules()
    {
        return [
            'fullName' => 'required',
            'phone' => 'required',
            'email' => 'nullable',
            'note' => 'nullable',
            'description' => 'required',
            'cep' => 'required|min:8|max:9',
            'number' => 'required',
            'street' => 'required',
            'neighborhood' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required'
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
            'phone' => 'trim',
            'email' => 'trim',
            'cep' => 'trim'
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
            'fullName.required' => 'É preciso inserir um nome',
            'phone.required' => 'É preciso inserir um telefone',
            'description.required' => 'É preciso informar a categoria do contato',
            'cep.required' => 'O campo CEP deve ser informado',
            'number.required' => 'É preciso informar o número da casa do contato',
            'street.required' => 'É preciso informar o nome da rua do contato',
            'neighborhood.required' => 'É preciso informar o nome do bairro do contato',
            'city.required' => 'É preciso informar a cidade do contato',
            'state.required' => 'É preciso informar o estado do contato',
            'country.required' => 'É preciso informar o país do contato'
        ];
    }
}

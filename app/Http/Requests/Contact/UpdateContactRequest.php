<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;
use Waavi\Sanitizer\Laravel\SanitizesInput;

class UpdateContactRequest extends FormRequest
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
     * 4,5 -> 5,5 -> 6,5
     *  @return array
     */
    public function rules()
    {
        return [
            'id_contact' => 'required',
            'fullname' => 'required',
            'phone' => 'required',
            'email' => 'nullable',
            'note' => 'nullable',
            'category' => 'required',
            'cep' => 'required|min:8|max:8',
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
            'id_category' => 'id_category needded',
            'description.required' => 'É preciso informar a categoria do contato',
            'id_address' => 'id_address needded',
            'cep.required' => 'O campo CEP deve ser informado',
            'number.required' => 'É preciso informar o número da casa do contato',
            'country.required' => 'É preciso informar o país do contato'
        ];
    }
}

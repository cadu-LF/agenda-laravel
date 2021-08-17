@extends('layout')

@section('headding')
Editar Contato
@endsection

@section('content')
<form>
    @include('components.form-group-edit', ['labelName' => 'Nome',
                                            'inputValue' => 'Cadu Lourenco',
                                            'name' => 'fullName'
                                        ])
    @include('components.form-group-edit', ['labelName' => 'Telefone',
                                            'inputValue' => '123456',
                                            'name' => 'phone'
                                        ])
    @include('components.form-group-edit', ['labelName' => 'Anotacoes',
                                            'inputValue' => 'note',
                                            'name' => 'note'
                                        ])
    @include('components.form-group-edit', ['labelName' => 'Categoria',
                                            'inputValue' => 'player',
                                            'name' => 'category'
                                        ])
    @include('components.form-group-edit', ['labelName' => 'CEP',
                                            'inputValue' => '14401378',
                                            'name' => 'cep'
                                        ])
    @include('components.form-group-edit', ['labelName' => 'Número',
                                            'inputValue' => '1123',
                                            'name' => 'number'
                                        ])
    @include('components.form-group-edit', ['labelName' => 'Rua',
                                            'inputValue' => 'dr jorge',
                                            'name' => 'street'
                                        ])
    @include('components.form-group-edit', ['labelName' => 'Bairro',
                                            'inputValue' => 'santo',
                                            'name' => 'neighborhood'
                                        ])
    @include('components.form-group-edit', ['labelName' => 'Cidade',
                                            'inputValue' => 'Franca',
                                            'name' => 'city'
                                        ])
    @include('components.form-group-edit', ['labelName' => 'Estado',
                                            'inputValue' => 'SP',
                                            'name' => 'state'
                                        ])
    @include('components.form-group-edit', ['labelName' => 'País',
                                            'inputValue' => 'Brasil',
                                            'name' => 'country'
                                        ])
    <button class='btn btn-success mb-3 ' type='submit'>Salvar Contato</button>
</form>
@endsection

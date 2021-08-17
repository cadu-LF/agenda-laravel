@extends('layout')

@section('headding')
Cadastre-se no gerenciador de contatos
@endsection

@section('content')
@include('components.alert', ['errors', $errors ])
<form action="{{ route('login.store') }}" method='post'>
    @csrf
    @include('components.form-group', ['labelName' => 'Nome de usuário',
                                        'type' => 'text',
                                        'name' => 'name'
                                    ])
    @include('components.form-group', ['labelName' => 'Email',
                                        'type' => 'email',
                                        'name' => 'email'
                                    ])
    @include('components.form-group', ['labelName' => 'Senha',
                                        'type' => 'password',
                                        'name'=>'password'
                                    ])
    <button class='btn btn-success' type='submit'>Enviar</button>
</form>
@endsection

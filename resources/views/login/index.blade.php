@extends('layout')

@section('headding')
Login
@endsection

@section('content')
<form>
    @include('components.form-group', ['labelName' => 'Email', 'type' => 'email', 'name'=>'email'])
    @include('components.form-group', ['labelName' => 'Senha', 'type' => 'password', 'name'=>'password'])
</form>
    <div class='d-flex'>
        <button class='btn btn-primary' type='submit'>Entrar</button>
        <a href='/login/create' class='btn btn-secondary ml-3'>Registrar-se</a>
    </div>
@endsection

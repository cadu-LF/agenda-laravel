@extends('layout')

@section('menu')
    <a></a>
    <a class='btn btn-secondary' href="{{ route('logout') }}"
        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
        {{ __('Logout') }}
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
        </form>
@endsection

@section('headding')
Lista de contatos
@endsection

@section('content')
    <h1>Faz busca</h1>
    <a href='/contatos/create' class='btn btn-success mb-3'>Adicionar novo contato</a>
    <ul class='list-group'>
        @foreach ($contacts as $contact)
            <li class='list-group-item mb-1 d-flex justify-content-between'>
                <a href="contatos/{{$contact->id}}/edit">{{$contact->fullname}}</a>
                <a href="contatos/{{$contact->id}}/edit">{{$contact->phone}}</a>
                <a href="contatos/{{$contact->id}}/edit">{{$contact->id_category}}</a>
            </li>
        @endforeach
    </ul>
@endsection

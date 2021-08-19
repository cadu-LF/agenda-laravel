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
Lista de contatos {{$search}}
@endsection

@section('content')
    <form method='get' class='mb-5 d-flex'>
        <input class='form-control mb-2' placeholder='Pesquise aqui' name='search'/>
        <button class='btn btn-primary ml-5'>Pesquisar</button>
    </form>
    <a href='/contatos/create' class='btn btn-success mb-3'>Adicionar novo contato</a>
    <ul class='list-group'>
        @foreach ($contacts as $contact)
            <li class='list-group-item mb-1 d-flex justify-content-between'>
                <a href="contatos/{{$contact['id']}}/edit">{{$contact['fullname']}}</a>
                <a href="contatos/{{$contact['id']}}/edit">{{$contact['phone']}}</a>
                <a href="contatos/{{$contact['id']}}/edit">{{$contact['id_category']}}</a>
                <form action="{{route('contatos.destroy', $contact['id'])}}" method='post'>
                    @method('DELETE')
                    @csrf
                    <button class='btn btn-danger' type='submit'>
                        Deletar contato: {{$contact['fullname']}}
                    </button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection

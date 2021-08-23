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
    <div class='d-flex justify-content-between mb-3'>
        <span></span>
        <div>
            <a href="{{route('import.contacts')}}" class='btn btn-secondary'>Importar Contatos</a>
            <a href="{{route('contatos.pdf')}}" class='btn btn-secondary'>Gerar PDF</a>
            <a href="{{route('contatos.excel')}}" class='btn btn-secondary'>Gerar Planilha Excel</a>
        </div>
    </div>
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
                @if($contact['id_category'] > 0)
                    <a href="contatos/{{$contact['id']}}/edit">{{$categories[$contact['id_category'] - 1 ]['description']}}</a>
                @endif

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

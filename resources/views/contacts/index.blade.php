@extends('layout')

@section('head')
<!-- OneSignal -->
<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
window.OneSignal = window.OneSignal || [];
OneSignal.push(function() {
    OneSignal.init({
    appId: "73280275-d25a-4f0b-b17a-7a662db82682",
    safari_web_id: "web.onesignal.auto.69735df3-8f8c-40d7-a01f-205a16828de8",
    notifyButton: {
        enable: true,
    },
    allowLocalhostAsSecureOrigin: true,
    welcomeNotification: {
                "title": "Bem vindo!",
                "message": "Seja bem vindo ao Gerenciador de Contatos",
                // "url": "" /* Leave commented for the notification to not open a window on Chrome and Firefox (on Safari, it opens to your webpage) */
            },
    });
});
</script>
@endsection

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
    <form>
        <input class='form-control mb-2 typeahead' type='text' placeholder='Pesquise aqui'/>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js" integrity="sha512-HWlJyU4ut5HkEj0QsK/IxBCY55n5ZpskyjVlAoV9Z7XQwwkqXoYdCIC93/htL3Gu5H3R4an/S0h2NXfbZk3g7w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
        var path = "{{route('autocomplete')}}";
        $('input.typeahead').typeahead({
            source:function(terms, process){
                return $.get(path, {terms:terms}, function(data){
                    return process(data);
                });
            }
        });

    </script>
@endsection

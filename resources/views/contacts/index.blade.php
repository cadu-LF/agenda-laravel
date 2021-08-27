@extends('layout')

@section('head')
<!-- Autocomplete -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

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
    <div>
        <div class="form-group">
            <form class='mb-5 d-flex'>
                <input type="text" name="search" id="name" class="form-control mb-2" placeholder="Buscar nome" />
                <button class='btn btn-primary ml-5' type='submit'>Buscar</button>
            </form>
            <div id="nameList">
            </div>
        </div>
    {{ csrf_field() }}
    </div>
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
    <script>
$(document).ready(function(){

 $('#name').keyup(function(){
        var query = $(this).val();
        if(query != '')
        {
         var _token = $('input[name="_token"]').val();
         $.ajax({
          url:"{{ route('autocomplete') }}",
          method:"POST",
          data:{query:query, _token:_token},
          success:function(data){
           $('#nameList').fadeIn();
                    $('#nameList').html(data);
          }
         });
        }
    });

    $(document).on('click', 'li', function(){
        $('#name').val($(this).text());
        $('#nameList').fadeOut();
    });

});
</script>
@endsection

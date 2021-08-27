@extends('layout')

@section('headding')
Editar Contato {{$contact['fullname']}}
@endsection

@include('components.alert', ['errors', $errors ])
@section('content')
<form action="{{ route('contatos.update', $contact['id']) }}" method='post'>
    @method('PUT')
    @csrf

    <input
        hidden
        value="{{$contact['id']}}"
        name='id_contact'
    />

    <div class='mb-3'>
        <label class='form-label'>Nome</label>
        <input
            class='form-control'
            value={{$contact['fullname']}}
            name='fullname'
            type='text'
        />
    </div>
    <div class='mb-3'>
        <label class='form-label'>Telefone</label>
        <input
            class='form-control'
            value="{{$contact['phone']}}"
            name='phone'
            type='text'
            id='phone'
        />
    </div>
    <div class='mb-3'>
        <label class='form-label'>Email</label>
        <input
            class='form-control'
            value="{{$contact['email']}}"
            name='email'
            type='email'
        />
    </div>
    <div class='mb-3'>
        <label class='form-label'>Anotação</label>
        <input
            class='form-control'
            value="{{$contact['note']}}"
            name='note'
            type='text'
        />
    </div>

    <input
        hidden
        value="{{$contact['id_category']}}"
        name='id_category'
    />

    <div class='mb-3'>
        <label class='form-label'>Categoria</label>
        <input
            class='form-control'
            value="{{$category['description']}}"
            name='category'
            type='text'
        />
    </div>

    <input
        hidden
        value="{{$contact['id_address']}}"
        name='id_address'
    />

    <div class='mb-3'>
        <label class='form-label'>CEP</label>
        @if($address['cep'] != null)
        <input
            class='form-control'
            type='text'
            value={{$address['cep']}}
            onblur="pesquisacep(this.value);"
            onkeypress="mascaraCep(this, '#####-###')"
            name='cep'
            id='cep'
        />
        @else
        <input
            class='form-control'
            type='text'
            value=''
            onblur="pesquisacep(this.value);"
            onkeypress="mascaraCep(this, '#####-###')"
            name='cep'
            id='cep'
        />
        @endif
    </div>
    <div class='mb-3'>
        <label class='form-label'>Número</label>
        <input
            class='form-control'
            value="{{$address['number']}}"
            name='number'
            id='number'
            type="number"
        />
    </div>
    <div class='mb-3'>
        <label class='form-label'>Rua</label>
        <input
            class='form-control'
            value="{{$address['street']}}"
            name='street'
            id='rua'
            type='text'
        />
    </div>
    <div class='mb-3'>
        <label class='form-label'>Bairro</label>
        <input
            class='form-control'
            value="{{$address['neighborhood']}}"
            name='neighborhood'
            id='bairro'
            type='text'
        />
    </div>
    <div class='mb-3'>
        <label class='form-label'>Cidade</label>
        <input
            class='form-control'
            value="{{$address['city']}}"
            name='city'
            id='cidade'
            type='text'
        />
    </div>
    <div class='mb-3'>
        <label class='form-label'>Estado</label>
        <input
            class='form-control'
            value="{{$address['state']}}"
            name='state'
            id='uf'
            type='text'
        />
    </div>
    <div class='mb-3'>
        <label class='form-label'>País</label>
        @if($address['country'] == null)
        <input
            class='form-control'
            value=""
            name='country'
            type='text'
            />
        @else
        <input
            class='form-control'
            value="{{$address['country']}}"
            name='country'
            type='text'
        />
        @endif
    </div>

    <button class='btn btn-success mb-3 ' type='submit'>Salvar Contato</button>
</form>
@endsection

<script>

function limpa_formulário_cep() {
        //Limpa valores do formulário de cep.
        document.getElementById('rua').value=("");
        document.getElementById('bairro').value=("");
        document.getElementById('cidade').value=("");
        document.getElementById('uf').value=("");
}

function meu_callback(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('rua').value=(conteudo.logradouro);
        document.getElementById('bairro').value=(conteudo.bairro);
        document.getElementById('cidade').value=(conteudo.localidade);
        document.getElementById('uf').value=(conteudo.uf);
    } //end if.
    else {
        //CEP não Encontrado.
        limpa_formulário_cep();
        alert("CEP não encontrado.");
    }
}

function pesquisacep(valor) {

    //Nova variável "cep" somente com dígitos.
    var cep = valor.replace(/\D/g, '');

    //Verifica se campo cep possui valor informado.
    if (cep != "") {

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if(validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            document.getElementById('rua').value="...";
            document.getElementById('bairro').value="...";
            document.getElementById('cidade').value="...";
            document.getElementById('uf').value="...";

            //Cria um elemento javascript.
            var script = document.createElement('script');

            //Sincroniza com o callback.
            script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);

        } //end if.
        else {
            //cep é inválido.
            limpa_formulário_cep();
            alert("Formato de CEP inválido.");
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
        limpa_formulário_cep();
    }
};

    /* Máscaras ER */
    function mascara(o,f){
        v_obj=o
        v_fun=f
        setTimeout("execmascara()",1)
    }
    function execmascara(){
        v_obj.value=v_fun(v_obj.value)
    }
    function mtel(v){
        v=v.replace(/\D/g,""); //Remove tudo o que não é dígito
        v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
        v=v.replace(/(\d)(\d{4})$/,"$1-$2"); //Coloca hífen entre o quarto e o quinto dígitos
        return v;
    }
    function id( el ){
        return document.getElementById( el );
    }
    window.onload = function(){
        id('phone').onkeyup = function(){
            mascara( this, mtel );
        }
        id('cep').onkeyup = function(){
            mascaraCep(this, mtel)
        }
    }

    function mascaraCep(t, mask){
        var i = t.value.length;
        var saida = mask.substring(1,0);
        var texto = mask.substring(i)
        if (texto.substring(0,1) != saida){
            t.value += texto.substring(0,1);
        }
    }

</script>

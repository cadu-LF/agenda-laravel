@extends('layout')

@section('headding')
Editar Contato {{$contact->data->fullname}}
@endsection

@include('components.alert', ['errors', $errors ])
@section('content')
<form action="{{ route('contatos.update', $contact->data->id) }}" method='post'>
    @method('PUT')
    @csrf

    <input
        hidden
        value="{{$contact->data->id}}"
        name='id_contact'
    />

    <div class='mb-3'>
        <label class='form-label'>Nome</label>
        <input
            class='form-control'
            value={{$contact->data->fullname}}
            name='fullname'
            type='text'
        />
    </div>
    <div class='mb-3'>
        <label class='form-label'>Telefone</label>
        <input
            class='form-control'
            value="{{$contact->data->phone}}"
            name='phone'
            type='text'
        />
    </div>
    <div class='mb-3'>
        <label class='form-label'>Anotação</label>
        @if($contact->data->note == null)
            <input
                class='form-control'
                value=''
                name='note'
                type='text'
            />
        @else
            <input
                class='form-control'
                value="{{$contact->data->note}}"
                name='note'
                type='text'
            />
        @endif
    </div>

    <input
        hidden
        value="{{$contact->data->id_category}}"
        name='id_category'
    />

    <div class='mb-3'>
        <label class='form-label'>Categoria</label>
        <input
            class='form-control'
            value="{{$category->data->description}}"
            name='category'
            type='text'
        />
    </div>

    <input
        hidden
        value="{{$contact->data->id_address}}"
        name='id_address'
    />

    <div class='mb-3'>
        <label class='form-label'>CEP</label>
        <input
            class='form-control'
            type='text'
            value={{$address->data->cep}}
            onblur="pesquisacep(this.value);"
            name='cep'
            id='cep'
        />
    </div>
    <div class='mb-3'>
        <label class='form-label'>Número</label>
        @if($address->data->number == null)
        <input
            class='form-control'
            value=''
            name='number'
            type="number"
        />
        @else
        <input
            class='form-control'
            value={{$address->data->number}}
            name='number'
            type="number"
        />
        @endif
    </div>
    <div class='mb-3'>
        <label class='form-label'>Rua</label>
        <input
            class='form-control'
            value="{{$address->data->street}}"
            name='street'
            id='rua'
            type='text'
        />
    </div>
    <div class='mb-3'>
        <label class='form-label'>Bairro</label>
        <input
            class='form-control'
            value="{{$address->data->neighborhood}}"
            name='neighborhood'
            id='bairro'
            type='text'
        />
    </div>
    <div class='mb-3'>
        <label class='form-label'>Cidade</label>
        <input
            class='form-control'
            value="{{$address->data->city}}"
            name='city'
            id='cidade'
            type='text'
        />
    </div>
    <div class='mb-3'>
        <label class='form-label'>Estado</label>
        <input
            class='form-control'
            value="{{$address->data->state}}"
            name='state'
            id='uf'
            type='text'
        />
    </div>
    <div class='mb-3'>
        <label class='form-label'>País</label>
        @if($address->data->country == null)
        <input
            class='form-control'
            value=""
            name='country'
            type='text'
            />
        @else
        <input
            class='form-control'
            value="{{$address->data->country}}"
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

</script>

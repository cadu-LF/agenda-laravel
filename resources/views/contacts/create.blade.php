@extends('layout')

@section('headding')
Criar novo contato
@endsection

@include('components.alert', ['errors', $errors ])
@section('content')
<form action="{{ route('contatos.store') }}" method='post'>
    @csrf
    @include('components.form-group', ['labelName' => 'Nome Completo',
                                        'type' => 'text',
                                        'name' => 'fullName'
                                    ])
    @include('components.form-group', ['labelName' => 'Telefone',
                                        'type' => 'text',
                                        'name' => 'phone'
                                    ])
    @include('components.form-group', ['labelName' => 'Anotações',
                                        'type' => 'text',
                                        'name' => 'note'
                                    ])
    @include('components.form-group', ['labelName' => 'Email',
                                        'type' => 'email',
                                        'name' => 'email'
                                    ])
    @include('components.form-group', ['labelName' => 'Categoria',
                                        'type' => 'text',
                                        'name' => 'description'])
    <div class='mb-3'>
        <label class='form-label'>CEP</label>
        <input
            class='form-control'
            type='text'
            value=''
            onblur="pesquisacep(this.value);"
            name='cep'
            id='cep'
        />
    </div>

    @include('components.form-group', ['labelName' => 'Número',
                                        'type' => 'number',
                                        'name' => 'number'
                                    ])
    <div class='mb-3'>
        <label class='form-label'>Rua</label>
        <input class='form-control' type='text' name='street' id='rua'/>
    </div>

    <div class='mb-3'>
        <label class='form-label'>Bairro</label>
        <input class='form-control' type='text' name='neighborhood' id='bairro'/>
    </div>

    <div class='mb-3'>
        <label class='form-label'>Cidade</label>
        <input class='form-control' type='text' name='city' id='cidade'/>
    </div>

    <div class='mb-3'>
        <label class='form-label'>Estado</label>
        <input class='form-control' type='text' name='state' id='uf'/>
    </div>
    <div class='mb-3'>
        <label class='form-label'>País</label>
        <input class='form-control' type='text' name='country' id='pais'/>
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

function toggleButton(){
    let x = document.getElementById('hide/show')
    if(x.style.display === 'none'){
        x.style.display = 'block'
    }else{
        x.style.display = 'none'
    }
}

</script>

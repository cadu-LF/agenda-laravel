<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Controle de Contatos</title>

    <style>
        .jumbotron{
            font-size:64px;
        }

        .contact-name{
            font-size: 32px;
            font-weight: bold;
        }

        .mb-20{
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
        <table>
            <tr>
                <th>Name</th>
                <th>Telefone</th>
                <th>Email</th>
                <th>Anotações</th>
                <th>Id do Usuário</th>
                <th>Id do endereco</th>
                <th>Id da categoria</th>
                <th>Criado em</th>
                <th>Atualizado em</th>
            </tr>
            @foreach($contacts as $contact)
            <tr>
                <th>{{$contact->fullname}}</th>
                <th>{{$contact->phone}}</th>
                <th>{{$contact->email}}</th>
                <th>{{$contact->note}}</th>
                <th>{{$contact->id_user}}</th>
                <th>{{$contact->id_address}}</th>
                <th>{{$contact->id_category}}</th>
                <th>{{$contact->created_at}}</th>
                <th>{{$contact->updated_at}}</th>
            </tr>
            @endforeach
        </table>
</body>
</html>

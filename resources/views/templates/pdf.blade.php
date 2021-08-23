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
    <div class="container">
        <nav class='nav-bar d-flex justify-content-between'>

        </nav>
        <header>
        </header>
        <main>
        <ul>
            @foreach ($contacts as $contact)
            <div class='mb-20'>
                <li class='contact-name'>{{$contact['fullname']}}</li>
                <li>Telefone: {{$contact['phone']}}</li>
            </div>
            @endforeach
        </ul>
        </main>
    </div>
</body>
</html>

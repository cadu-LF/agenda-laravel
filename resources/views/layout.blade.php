<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Controle de Contatos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    @yield('head')
</head>
<body>
    <div class="container">
        <nav class='nav-bar d-flex justify-content-between'>
            @yield('menu')
        </nav>
        <header>
            <div class="jumbotron">
                <h1>@yield('headding')</h1>
            </div>
        </header>
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>

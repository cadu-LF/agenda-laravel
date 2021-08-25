<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Controle de Contatos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
                    "title": "Jesus, Eu não acredito que deu certo",
                    "message": "Chupa Sociedade, essa bagaça funcionou!!",
                    // "url": "" /* Leave commented for the notification to not open a window on Chrome and Firefox (on Safari, it opens to your webpage) */
                },
        });
    });
    </script>
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

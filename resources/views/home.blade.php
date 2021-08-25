@extends('layouts.app')
@section('head')
<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
    <script>
        window.OneSignal = window.OneSignal || [];
        OneSignal.push(function() {
            OneSignal.init({
                appId: "55fb2487-34f5-413c-87c0-9e7614d9225d",
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
@endsection
@section('content')
<h1>h1</h1>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

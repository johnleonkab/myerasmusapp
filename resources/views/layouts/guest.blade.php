<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <script type="module" src="https://cdn.jsdelivr.net/npm/@ionic/core/dist/ionic/ionic.esm.js"></script>
    <script nomodule src="https://cdn.jsdelivr.net/npm/@ionic/core/dist/ionic/ionic.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ionic/core/css/ionic.bundle.css" />
    <link rel="stylesheet" href="{{ asset('css/ionic.css') }}">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @laravelPWA
</head>
<body>
    <ion-app>

        <ion-header translucent>
          <ion-toolbar>
            <livewire:logo>
            <ion-buttons slot="end">
              <ion-button>
                <ion-icon slot="icon-only" name="contact"></ion-icon>
                </ion-button>
              </ion-buttons>
          </ion-toolbar>
        </ion-header>
    
        <ion-content class="main-content">
            @yield('content')
        </ion-content>
      </ion-app>

</body>
</html>
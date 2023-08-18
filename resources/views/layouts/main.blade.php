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
    <link rel="stylesheet" href="{{ asset('css/icofont.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icofont.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@icon/icofont@1.0.1-alpha.1/icofont.min.css">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <script src="
https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.min.js
"></script>
<link href="
https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.min.css
" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/heatmap.js/2.0.0/heatmap.js" integrity="sha512-XZFexJzmhuGGou+I1Qp82iKps7LHXkQ6QQ7ueOyMpX24l7WlBVv4I1ECLFv/xozVf0cPIn70ZnXCt5V37uZUWg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"
/>

<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    @laravelPWA

</head>
<body>
    <ion-app>
        <ion-header translucent>
          <ion-toolbar>
      
            <ion-title class="font-quicksand">MyErasmus App</ion-title>
            <ion-buttons slot="end">
              <ion-button>
                <ion-icon slot="icon-only" name="contact"></ion-icon>
                </ion-button>
              </ion-buttons>
          </ion-toolbar>
        </ion-header>
    
        <ion-content class="main-content">
            <style>
                .example-content {
                  display: flex;
                  align-items: center;
                  justify-content: center;
                  height: 100%;
                }
              </style>
              <ion-tabs>
                <ion-tab tab="home">
                  <ion-nav id="home-nav"></ion-nav>
                  <div id="home-page">
                    <ion-content>
                        <ion-refresher id="home-page-refresher" slot="fixed">
                            <ion-refresher-content></ion-refresher-content>
                          </ion-refresher>
                      <div class="home-page-content">
                        {!! App\Http\Controllers\FeedController::index() !!}

                      </div>
                    </ion-content>
                    <script>
                      
                    </script>
                  </div>
                </ion-tab>
                <ion-tab tab="places">
                  <ion-nav id="places-nav"></ion-nav>
                  <div id="places-page">
                    <ion-content>
                    <div class="places-page-content">
                      {!! App\Http\Controllers\PlacesController::index() !!}
                    </div>
                  </ion-content>
                  </div>
                </ion-tab>
                <ion-tab tab="saved">
                  <ion-nav id="saved-nav"></ion-nav>
                  <div id="saved-page">
                    <ion-content>
                      <ion-refresher id="saved-page-refresher" slot="fixed">
                          <ion-refresher-content></ion-refresher-content>
                        </ion-refresher>
                    <div class="saved-page-content">
                      
                    </div>
                  </ion-content>
                  </div>
                </ion-tab>
                <ion-tab tab="me">
                  <ion-nav id="me-nav"></ion-nav>
                  <div id="me-page">
                    <ion-content>
                        <ion-refresher id="me-page-refresher" slot="fixed">
                            <ion-refresher-content></ion-refresher-content>
                          </ion-refresher>
                      <div class="me-page-content">Me</div>
                    </ion-content>
                  </div>
                </ion-tab>
                <ion-tab-bar slot="bottom">
                  <ion-tab-button tab="home" onclick="$('#home-page .home-page-content').load('{{ url('feed') }}')">
                    <ion-icon name="home"></ion-icon>
                    Inicio
                  </ion-tab-button>
                  <ion-tab-button tab="places" onclick="$('#places-page .places-page-content').load('{{ url('places/index') }}')">
                    <ion-icon name="location-outline"></ion-icon>
                    Lugares
                  </ion-tab-button>
                  <ion-tab-button tab="saved" onclick="$('#saved-page .saved-page-content').load('{{ url('feed/saved') }}')">
                    <ion-icon name="bookmark-outline"></ion-icon>
                    Guardado
                  </ion-tab-button>
                  <ion-tab-button tab="me" onclick="$('#me-page .me-page-content').load('{{ url('me') }}')">
                    <ion-icon name="person-circle-outline"></ion-icon>
                    Yo
                  </ion-tab-button>
                </ion-tab-bar>
              </ion-tabs>
              

              <ion-toast
            trigger="open-stacked-toasts"
            duration="3000"
            layout="stacked"></ion-toast>
              <script>
                const homeNav = document.querySelector('#home-nav');
                const homePage = document.querySelector('#home-page');
                homeNav.root = homePage;
              
                const placesNav = document.querySelector('#places-nav');
                const placesPage = document.querySelector('#places-page');
                placesNav.root = placesPage;
              
                const savedNav = document.querySelector('#saved-nav');
                const savedPage = document.querySelector('#saved-page');
                savedNav.root = savedPage;
              
                const meNav = document.querySelector('#me-nav');
                const mePage = document.querySelector('#me-page');
                meNav.root = mePage;
              </script>
        </ion-content>
      </ion-app>

      <script>
        // Query for the toggle that is used to change between themes



const prefersDark = window.matchMedia('(prefers-color-scheme: dark)');

toggleDarkTheme(prefersDark.matches);

// Listen for changes to the prefers-color-scheme media query
prefersDark.addEventListener('change', (mediaQuery) => toggleDarkTheme(mediaQuery.matches));

// Add or remove the "dark" class based on if the media query matches
function toggleDarkTheme(shouldAdd) {
  document.body.classList.toggle('dark', shouldAdd);
}


//cambiar a load only inside page
const mePageRefresher = document.getElementById('me-page-refresher');

mePageRefresher.addEventListener('ionRefresh', () => {
    $('#me-page .me-page-content').load('{{ url('me') }}', function() {
        mePageRefresher.complete();
    })
});

const homePageRefresher = document.getElementById('home-page-refresher');

homePageRefresher.addEventListener('ionRefresh', () => {
    $('#home-page .home-page-content').load('{{ url('feed') }}', function() {
        homePageRefresher.complete();
    })
});

const savedPageRefresher = document.getElementById('saved-page-refresher');

savedPageRefresher.addEventListener('ionRefresh', () => {
    $('#saved-page .saved-page-content').load('{{ url('feed/saved') }}', function() {
      savedPageRefresher.complete();
    })
});



      </script>
</body>
</html>
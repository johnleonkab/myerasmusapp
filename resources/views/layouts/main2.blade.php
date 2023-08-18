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
    @laravelPWA
    <script src="{{ asset('js/firebase.js') }}" type="module"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/heatmap.js/2.0.0/heatmap.js" integrity="sha512-XZFexJzmhuGGou+I1Qp82iKps7LHXkQ6QQ7ueOyMpX24l7WlBVv4I1ECLFv/xozVf0cPIn70ZnXCt5V37uZUWg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
</head>
<body>
    <style>
  .example-content {
    align-items: center;
    justify-content: center;
    height: 100%;
  }
</style>
<ion-app>
    <ion-header translucent>
      <ion-toolbar>
  
        <ion-title class="font-quicksand">
            <div class="flex">
                <img src="{{ asset('images/logo-icon.png') }}" class="h-8 mr-2" alt="">
                <h1 class="my-auto">MyErasmus App</h1>
            </div>
        </ion-title>
        <ion-buttons slot="end">
          <ion-button>
            <ion-icon slot="icon-only" name="contact"></ion-icon>
            </ion-button>
          </ion-buttons>
      </ion-toolbar>
    </ion-header>

    <ion-content class="main-content">

        <ion-tabs id="main-tabs">
            <ion-tab tab="home">
              <ion-nav id="home-nav"></ion-nav>
              <div id="home-page">
                <ion-content>
                    <ion-title class="my-4">{{ __('main.navigation.Feed') }}</ion-title>

                    <ion-refresher id="home-refresher" slot="fixed">
                        <ion-refresher-content></ion-refresher-content>
                      </ion-refresher>
                  <div class="example-content home-page-content">
                    {!! App\Http\Controllers\FeedController::index() !!}
                  </div>
                </ion-content>
              </div>
            </ion-tab>
            <ion-tab tab="places">
              <ion-nav id="places-nav"></ion-nav>
              <div id="places-page">
                <ion-content>
                  <div class="example-content places-page-content">
                    {!! App\Http\Controllers\PlacesController::index() !!}
                  </div>
                </ion-content>
              </div>
            </ion-tab>
            <ion-tab tab="saved">
              <ion-nav id="saved-nav"></ion-nav>
              <div id="saved-page">
                <ion-content>
                    <ion-title class="my-4">{{ __('main.navigation.Saved') }}</ion-title>
                    <ion-refresher id="saved-refresher" slot="fixed">
                        <ion-refresher-content></ion-refresher-content>
                      </ion-refresher>
                  <div class="example-content saved-page-content">
                    {!! App\Http\Controllers\FeedController::SavedFeedPage() !!}
                  </div>
                </ion-content>
              </div>
            </ion-tab>
            <ion-tab tab="me">
              <ion-nav id="me-nav"></ion-nav>
              <div id="me-page">
                <ion-content>
                    <ion-refresher id="me-refresher" slot="fixed">
                        <ion-refresher-content></ion-refresher-content>
                      </ion-refresher>
                  <div class="example-content me-page-content">
                    {!! App\Http\Controllers\UserController::ShowMyProfile() !!}
                  </div>
                </ion-content>
              </div>
            </ion-tab>
            <ion-tab-bar slot="bottom">
              <ion-tab-button tab="home">
                <ion-icon name="play-circle"></ion-icon>
                {{ __('main.navigation.Feed') }}
              </ion-tab-button>
              <ion-tab-button tab="places">
                <ion-icon name="location-outline"></ion-icon>
                {{ __('main.navigation.Places') }}
              </ion-tab-button>
              <ion-tab-button tab="saved">
                <ion-icon name="bookmark-outline"></ion-icon>
                {{ __('main.navigation.Saved') }}
              </ion-tab-button>
              <ion-tab-button tab="me">
                <ion-icon name="person-circle-outline"></ion-icon>
                {{ __('main.navigation.Me') }}
              </ion-tab-button>
            </ion-tab-bar>
          </ion-tabs>
    </ion-content>
</ion-app>



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


<script>
    const homeRefresher = document.getElementById('home-refresher');
    homeRefresher.addEventListener('ionRefresh', () => {
        $('#home-page .home-page-content').load('{{ url('feed') }}', function(){
            homeRefresher.complete();
        });
    });


    const savedRefresher = document.getElementById('saved-refresher');
    savedRefresher.addEventListener('ionRefresh', () => {
        $('#saved-page .saved-page-content').load('{{ url('feed/saved') }}', function(){
            savedRefresher.complete();
        });
    });


    const meRefresher = document.getElementById('me-refresher');
    meRefresher.addEventListener('ionRefresh', () => {
        $('#me-page .me-page-content').load('{{ url('me') }}', function(){
            meRefresher.complete();
        });
    });
  </script>

<script>
    document.getElementById('main-tabs').addEventListener('ionTabsWillChange', function(event){
        switch (event.detail.tab) {
            case 'places':
                $('#places-page .places-page-content').load('{{ url('places/index') }}')
                break;
        
            default:
                break;
        }
    })
</script>
</body>
</html>
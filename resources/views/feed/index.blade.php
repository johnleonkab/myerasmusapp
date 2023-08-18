@component('components.toast')@endcomponent

{{-- <ion-searchbar show-clear-button="focus" value="Show on Focus" class="rounded-lg rounded-searchbar"></ion-searchbar> --}}

{{-- @component('feed.components.category-selector')
    
@endcomponent --}}

    <div id="entries-list">
      {!! App\Http\Controllers\FeedController::LoadFeed(new Illuminate\Http\Request(['skip' => 0])) !!}
    </div>
    <div class="text-center">
      <ion-spinner id="spinner" name="crescent"></ion-spinner>
    </div>

    <script>

                      var skip = 0
                      
                      function loadResults(skip, category) {
                        $.get('{{ url("feed/feed") }}?skip='+skip+"&category="+category, function(data){
                                  content= data;
                                  $('#entries-list').append(content);
                              });
                      }


                      function onVisible(element, category) {
                        new IntersectionObserver((entries, observer) => {
                          entries.forEach(entry => {
                            if(entry.intersectionRatio > 0) {
                              console.log("it's visible");
                              console.log(skip)

                              loadResults(skip, category)
                              skip = skip+10
                            }
                          });
                        }).observe(element);
                      }
                      onVisible(document.querySelector("#spinner"), "");



    </script>


  <ion-fab slot="fixed" vertical="bottom" class="fixed " horizontal="end">
    <ion-fab-button>
        <i class="icofont-plus-circle text-2xl"></i>
    </ion-fab-button>
    <ion-fab-list side="top">
        @component('livewire.modal')
            @slot('buttonClass', 'bg-gray-200 dark:bg-gray-700 absolute h-10 w-10 rounded-full')
            @slot('button')
            <i class="icofont-calendar"></i>
            @endslot
            @slot('title', __('main.feed.New Event'))
            @slot('url', url('feed/new-event'))
        @endcomponent
        @component('livewire.modal')
            @slot('buttonClass', 'bg-gray-200 dark:bg-gray-700 absolute h-10 w-10 bottom-16 rounded-full')
            @slot('button')
            <i class="icofont-megaphone"></i>
            @endslot
            @slot('title', __('main.feed.New Thread'))
            @slot('url', url('feed/new-thread'))
        @endcomponent
  </ion-fab>
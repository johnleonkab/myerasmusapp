@component('components.toast')@endcomponent

{{-- @component('feed.components.category-selector')
    
@endcomponent --}}

    <div id="saved-entries-list">

    </div>
    <div class="text-center">
      <ion-spinner id="saved-spinner" name="crescent"></ion-spinner>
    </div>

    <script>

                      var skip = 0
                      
                      function loadResults(skip, category) {
                        $.get('{{ url("feed/saved/feed") }}?skip='+skip+"&category="+category, function(data){
                                  content= data;
                                  $('#saved-entries-list').append(content);
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
                      onVisible(document.querySelector("#saved-spinner"), "");



    </script>

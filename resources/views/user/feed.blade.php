@php
    $element_id = 'user-feed-'.rand(1000000, 9999999);
@endphp
<div id="user-entries-list{{$element_id}}">

</div>
<div class="text-center">
  <ion-spinner id="user-entries-spinner{{$element_id}}" name="crescent"></ion-spinner>
</div>

<script>

                  var skip = 0
                  
                  function loadUserFeed(skip, category) {
                    $.get('{{ url("user/feed") }}?skip='+skip+"&user={{ $user->unid }}", function(data){
                              content= data;
                              $('#user-entries-list{{$element_id}}').append(content);
                          });
                  }


                  function onVisible(element, category) {
                    new IntersectionObserver((entries, observer) => {
                      entries.forEach(entry => {
                        if(entry.intersectionRatio > 0) {
                          console.log("it's visible");
                          console.log(skip)

                          loadUserFeed(skip, category)
                          skip = skip+10
                        }
                      });
                    }).observe(element);
                  }
                  onVisible(document.querySelector("#user-entries-spinner{{$element_id}}"), "");



</script>
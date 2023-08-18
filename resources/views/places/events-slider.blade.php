
<div class="swiper fixed left-0 w-screen " style="z-index:999;position:fixed;bottom:0;left:0;width:100vw">
    <!-- Additional required wrapper -->
    <div class="swiper-wrapper fixed bottom-0 left-0" style="z-index:99999">

          
   
  
  
  </div>
  </div>
  <script>
    var swiper = new Swiper('.swiper', {
    // Optional parameters
    direction: 'horizontal',
    loop: false,

  });

  function loadEvents(skip){
    $.get('{{ url("places/load-events") }}?skip='+skip, function(data){
        content= data;
        console.log(data)
        for (var i=0; i<data.length; i++) {

            $.get('{{ url("places/event-card") }}'+'?event='+data[i].event_slug, function(html){
                var container = $("<div>").addClass("swiper-slide");
                container.html(html)
                swiper.appendSlide(container)
            })
            console.log(data[i].event_slug)
        }

    });
                      
  }

loadEvents(0)


  </script>
@php
    $element_id = 'like-'.rand(10000,999999);
@endphp
<div class="flex align-middle mr-auto">
    <button id="{{ $element_id }}" class="@if(App\Models\Action::where('action', 'like')->where('target_type', $type)->where('target_id', $target_id)->where('user_id', Auth::user()->id)->get()->count() > 0) liked @endif transition text-xl" onclick="like('{{$type}}', '{{$slug}}',   '{{$element_id}}' )"><i class="icofont-heart"></i></button>
    <span id="{{ $element_id }}-counter" class="my-auto">{{ App\Models\Action::where('action', 'like')->where('target_type', $type)->where('target_id', $target_id)->get()->count() }}</span>
</div>
<script>
    function like(type, slug, id){            
            var data = new FormData()
            data.append('type', type)
            data.append('_token', '{{ csrf_token() }}')
            data.append('slug', slug)
          
            fetch("{{ url('feed/like') }}", {
            method: "POST",
            body: data,
          })
            .then((response) => response.json())
            .then((json) => {
              console.log(json);
              if(json.status == 'success'){
                console.log('success')
                console.log(id)
                $('#'+id).addClass("liked");
                try {
                  var likes = parseInt(document.getElementById(id+'-counter').innerHTML)
                  document.getElementById(id+'-counter').innerHTML = likes+1
                } catch (error) {
                    
                }
              }


              try {
                toast.isOpen = true;
              toast.message = json.message;
              setTimeout(() => {
                toast.isOpen = false;
              }, 3000);
          
          
              } catch (error) {
                
              }
            })
    }
</script>
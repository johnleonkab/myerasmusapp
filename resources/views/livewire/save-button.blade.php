@php
    $component_id = 'save-'.rand(10000,999999);
@endphp
<div class="flex align-middle mx-auto">
    <button id="save{{ $component_id }}" class="@if(App\Models\Action::where('action', 'save')->where('target_type', $type)->where('target_id', $target_id)->where('user_id', Auth::user()->id)->get()->count() > 0) hidden @endif transition text-xl" onclick="save('{{$type}}', '{{$slug}}',   '{{$component_id}}' )"><i class="icofont-book-mark"></i></button>
    <button id="unsave{{ $component_id }}" class="@if(App\Models\Action::where('action', 'save')->where('target_type', $type)->where('target_id', $target_id)->where('user_id', Auth::user()->id)->get()->count() == 0) hidden @endif saved  transition text-xl" onclick="unsave('{{$type}}', '{{$slug}}',   '{{$component_id}}' )"><i class="icofont-book-mark"></i></button>
</div>
<script>
    function save(type, slug, id){        
        document.getElementById('save'+id).classList.add("hidden");
    
            var data = new FormData()
            data.append('type', type)
            data.append('_token', '{{ csrf_token() }}')
            data.append('slug', slug)
          
            fetch("{{ url('feed/save') }}", {
            method: "POST",
            body: data,
          })
            .then((response) => response.json())
            .then((json) => {
              console.log(json);
              if(json.status == 'success'){
                console.log('success')
                console.log(id)
                document.getElementById('save'+id).classList.add("hidden");
                document.getElementById('unsave'+id).classList.remove("hidden");
                try {
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


    function unsave(type, slug, id){            
            var data = new FormData()
            data.append('type', type)
            data.append('_token', '{{ csrf_token() }}')
            data.append('slug', slug)
          
            fetch("{{ url('feed/unsave') }}", {
            method: "POST",
            body: data,
          })
            .then((response) => response.json())
            .then((json) => {
              console.log(json);
              if(json.status == 'success'){
                console.log('success')
                console.log(id)
                document.getElementById('unsave'+id).classList.add("hidden");
                document.getElementById('save'+id).classList.remove("hidden");
                try {
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
@php
    $component_id = 'deletbutton'.rand(100000, 999999);
@endphp
@if (App\Models\FeedResult::where('slug', $result_slug)->where('owner_id', Auth::user()->id)->get()->first())
<button class="text-red-500 ml-auto" id="present-alert{{$component_id}}"><i class="icofont-trash text-lg"></i></button>
<ion-alert id="ion-alert{{$component_id}}" trigger="present-alert{{$component_id}}" header="{{ __('main.feed.Delete Element') }}" message="{{ __('main.feed.Are you sure?') }}"></ion-alert>
<p id="handlerResult{{$component_id}}"></p>
<p id="roleResult{{$component_id}}"></p>

<script>
  const handlerOutput{{$component_id}} = document.querySelector('#handlerResult{{$component_id}}');
  const roleOutput{{$component_id}} = document.querySelector('#roleResult{{$component_id}}');
  const alert{{$component_id}} = document.querySelector('#ion-alert{{$component_id}}');

  alert{{$component_id}}.buttons = [
    {
      text: 'Cancel',
      role: 'cancel',
      handler: () => {
      },
    },
    {
      text: '{{ __("main.feed.delete") }}',
      role: 'confirm',
      handler: () => {
        var data = new FormData()
        data.append('feed_result_slug', '{{ $result_slug }}')
        data.append('_token', '{{ csrf_token() }}')

        fetch("{{ url('feed/delete-result') }}", {
        method: "POST",
        body: data,
        })
        .then((response) => response.json())
        .then((json) => {
            console.log(json);
            if(json.status == 'success'){
                try {
                    toast.isOpen = true;
                    toast.message = json.message;
                    setTimeout(() => {
                        toast.isOpen = false;
                    }, 3000);
                } catch (error) {
                
                }
            }
        })
      },
    },
  ];

</script>

@endif
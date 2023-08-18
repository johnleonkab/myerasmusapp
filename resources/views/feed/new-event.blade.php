<div class="flex flex-col bg-white  shadow-sm rounded-xl dark:bg-zinc-800 ">
    <div class="p-4 md:p-5">
        
        <label for="event_image">
        <h4 class="input-label">{{ __('main.feed.Image') }}</h4>
        {{-- <form action="{{ url('feed/save-new-event') }}" method="POST" enctype="multipart/form-data"> --}}
            @csrf
        <img src="https://ionicframework.com/docs/img/demos/card-media.png" class="rounded-lg aspect-video object-cover" id="event_image_preview" alt="">
        {{ __('main.feed.Touch to Change') }}
        </label>
        <input type="file" name="event_image" class="invisible" id="event_image">
        <ion-input class="my-4" autocapitalize="on" label="{{ __('main.feed.Event Name') }}" name="name" label-placement="floating" id="name" fill="outline" placeholder="Enter text"></ion-input>

        <ion-textarea class="my-4" autocapitalize="on" label="{{ __('main.feed.Event Description') }}" id="description" name="description" label-placement="floating" fill="outline" placeholder="Enter text"></ion-textarea>
            

        <ion-input class="my-4" autocapitalize="on" name="venue" id="venue" label="{{ __('main.feed.Venue')." (".__('main.feed.optional').")" }}" label-placement="floating" fill="outline" placeholder="Enter text"></ion-input>


        <ion-select aria-label="" name="category" interface="action-sheet" id="category" placeholder="{{__('main.feed.Category') ." (".__('main.feed.optional').")"}}">
          @foreach (App\Models\Category::get() as $category)
          <ion-select-option value="{{ $category->slug }}">{{ __('main.feed.'.$category->slug)}}</ion-select-option>                    

          @endforeach                     
      </ion-select>


      <div class="my-5">
        <h4 class="input-label">{{ __('main.feed.Event Start') }}</h4>
        <ion-datetime name="start_datetime" id="start_datetime" value="@isset($stay->start_datetime){{\Carbon\Carbon::parse($stay->start_datetime)->format('Y-m-d')}}@else{{\Carbon\Carbon::now()->format('Y-m-d')}}@endisset"></ion-datetime>
      </div>
      <div class="my-5">
        <h4 class="input-label">{{ __('main.feed.Event End') }}</h4>
        <ion-datetime name="end_datetime" id="end_datetime" value="@isset($stay->end_datetime){{\Carbon\Carbon::parse($stay->end_datetime)->format('Y-m-d')}}@else{{\Carbon\Carbon::now()->format('Y-m-d')}}@endisset"></ion-datetime>
      </div>

      <div class="my-5">
        <ion-select aria-label="" name="public" interface="action-sheet" id="public" placeholder="{{__('main.feed.Visibility')}}">
                <ion-select-option value="1">{{ __('main.feed.public')}}</ion-select-option>                    
                <ion-select-option value="0">{{ __('main.feed.private')}}</ion-select-option>                    
          </ion-select>
      </div>
      <livewire:button-spinner text="{{ __('main.user.Save Changes') }}" javascript="saveEvent(this)">
    {{-- </form> --}}
    </div>
  </div>


  <script>
    var imgInp = document.getElementById('event_image')
    imgInp.onchange = evt => {
  const [file] = imgInp.files
  if (file) {
    document.getElementById('event_image_preview').src = URL.createObjectURL(file)
  }
}


  function saveEvent(that){

    var input = document.getElementById('event_image')

    var data = new FormData()
    data.append('event_image', input.files[0])
    data.append('name', document.getElementById('name').value)
    data.append('description', document.getElementById('description').value)
    data.append('venue', document.getElementById('venue').value)
    data.append('category', document.getElementById('category').value)
    data.append('start_datetime', document.getElementById('start_datetime').value)
    data.append('end_datetime', document.getElementById('end_datetime').value)
    data.append('public', document.getElementById('public').value)
    data.append('_token', '{{ csrf_token() }}')

    fetch("{{ url('feed/save-new-event') }}", {
    method: "POST",
    body: data,
    // JSON.stringify({
    //   name: document.getElementById('name').value,
    //   description: document.getElementById('description').value,
    //   venue: document.getElementById('venue').value,
    //   category: document.getElementById('category').value,
    //   start_datetime: document.getElementById('start_datetime').value,
    //   end_datetime: document.getElementById('end_datetime').value,
    //   public: document.getElementById('public').value,
    //   _token: '{{ csrf_token() }}',
    //   event_image: document.getElementById('event_image').value
    // }),


  })
    .then((response) => response.json())
    .then((json) => {
      console.log(json);
      if(json.status == 'success'){
        var modal = document.querySelector("#event_image").closest("ion-modal");
        modal.dismiss(null, 'cancel');
      }
      try {
        toast.isOpen = true;
      toast.message = json.message;
      setTimeout(() => {
        toast.isOpen = false;
        window.location.reload()
      }, 3000);


      } catch (error) {
        
      }
    })
    .then(function(json){
      that.querySelector('.spinner').classList.add('hidden');
      that.disabled =  false;
    });
  }
  </script>
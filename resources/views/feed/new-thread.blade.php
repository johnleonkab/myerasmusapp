<div class="flex flex-col bg-white  shadow-sm rounded-xl dark:bg-zinc-800 ">
  <div class="p-4 md:p-5">
      
      <label for="thread_image">
      <h4 class="input-label">{{ __('main.feed.Image') }}</h4>
      {{-- <form action="{{ url('feed/save-new-thread') }}" method="POST" enctype="multipart/form-data"> --}}
          @csrf
      <img src="https://ionicframework.com/docs/img/demos/card-media.png" class="rounded-lg aspect-video object-cover" id="thread_image_preview" alt="">
      {{ __('main.feed.Touch to Change') }}
      </label>
      <input type="file" name="thread_image" class="invisible" id="thread_image">
      <ion-input class="my-4" autocapitalize="on" label="{{ __('main.feed.Thread Name') }}" name="title" label-placement="floating" id="title" fill="outline" placeholder="Enter text"></ion-input>

      <ion-textarea class="my-4" autocapitalize="on" label="{{ __('main.feed.Thread Content') }}" id="content" name="content" label-placement="floating" fill="outline" placeholder="Enter text"></ion-textarea>
          




    <div class="my-5">
      <ion-select aria-label="" name="public" interface="action-sheet" id="public" placeholder="{{__('main.feed.Visibility')}}">
              <ion-select-option value="1">{{ __('main.feed.public')}}</ion-select-option>                    
              <ion-select-option value="0">{{ __('main.feed.private')}}</ion-select-option>                    
        </ion-select>
    </div>
    <livewire:button-spinner text="{{ __('main.user.Save Changes') }}" javascript="saveThread(this)">
  {{-- </form> --}}
  </div>
</div>


<script>
  var imgInp = document.getElementById('thread_image')
  imgInp.onchange = evt => {
const [file] = imgInp.files
if (file) {
  document.getElementById('thread_image_preview').src = URL.createObjectURL(file)
}
}


function saveThread(that){
  
  var input = document.getElementById('thread_image')

  var data = new FormData()
  data.append('thread_image', input.files[0])
  data.append('title', document.getElementById('title').value)
  data.append('content', document.getElementById('content').value)
  data.append('public', document.getElementById('public').value)
  data.append('_token', '{{ csrf_token() }}')

  fetch("{{ url('feed/save-new-thread') }}", {
  method: "POST",
  body: data,
  // JSON.stringify({
  //   title: document.getElementById('title').value,
  //   content: document.getElementById('content').value,
  //   public: document.getElementById('public').value,
  //   _token: '{{ csrf_token() }}',
  //   thread_image: document.getElementById('thread_image').value
  // })
})
  .then((response) => response.json())
  .then((json) => {
    console.log(json);
    if(json.status == 'success'){
      var modal = document.querySelector("#thread_image").closest("ion-modal");
      modal.dismiss(null, 'cancel');
      setTimeout(() => {
      window.location.reload()
    }, 3000);
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
  .then(function(json){
    that.querySelector('.spinner').classList.add('hidden');
    that.disabled =  false;
  });
}
</script>
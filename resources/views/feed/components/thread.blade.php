    <ion-card-header>
      <ion-card-title class="text-2xl">{{ $thread->title }}</ion-card-title>
    </ion-card-header>
  
    <ion-card-content>

        @component('livewire.modal')
        @slot('buttonClass', 'flex text-black dark:text-white font-semibold align-middle')
        @slot('button')
            <img src="{{ App\Http\Controllers\ImageController::GetImageUrl($thread->owner->profile_img) }}" class="rounded-full aspect-square h-10 w-10 mr-2" alt="">
            <span class="my-auto">{{ '@'.$thread->owner->username }}</span>
        @endslot
        @slot('title', __('main.user.User Profile'))
        @slot('url',url('user/'.$thread->owner->unid))
        @endcomponent
        <div class="text-lg text-justify text-semibold my-2">
            {{ $thread->content }}     
        </div>   

        <div class="flex my-4">
            <livewire:like-button type="threads" :slug="$thread->slug" :target_id="$thread->id">
            <livewire:save-button type="threads" :slug="$thread->slug" :target_id="$thread->id">
            <livewire:delete-button :result_slug="$thread->result->slug">
        </div>
            

        <h2 class="text-lg">{{ __('main.feed.Comments Section') }}</h2>
        <div class="flex align-middle">
            <ion-input class="my-auto py-0" autocapitalize="on" label="{{ __('main.feed.Comment this thread') }}" name="content" label-placement="floating" id="content" fill="outline" placeholder="Enter text"></ion-input>
            <livewire:button-spinner-sm text='<i class="icofont-paper-plane text-2xl"></i>'  javascript="saveComment(this)">
        </div>
        <div id="comments-section" class="border-l-2 px-2">
            
            @foreach ($thread->comments->sortByDesc('created_at') as $comment)
                    <div class="border-b my-2 border-gray-300">
                        @component('livewire.modal')
                        @slot('buttonClass', 'flex text-black dark:text-white font-semibold align-middle')
                        @slot('button')
                        <img src="{{ App\Http\Controllers\ImageController::GetImageUrl($comment->owner->profile_img) }}" class="rounded-full aspect-square h-5 w-5 mr-2" alt="">
                        <span class="my-auto font-semibold">{{ '@'.$comment->owner->username }}</span>
                        @endslot
                        @slot('title', __('main.user.User Profile'))
                        @slot('url',url('user/'.$comment->owner->unid))
                        @endcomponent
                        <div class="flex">
                            <div class="w-full">{{$comment->content}}</div>
                            <livewire:like-button type="threads" :slug="$comment->slug" :target_id="$comment->id">
                        </div>
                        <div class="text-right text-xs text-gray-300 dark:text-gray-700">
                            {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}
                        </div>
                    </div>
            @endforeach
            
        </div>

        <script>
          
          function saveComment(that){
            
          
            var data = new FormData()
            data.append('content', document.getElementById('content').value)
            data.append('_token', '{{ csrf_token() }}')
            data.append('thread', '{{ $thread->slug }}')
          
            fetch("{{ url('feed/save-thread-comment') }}", {
            method: "POST",
            body: data,
          })
            .then((response) => response.json())
            .then((json) => {
              console.log(json);
              if(json.status == 'success'){
                console.log('success')
              }

              document.querySelector('#comments-section').innerHTML = '<div class="border-b my-2 border-gray-300"><div class="flex text-black dark:text-white font-semibold align-middle"><img src="{{ App\Http\Controllers\ImageController::GetImageUrl($thread->owner->profile_img) }}" class="rounded-full aspect-square h-5 w-5 mr-2" alt=""><span class="my-auto font-semibold">{{ '@'.$thread->owner->username }}</span></div><div>'+document.getElementById('content').value+'</div><div class="text-right text-xs text-gray-300 dark:text-gray-700">{{ __('main.feed.Just Now') }}</div></div>'+document.querySelector('#comments-section').innerHTML
              document.getElementById('content').value = ""

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
    </ion-card-content>

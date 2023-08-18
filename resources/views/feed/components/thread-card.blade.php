@component('feed.components.card')
    @slot('image')
        {{-- @isset($thread->images)
            {{ $thread->images->first()->file_name }}
        @endisset --}}
    @endslot
    @slot('title', $thread->title)
    @slot('subtitle')

    
    @endslot
    @slot('content', $thread->content)
    @slot('user_img', App\Http\Controllers\ImageController::GetImageUrl($thread->owner->profile_img))
    @slot('user_name')
{!! "@".$thread->owner->username!!}
    @endslot
    @slot('user_unid', $thread->owner->unid)

    @slot('footer')
    <div class="flex my-4">
        <livewire:like-button type="threads" :slug="$thread->slug" :target_id="$thread->id">
        <livewire:save-button type="threads" :slug="$thread->slug" :target_id="$thread->id">
       @isset($thread->result->slug)
       <livewire:delete-button :result_slug="$thread->result->slug">
       @endisset
    </div>
    <div class="text-right text-sm">{{ \Carbon\Carbon::parse($thread->created_at)->diffForHumans(); }}.</div>

    <ion-card-subtitle class="my-2">{{ __('main.feed.Comments') }}</ion-card-subtitle>
    <div class="">
        @foreach (App\Models\Thread::where('parent_thread_id', $thread->id)->orderBy('likes', 'DESC')->limit(2)->orderBy('created_at', 'DESC')->get() as $comment)
            <div class=" my-2 border-gray-300">
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
    @component('livewire.modal')
        @slot('buttonClass', 'font-semibold align-middle')
        @slot('button')
        <ion-card-subtitle class="my-2">{{ __('main.feed.View more') }}</ion-card-subtitle>
        @endslot
        @slot('title', __('main.user.Thread'))
        @slot('url',url('feed/thread/'.$thread->slug))
    @endcomponent

    @endslot
    
@endcomponent
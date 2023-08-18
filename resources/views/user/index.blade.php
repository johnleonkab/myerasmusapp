@component('components.toast')@endcomponent
<div class="w-full md:w-5/6 xl:w-3/4 mx-auto">
    <div class="mx-2 my-2 grid grid-cols-3 md:grid-cols-4 xl:grid-cols-6">
        <img class="mx-auto my-2 rounded-full" src="{{App\Http\Controllers\ImageController::GetImageUrl($user->profile_img) }}" alt="">
        <div class="col-span-2 md:col-span-3 xl:col-span-5 flex">
            <div class="font-semibold font-varela text-black dark:text-white my-auto text-lg">
                <div class="user-name">{{ $user->name }}</div>
                <div class="user-name text-zinc-700 dark:text-zinc-400">{{ __('main.user.joined_on') .' '. \Carbon\Carbon::parse($user->created_at)->format('M Y'); }}</div>
                <div>{{__('main.user.Erasmus en')}} <span class="fi fi-es"></span></div>

            </div>
        </div>
    </div>
    @php
        $requested = false;
        $friends = false;
        if(!(Auth::user()->id != $user->id && Auth::user()->acceptedFriendsFrom()->where('user_id', $user->id)->count() == 0 && $user->acceptedFriendsFrom()->where('user_id', Auth::user()->id)->count() == 0)){
            $friends = true;  
        }
        if(!(Auth::user()->id != $user->id && Auth::user()->pendingFriendsFrom()->where('user_id', $user->id)->count() == 0 && $user->pendingFriendsFrom()->where('user_id', Auth::user()->id)->count() == 0)){
            $requested =  true;  
        }
    @endphp
    
    @if (Auth::user()->id != $user->id)
    <livewire:request-friendship :unid='$user->unid' :requested="$requested" :friends="$friends">
    @endif
    <div class="grid grid-cols-2 gap-5">
        @component('livewire.modal')
                @slot('buttonClass', 'text-center')
                @slot('button')
                <h2 class="text-2xl font-bold">{{ $user->acceptedFriendsTo()->count() + $user->acceptedFriendsFrom()->count() }}</h2>
                <div>{{__('main.user.Friends')}}</div>
                @endslot
                @slot('title', __('main.user.Friends'))
                @slot('url', url('user/'.$user->unid.'/friends'))
        @endcomponent
        <div class="text-center">
            <h2 class="text-2xl font-bold">540</h2>
            <div>Hitchhiker Points</div>
        </div>
    </div>
    @if (Auth::user()->id == $user->id)
    <div class="mx-2">
        {{-- <livewire:small-button text="lhj" onclick=""> --}}
            <div class="my-5">
                @component('livewire.modal')
                @slot('button', __('main.user.Editar perfil'))
                @slot('title', __('main.user.Editar perfil'))
                @slot('url', url('me/edit-profile'))
                @endcomponent
            </div>
            

            @component('livewire.modal')
            @slot('button', __('main.user.Resumen de tu erasmus'))
            @slot('title', __('main.user.Resumen de tu erasmus'))
            @slot('url', url('me/stay'))
        @endcomponent

        
    </div>
    @endif


    <div class="mx-2 my-10">
        <ion-card-title>{{ __('main.user.Posts from this user') }}</ion-card-title>
        @component('user.feed')
            @slot('user', $user)
        @endcomponent
    </div>
</div>
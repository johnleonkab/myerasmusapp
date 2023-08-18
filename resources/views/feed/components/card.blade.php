<ion-card class="rounded-lg p-4">
    @component('livewire.modal')
        @slot('buttonClass', 'flex text-black dark:text-white font-semibold align-middle')
        @slot('button')
            <img src="{{ $user_img }}" class="rounded-full aspect-square h-10 w-10 mr-2" alt="">
            <span class="my-auto">{{ $user_name }}</span>
        @endslot
        @slot('title', __('main.user.User Profile'))
        @slot('url',url('user/'.$user_unid))
    @endcomponent

    @if(isset($image) && $image != "")
    <div class="my-2">
        <img alt="" class="rounded-lg aspect-video object-cover" src="{{$image}}" />
    </div>
    @endif
    <ion-card-header>
      <ion-card-title class="text-2xl">{{ $title }}</ion-card-title>
      <ion-card-subtitle>{{ $subtitle }}</ion-card-subtitle>
    </ion-card-header>
  
    <ion-card-content>
        <div class="text-lg text-justify">
            {{ $content }}     
        </div>   

            

        <div>
            {{ $footer }}
        </div>
    </ion-card-content>
  </ion-card>
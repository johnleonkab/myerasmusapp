<div class="m-2 flex">
    @isset($event->image_id)
    <img alt="" class="rounded-lg aspect-video object-cover " src="{{ App\Http\Controllers\ImageController::GetImageUrl($event->image_id) }}" />
    @endisset

</div>
<div class="mx-2 my-auto">
    <ion-card-title>{{ $event->name }}</ion-card-title>
</div>  
<div class="m-2">
    <ion-card-content>
        {!! $event->description !!}
    </ion-card-content>
    <div>
        <ion-chip class="">
            @if (\Carbon\Carbon::parse($event->start_datetime)->format('Y-m-d') != \Carbon\Carbon::parse($event->end_datetime)->format('Y-m-d'))
                {{\Carbon\Carbon::parse($event->start_datetime)->format('d/m/Y H:i')." - ".\Carbon\Carbon::parse($event->end_datetime)->format('d/m H:i')}}
        @else
            {{\Carbon\Carbon::parse($event->start_datetime)->format('\(d/m/Y\) H:i')." - ".\Carbon\Carbon::parse($event->end_datetime)->format('H:i')}}
        @endif
        </ion-chip>
    </div>
    @isset($event->location_id)
            <ion-chip><i class="icofont-location-pin"></i>   {{$event->location->name}}</ion-chip>
        @endisset
        @isset($event->category_id)
            <ion-chip class="bg-[{{$event->category->color}}] text-white font-semibold">{{ __('main.feed.'.$event->category->slug) }}</ion-chip>
        @endisset
</div>

<div class="mx-4 my-4">
    @component('livewire.modal')
    @slot('buttonClass', 'flex text-black dark:text-white font-semibold align-middle')
    @slot('button')
        <img src="{{ App\Http\Controllers\ImageController::GetImageUrl($event->owner->profile_img) }}" class="rounded-full aspect-square h-10 w-10 mr-2" alt="">
        <span class="my-auto">{{ $event->owner->username }}</span>
    @endslot
    @slot('title', __('main.user.User Profile'))
    @slot('url',url('user/'.$event->owner->unid))
@endcomponent
</div>



    <div class="flex my-4 mx-4">
        <livewire:like-button type="events" :slug="$event->slug" :target_id="$event->id">
        <livewire:save-button type="events" :slug="$event->slug" :target_id="$event->id">
        <livewire:delete-button :result_slug="$event->result->slug">
    </div>
        <div class="text-right text-sm">{{ \Carbon\Carbon::parse($event->created_at)->diffForHumans(); }}.</div>

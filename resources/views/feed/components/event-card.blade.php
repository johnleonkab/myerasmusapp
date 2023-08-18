@component('feed.components.card')
    @slot('image')
        @if($event->image_id != null) {{ $event->image->file_name }}  @endif
    @endslot
    @slot('title', $event->name)
    @slot('subtitle')
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
    @endslot
    @slot('content', $event->description)
    @slot('user_img', App\Http\Controllers\ImageController::GetImageUrl($event->owner->profile_img))
    @slot('user_name')
    {!! "@".$owner_username!!}
    @endslot
    @slot('user_unid', $owner_unid)

    @slot('footer')
    <div class="flex my-4">
        <livewire:like-button type="events" :slug="$event->slug" :target_id="$event->id">
        <livewire:save-button type="events" :slug="$event->slug" :target_id="$event->id">
        <livewire:delete-button :result_slug="$event->result->slug">

    </div>
        <div class="text-right text-sm">{{ \Carbon\Carbon::parse($creation_date)->diffForHumans(); }}.</div>
    @endslot
    
@endcomponent
@component('livewire.modal')
        @slot('buttonClass', 'w-full')
        @slot('button')

<ion-card class=" rounded-lg">
    <div class="m-2 flex">
        @isset($event->image_id)
        <img alt="" class="rounded-lg aspect-video object-cover w-20" src="{{ App\Http\Controllers\ImageController::GetImageUrl($event->image_id) }}" />
        @endisset
        <div class="mx-2 my-auto">
                <ion-card-title>{{ $event->name }}</ion-card-title>
        </div>
    </div>
    <div class="m-2">
        <ion-card-content class="text-justify">
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
  </ion-card>
  @endslot
  @slot('title', __('main.user.Event'))
  @slot('url',url('places/event/'.$event->slug))
@endcomponent
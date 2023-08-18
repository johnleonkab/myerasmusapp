@foreach ($results as $result)
@if ($result->type == 'events')
    @component('feed.components.event-card')
        @slot('image')
            @if($result->event->image_id != null) {{ $result->event->image->file_name }}  @endif
        @endslot
        @slot('event', $result->event)
        @slot('title', $result->event->name)
        @slot('location', $result->event->location)
        @slot('description', $result->event->description)
        @slot('owner_name', $result->event->owner->name)
        @slot('owner_picture', $result->event->owner->profile_img)
        @slot('owner_unid', $result->event->owner->unid)
        @slot('owner_username', $result->event->owner->username)
        @slot('owner_unid', $result->event->owner->unid)
        @slot('creation_date', $result->event->created_at)
        @slot('start_date', $result->event->start_datetime)
        @slot('end_date', $result->event->end_datetime)
    @endcomponent
@endif

@if ($result->type == 'threads')
    @component('feed.components.thread-card')
        @slot('thread', $result->thread)
    @endcomponent
@endif
@endforeach
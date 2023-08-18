<ion-segment scrollable="true" value="heart" id="categories">
    @foreach (App\Models\Category::get() as $category)
    <ion-segment-button value="{{ $category->slug }}" >
        {{ __('main.feed.'.$category->slug) }}
      </ion-segment-button>
    @endforeach
</ion-segment>

<script>
    document.addEventListener('DOMContentLoaded', function() {
  const segment = document.getElementById('categories');

  segment.addEventListener('ionChange', function(event) {
    $('#entries-list').html();

    onVisible(document.querySelector("#spinner"), event.detail.value);
    console.log(event.detail.value)

  });
});
</script>
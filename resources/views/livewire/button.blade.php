<ion-button class="@isset($customClass) {{ $customClass }}  @endisset" onclick="{{ $javascript }}; this.disabled =  true; this.querySelector('.spinner').classList.remove('hidden');">
     {!! $text !!}
</ion-button>
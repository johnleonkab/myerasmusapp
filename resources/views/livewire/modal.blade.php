@php $str = \Str::random(6); @endphp
    <button onclick="loadModalContent('{{$url}}', 'modal-content{{$str}}')" class="@isset($buttonClass) {{ $buttonClass }} @else main-button @endisset" id="open-modal{{$str }}" expand="block">{{ $button }}</button>
    <ion-modal class="md:rounded-modal modal{{$str }}" trigger="open-modal{{$str }}" id="modal{{$str }}">
      <ion-header>
        <ion-toolbar>
          <ion-buttons slot="start">
            <ion-button onclick="cancel('modal{{$str }}')">{{__('main.navigation.Cancel')}}</ion-button>
          </ion-buttons>
          <ion-title>{{ $title }}</ion-title>
          <ion-buttons slot="end">
          </ion-buttons>
        </ion-toolbar>
      </ion-header>
      <ion-content id="modal-content{{$str}}" class="ion-padding">
        <div class="flex animate-pulse">
            <div class="flex-shrink-0">
              <span class="w-12 h-12 block bg-gray-200 rounded-full dark:bg-gray-700"></span>
            </div>
          
            <div class="ml-4 mt-2 w-full">
              <h3 class="h-4 bg-gray-200 rounded-md dark:bg-gray-700" style="width: 40%;"></h3>
          
              <ul class="mt-5 space-y-3">
                <li class="w-full h-4 bg-gray-200 rounded-md dark:bg-gray-700"></li>
                <li class="w-full h-4 bg-gray-200 rounded-md dark:bg-gray-700"></li>
                <li class="w-full h-4 bg-gray-200 rounded-md dark:bg-gray-700"></li>
                <li class="w-full h-4 bg-gray-200 rounded-md dark:bg-gray-700"></li>
              </ul>
            </div>
          </div>
      </ion-content>
    </ion-modal>

  <script>
    var modal{{$str }} = document.querySelector('#modal{{$str }}');
  
    function cancel(modal_id) {
        var modal = document.querySelector('#'+modal_id);
        modal.dismiss(null, 'cancel');
    }
  
  
    modal{{$str }}.addEventListener('willDismiss', (ev) => {
      if (ev.detail.role === 'confirm') {
        const message = document.querySelector('#message');
        message.textContent = `Hello ${ev.detail.data}!`;
      }
    });

    function loadModalContent(url, id){
        $('#'+id).load(url)
    }

    document.addEventListener('ionBackButton', (ev) => {
  ev.detail.register(10, () => {
    console.log('Handler was called!');
  });
});

</script>
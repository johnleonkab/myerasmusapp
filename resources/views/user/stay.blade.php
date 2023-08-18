<div class="flex flex-col bg-white  shadow-sm rounded-xl dark:bg-zinc-800 ">
    <div class="p-4 md:p-5">
      <h3 class="text-lg font-bold text-zinc-800 dark:text-white flex">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 my-auto mr-2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
        </svg>
        
        {{ __('main.user.Origen') }}
      </h3>
      <p class="mt-1 text-zinc-800 dark:text-zinc-400">
        {{ __('main.user.Where do you come from? Meet friends and students near you that will travel to the same place!') }}
      </p>
      <ion-list>
        <ion-item>
          <ion-select aria-label="" interface="action-sheet" id="home_country" placeholder="{{__('main.user.Country')}}">
            @foreach (App\Models\Country::get() as $country)
                <ion-select-option value="{{ $country->slug }}">{{$country->name}}</ion-select-option>                    
            @endforeach
          </ion-select>
        </ion-item>
      </ion-list>
      <ion-list>
        <ion-item>
          <ion-select aria-label="" interface="action-sheet" id="home_school" placeholder="{{__('main.user.University')}}">
            @foreach (App\Models\School::get() as $school)
                <ion-select-option value="{{ $school->slug }}">{{$school->name}}</ion-select-option>                    
            @endforeach
          </ion-select>
        </ion-item>
      </ion-list>


      <div class="my-5">
        <h3 class="text-lg font-bold text-zinc-800 dark:text-white flex">
          <i class="icofont-paper-plane text-2xl mr-2"></i>
          Destination
        </h3>
        
        <ion-item>
            <ion-select aria-label="" interface="action-sheet" id="destination_country" placeholder="{{__('main.user.Country')}}">
              @foreach (App\Models\Country::get() as $country)
                <ion-select-option value="{{$country->slug}}">{{$country->name}}</ion-select-option>                    
            @endforeach
            </ion-select>
          </ion-item>
          <ion-item>
            <ion-select aria-label="" interface="action-sheet" id="destination_school" placeholder="{{__('main.user.University')}}">
              @foreach (App\Models\School::get() as $school)
              <ion-select-option value="{{ $school->slug }}">{{$school->name}}</ion-select-option>                    
          @endforeach
            </ion-select>
          </ion-item>
      </div>


      <div class="my-5">
        {{ __('main.user.Stay Start') }}
        <ion-datetime id="start_datetime" value="@isset($stay->start_datetime){{\Carbon\Carbon::parse($stay->start_datetime)->format('Y-m-d')}}@else{{\Carbon\Carbon::now()->format('Y-m-d')}}@endisset"></ion-datetime>
      </div>
      <div class="my-5">
        {{ __('main.user.Stay End') }}
        <ion-datetime id="end_datetime" value="@isset($stay->end_datetime){{\Carbon\Carbon::parse($stay->end_datetime)->format('Y-m-d')}}@else{{\Carbon\Carbon::now()->format('Y-m-d')}}@endisset"></ion-datetime>
      </div>
      <livewire:button-spinner text="{{ __('main.user.Save Changes') }}" javascript="saveStayData(this)">

      <script>
        function saveStayData(that){
          fetch("{{ url('me/update/stay') }}", {
              method: "POST",
              body: JSON.stringify({
                home_country: document.getElementById('home_country').value,
                home_school: document.getElementById('home_school').value,
                destination_country: document.getElementById('destination_country').value,
                destination_school: document.getElementById('destination_school').value,
                start_datetime: document.getElementById('start_datetime').value,
                end_datetime: document.getElementById('end_datetime').value,
                _token: '{{ csrf_token() }}'
              }),
              headers: {
                "Content-type": "application/json; charset=UTF-8"
              }
            })
              .then((response) => response.json())
              .then((json) => {
                console.log(json);
                toast.isOpen = true;
                toast.message = json.message;
                setTimeout(() => {
                  toast.isOpen = false;
                }, 3000);
              })
              .then(function(json){
                that.querySelector('.spinner').classList.add('hidden');
                that.disabled =  false;
              });
        }


        @isset($stay)
        $(document).ready(function(){
              var home_country = document.getElementById('home_country');
              var destination_country = document.getElementById('destination_country');
              var home_school = document.getElementById('home_school');
              var destination_school = document.getElementById('destination_school');

              home_country.value = '{{$stay->home_country->slug}}'; // Set the default selected option value
              home_school.value = '{{$stay->home_school->slug}}'; // Set the default selected option value
              destination_country.value = '{{$stay->destination_country->slug}}'; // Set the default selected option value
              destination_school.value = '{{$stay->destination_school->slug}}'; // Set the default selected option value
            })
        @endisset
  
      </script>
    </div>
  </div>
<div class="font-varela ">
    @foreach (Illuminate\Support\Facades\DB::table('friends')->where('friends.friend_id', Auth::user()->id)->where('accepted', false)->get() as $user)
        @php
            $user = App\Models\User::where('id', $user->user_id)->get()->first()
        @endphp
        <div class="flex flex-wrap">
            <img src="{{App\Http\Controllers\ImageController::GetImageUrl($user->profile_img)}}" class="w-12 h-12 object-cover rounded-full mx-2" alt="">
                    <div class="mx-2">
                        <div>
                            <h1 class="font-medium text-lg"><span class="fi fi-es"></span> {{ $user->name }}</h1>
                        </div>
                        <div class="text-gray-400">
                            <h2>{{'@'.$user->username}}</h2>
                        </div>

                        <div id="friendship-status">
                            <livewire:button text="Aceptar" javascript="acceptFriendship(this, '{{ $user->unid }}')">
                            <livewire:button text="Rechazar" javascript="revokeFriendship(this, '{{ $user->unid }}' )">
                        </div>
                    </div>
                    
        </div>
    @endforeach
    @foreach ($users as $user)
        @component('livewire.modal')
                @slot('buttonClass', 'flex my-2')
                @slot('button')
                    <img src="{{App\Http\Controllers\ImageController::GetImageUrl($user->profile_img)}}" class="w-12 h-12 object-cover rounded-full mx-2" alt="">
                    <div class="mx-2">
                        <div class="block text-justify">
                            <h1 class="font-medium text-lg"><span class="fi fi-es"></span> {{ $user->name }}</h1>
                        </div>
                        <div class="text-gray-400 text-justify">
                            <h2>{{'@'.$user->username}}</h2>
                        </div>
                    </div>
                @endslot
                @slot('title', __('main.user.Friends'))
                @slot('url',url('user/'.$user->unid))
        @endcomponent
@endforeach
</div>

<script>
    function acceptFriendship(that,unid){
        var data = new FormData()
        data.append('_token', '{{ csrf_token() }}')
        data.append('unid', unid)
        
        fetch("{{ url('user/accept-friendship') }}", {
        method: "POST",
        body: data,
        })
            .then((response) => response.json())
            .then((json) => {
              console.log(json);
              if(json.status == 'success'){
                console.log('success')
                document.getElementById('friendship-status').innerHTML = "Aceptado"
                that.disabled =  false;
              }
              try {
                toast.isOpen = true;
              toast.message = json.message;
              setTimeout(() => {
                toast.isOpen = false;
              }, 3000);
              } catch (error) {}
            })
    }



    function revokeFriendship(that, unid){
        var data = new FormData()
        data.append('_token', '{{ csrf_token() }}')
        data.append('unid', unid)
        fetch("{{ url('user/revoke-friendship') }}", {
        method: "POST",
        body: data,
        })
            .then((response) => response.json())
            .then((json) => {
              console.log(json);
              if(json.status == 'success'){
                console.log('success')
                document.getElementById('friendship-status').innerHTML = "Denied"
                that.disabled =  false;
          }
            })
    }
</script>
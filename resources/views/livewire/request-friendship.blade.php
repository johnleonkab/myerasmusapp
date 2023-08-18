
<div id="request-friendship-{{$unid}}" class="@if (!$requested && !$friends) block @else hidden @endif">
    <livewire:button customClass="w-full" text="{{ __('main.user.Request Friendship') }}" javascript="requestFriendship(this, '{{ $unid }}')">
</div>


<div id="requested-friendship-{{$unid}}" class="@if ($requested) block @else hidden @endif">
    <livewire:button customClass="w-full" text="{{ __('main.user.Friendship Requested') }}" javascript="revokeFriendship(this, '{{ $unid }}')">
</div>

<div id="friendship-established-{{$unid}}" class="@if ($friends) block @else hidden @endif">
    <livewire:button customClass="w-full" text="{{ __('main.user.Friends') }}" javascript="revokeFriendship(this, '{{ $unid }}')">
</div>


<script>
    function requestFriendship(that, unid){
        var data = new FormData()
        data.append('_token', '{{ csrf_token() }}')
        data.append('unid', unid)
        
        fetch("{{ url('user/request-friendship') }}", {
        method: "POST",
        body: data,
        })
            .then((response) => response.json())
            .then((json) => {
              console.log(json);
              if(json.status == 'success'){
                console.log('success')
                document.getElementById('request-friendship-{{$unid}}').classList.add("hidden");
                document.getElementById('requested-friendship-{{$unid}}').classList.remove("hidden");
                document.getElementById('friendship-established-{{$unid}}').classList.add("hidden");
                that.disabled =  false;


                try {
                } catch (error) {
                    
                }
              }


              try {
                toast.isOpen = true;
              toast.message = json.message;
              setTimeout(() => {
                toast.isOpen = false;
              }, 3000);
          
          
              } catch (error) {
                
              }
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
                document.getElementById('request-friendship-{{$unid}}').classList.remove("hidden");
                document.getElementById('requested-friendship-{{$unid}}').classList.add("hidden");
                document.getElementById('friendship-established-{{$unid}}').classList.add("hidden");
                that.disabled =  false;

                try {
                } catch (error) {
                    
                }
              }


              try {
                toast.isOpen = true;
              toast.message = json.message;
              setTimeout(() => {
                toast.isOpen = false;
              }, 3000);
          
          
              } catch (error) {
                
              }
            })
    }
</script>
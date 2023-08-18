<ion-button id="open-toast" class="hidden" expand="block"></ion-button>
<ion-toast trigger="open-toast" id="toast" message="" duration="5000"></ion-toast>

<script>
    function triggerToast(message) {
        $('#toast').attr('message', message)
            $('#open-toast').click()
    }

    
</script>
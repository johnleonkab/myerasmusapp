<button type="button" onclick="{{ $onclick ? $onclick : "" }}" class="main-button">
    <div class="absolute w-0 left-2 my-auto">
        <div class="animate-spin inline-block w-6 h-6 border-[3px] border-current border-t-transparent text-white-600 rounded-full" role="status" aria-label="loading">
        </div>    
    </div>
    {{ $text }}
</button>
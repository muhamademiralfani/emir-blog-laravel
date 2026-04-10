@if(session('success'))
<div id="alert-success" class="fixed top-5 right-5 z-50 animate-bounce-in">
    <div class="bg-green-500 text-white px-6 py-4 rounded-2xl shadow-lg flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <span class="font-bold">{{ session('success') }}</span>
    </div>
</div>
@endif

@if(session('error'))
<div id="alert-error" class="fixed top-5 right-5 z-50 animate-bounce-in">
    <div class="bg-red-500 text-white px-6 py-4 rounded-2xl shadow-lg flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
        <span class="font-bold">{{ session('error') }}</span>
    </div>
</div>
@endif
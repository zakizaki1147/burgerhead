@if (session('success') || $errors->any())
    <div id="toast" class="fixed bottom-4 right-4 z-10 transition-opacity duration-700">
        <div class="p-4 font-semibold rounded-md flex justify-center items-center {{ session('success') ? 'bg-green-500' : 'bg-red-500 text-white-main' }}">
            @if (session('success'))
                <x-lucide-circle-check class="w-10 mr-1" />| {{ session('success') }}
            @else
                <x-lucide-circle-x class="w-10 mr-1" />| {{ $errors->first() }}
            @endif
        </div>
    </div>

    <script>
        const toast = document.getElementById('toast');

        if (toast) {
            setTimeout(() => {
                toast.classList.add('opacity-0');
                
                setTimeout(() => {
                    toast.remove();
                }, 700)
            }, 3000);
        }
    </script>
@endif
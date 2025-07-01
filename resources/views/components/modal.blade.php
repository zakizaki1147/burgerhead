@props(['id', 'title' => ''])

<div id="{{ $id }}" class="fixed inset-0 bg-black/50 z-50 hidden transition-opacity opacity-0 duration-200 ease-in-out" data-modal>
    <div class="w-full h-screen flex justify-center items-center">
        <div id="{{ $id }}Content" class="w-fit bg-white p-6 rounded-xl flex flex-col gap-3 border-2 border-red-main shadow shadow-red-main" data-modal-content>
            <h1 class="text-xl text-red-main font-bold">{{ $title }}</h1>
            <hr class="w-full border border-black-main" />
            <div class="min-h-20 min-w-80 max-w-200 flex flex-col gap-3">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
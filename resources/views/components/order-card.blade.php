<div class="w-full border-2 flex flex-col border-red-main rounded-lg">
    <div class="w-full bg-red-main">
        <h1 class="p-2 text-white text-lg text-center font-bold">Table #4</h1>
    </div>
    <div class="p-3.5 flex-1 flex flex-col gap-2">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-lg">Order #1</h2>
                <h3 class="text-gray-500 text-sm">1/7/2019, 07:00 AM</h3>
            </div>
            <h3 class="w-fit px-3 py-1 bg-red-500 rounded-md text-white text-sm font-medium">Not Yet Paid</h3>
        </div>
        <hr class="w-full border border-black-main" />
        <ul class="flex flex-1 flex-col">
            <li class="flex justify-between items-center font-medium">
                <p>1. <span class="font-semibold">Cheese Burger</span> - 2pc(s)</p>
                <p class="font-semibold">| $6</p>
            </li>
        </ul>
        <hr class="w-full border border-black-main" />
        <div class="w-full flex justify-between items-center">
            <div class="w-2/3">
                <h3 class="text-gray-500 text-sm">Total:</h3>
                <h2 class="font-bold text-lg">$10</h2>
            </div>
            <div class="w-1/3">
                <x-primary-button color='red-main'>Pay</x-primary-button>
            </div>
        </div>
    </div>
</div>
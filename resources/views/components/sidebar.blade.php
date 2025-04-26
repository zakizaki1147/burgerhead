<div class="w-70 h-screen fixed bg-red-main flex flex-col items-center gap-6 p-6">
    <img src="/images/burgerhead-logo.png" alt="Burgerhead" class="w-20">
    <hr class="w-full border border-white-main" />
    <div class="w-full flex flex-col flex-1 gap-2">
        <a href="/dashboard" class="{{ request()->is('dashboard') ? 'bg-black-main font-bold cursor-default' : 'bg-red-main font-medium hover:bg-black-main/70 active:bg-black-main' }} w-full flex gap-2 p-2 text-white-main rounded-lg transition">
            <x-lucide-bar-chart-4 class="w-6" />
            <h2>Dashboard</h2>
        </a>
        @php
            $role = Auth::user()->role;
        @endphp
        @if ($role === 'Administrator')
            <a href="/customer" class="{{ request()->is('customer') ? 'bg-black-main font-bold cursor-default' : 'bg-red-main font-medium hover:bg-black-main/70 active:bg-black-main' }} w-full flex gap-2 p-2 text-white-main rounded-lg transition">
                <x-lucide-users class="w-6" />
                <h2>Customer</h2>
            </a>
            <a href="/menu" class="{{ request()->is('menu') ? 'bg-black-main font-bold cursor-default' : 'bg-red-main font-medium hover:bg-black-main/70 active:bg-black-main' }} w-full flex gap-2 p-2 text-white-main rounded-lg transition">
                <x-lucide-sandwich class="w-6" />
                <h2>Menu</h2>
            </a>
            <a href="/table" class="{{ request()->is('table') ? 'bg-black-main font-bold cursor-default' : 'bg-red-main font-medium hover:bg-black-main/70 active:bg-black-main' }} w-full flex gap-2 p-2 text-white-main rounded-lg transition">
                <x-lucide-layers-2 class="w-6" />
                <h2>Table</h2>
            </a>
            <a href="/user" class="{{ request()->is('user') ? 'bg-black-main font-bold cursor-default' : 'bg-red-main font-medium hover:bg-black-main/70 active:bg-black-main' }} w-full flex gap-2 p-2 text-white-main rounded-lg transition">
                <x-lucide-user-pen class="w-6" />
                <h2>User</h2>
            </a>
        @elseif ($role === 'Waiter')
            <a href="/customer" class="{{ request()->is('customer') ? 'bg-black-main font-bold cursor-default' : 'bg-red-main font-medium hover:bg-black-main/70 active:bg-black-main' }} w-full flex gap-2 p-2 text-white-main rounded-lg transition">
                <x-lucide-users class="w-6" />
                <h2>Customer</h2>
            </a>
            <a href="/menu" class="{{ request()->is('menu') ? 'bg-black-main font-bold cursor-default' : 'bg-red-main font-medium hover:bg-black-main/70 active:bg-black-main' }} w-full flex gap-2 p-2 text-white-main rounded-lg transition">
                <x-lucide-sandwich class="w-6" />
                <h2>Menu</h2>
            </a>
            <a href="/order" class="{{ request()->is('order') ? 'bg-black-main font-bold cursor-default' : 'bg-red-main font-medium hover:bg-black-main/70 active:bg-black-main' }} w-full flex gap-2 p-2 text-white-main rounded-lg transition">
                <x-lucide-clipboard-list class="w-6" />
                <h2>Order</h2>
            </a>
        @elseif ($role === 'Cashier')
            <a href="/order" class="{{ request()->is('order') ? 'bg-black-main font-bold cursor-default' : 'bg-red-main font-medium hover:bg-black-main/70 active:bg-black-main' }} w-full flex gap-2 p-2 text-white-main rounded-lg transition">
                <x-lucide-clipboard-list class="w-6" />
                <h2>Order</h2>
            </a>
            <a href="/transaction" class="{{ request()->is('transaction') ? 'bg-black-main font-bold cursor-default' : 'bg-red-main font-medium hover:bg-black-main/70 active:bg-black-main' }} w-full flex gap-2 p-2 text-white-main rounded-lg transition">
                <x-lucide-dollar-sign class="w-6" />
                <h2>Transaction</h2>
            </a>
        @elseif ($role === 'Owner')
            <a href="/customer" class="{{ request()->is('customer') ? 'bg-black-main font-bold cursor-default' : 'bg-red-main font-medium hover:bg-black-main/70 active:bg-black-main' }} w-full flex gap-2 p-2 text-white-main rounded-lg transition">
                <x-lucide-users class="w-6" />
                <h2>Customer</h2>
            </a>
            <a href="/menu" class="{{ request()->is('menu') ? 'bg-black-main font-bold cursor-default' : 'bg-red-main font-medium hover:bg-black-main/70 active:bg-black-main' }} w-full flex gap-2 p-2 text-white-main rounded-lg transition">
                <x-lucide-sandwich class="w-6" />
                <h2>Menu</h2>
            </a>
            <a href="/order" class="{{ request()->is('order') ? 'bg-black-main font-bold cursor-default' : 'bg-red-main font-medium hover:bg-black-main/70 active:bg-black-main' }} w-full flex gap-2 p-2 text-white-main rounded-lg transition">
                <x-lucide-clipboard-list class="w-6" />
                <h2>Order</h2>
            </a>
            <a href="/table" class="{{ request()->is('table') ? 'bg-black-main font-bold cursor-default' : 'bg-red-main font-medium hover:bg-black-main/70 active:bg-black-main' }} w-full flex gap-2 p-2 text-white-main rounded-lg transition">
                <x-lucide-layers-2 class="w-6" />
                <h2>Table</h2>
            </a>
            <a href="/transaction" class="{{ request()->is('transaction') ? 'bg-black-main font-bold cursor-default' : 'bg-red-main font-medium hover:bg-black-main/70 active:bg-black-main' }} w-full flex gap-2 p-2 text-white-main rounded-lg transition">
                <x-lucide-dollar-sign class="w-6" />
                <h2>Transaction</h2>
            </a>
            <a href="/user" class="{{ request()->is('user') ? 'bg-black-main font-bold cursor-default' : 'bg-red-main font-medium hover:bg-black-main/70 active:bg-black-main' }} w-full flex gap-2 p-2 text-white-main rounded-lg transition">
                <x-lucide-user-pen class="w-6" />
                <h2>User</h2>
            </a>
        @endif
        {{-- <a href="/customer" class="{{ request()->is('customer') ? 'bg-black-main font-bold cursor-default' : 'bg-red-main font-medium hover:bg-black-main/70 active:bg-black-main' }} w-full flex gap-2 p-2 text-white-main rounded-lg transition">
            <x-lucide-users class="w-6" />
            <h2>Customer</h2>
        </a>
        <a href="/menu" class="{{ request()->is('menu') ? 'bg-black-main font-bold cursor-default' : 'bg-red-main font-medium hover:bg-black-main/70 active:bg-black-main' }} w-full flex gap-2 p-2 text-white-main rounded-lg transition">
            <x-lucide-sandwich class="w-6" />
            <h2>Menu</h2>
        </a>
        <a href="/table" class="{{ request()->is('table') ? 'bg-black-main font-bold cursor-default' : 'bg-red-main font-medium hover:bg-black-main/70 active:bg-black-main' }} w-full flex gap-2 p-2 text-white-main rounded-lg transition">
            <x-lucide-layers-2 class="w-6" />
            <h2>Table</h2>
        </a>
        <a href="/user" class="{{ request()->is('user') ? 'bg-black-main font-bold cursor-default' : 'bg-red-main font-medium hover:bg-black-main/70 active:bg-black-main' }} w-full flex gap-2 p-2 text-white-main rounded-lg transition">
            <x-lucide-user-pen class="w-6" />
            <h2>User</h2>
        </a>
        <a href="/order" class="{{ request()->is('order') ? 'bg-black-main font-bold cursor-default' : 'bg-red-main font-medium hover:bg-black-main/70 active:bg-black-main' }} w-full flex gap-2 p-2 text-white-main rounded-lg transition">
            <x-lucide-clipboard-list class="w-6" />
            <h2>Order</h2>
        </a>
        <a href="/transaction" class="{{ request()->is('transaction') ? 'bg-black-main font-bold cursor-default' : 'bg-red-main font-medium hover:bg-black-main/70 active:bg-black-main' }} w-full flex gap-2 p-2 text-white-main rounded-lg transition">
            <x-lucide-dollar-sign class="w-6" />
            <h2>Transaction</h2>
        </a> --}}
    </div>
    <hr class="w-full border border-white-main" />
    <div class="w-full flex justify-between items-center gap-2">
        <div class="flex justify-center items-center">
            <x-lucide-user-circle class="w-10 text-red-main bg-white-main rounded-full mx-2" />
            <div class="flex flex-col">
                @if (auth()->check())
                    <p class="text-white-main font-bold line-clamp-1">{{ auth()->user()->full_name }}</p>
                    <p class="text-white-main font-medium text-sm">{{ auth()->user()->role }}</p>
                @endif
            </div>
        </div>
        <x-icon-button color='black-main' data-open-modal="modalLogout">
            <x-lucide-log-out class="w-6 m-1" />
        </x-icon-button>
    </div>
</div>
<x-modal id="modalLogout" title="Log Out">
    <div class="min-h-20">
        <p class="text-black-main font-medium">Are you sure want to log out?</p>
    </div>
    <hr class="w-full border border-black-main" />
    <div class="w-full flex gap-3">
        <div class="w-1/2">
            <x-secondary-button color='red-main' id="closeModalLogout">Cancel</x-secondary-button>
        </div>
        <form action="{{ route('logout') }}" method="POST" class="w-1/2">
            @csrf
            <x-primary-button color='red-main' type="submit">Log Out</x-primary-button>
        </form>
    </div>
</x-modal>
{{-- <script>
    const openModalLogoutButton = document.getElementById('openModalLogout');
    const closeModalLogoutButton = document.getElementById('closeModalLogout');
    const modalLogout = document.getElementById('modalLogout');
    const modalLogoutContent = document.getElementById('modalLogoutContent');

    function openModalLogout() {
        modalLogout.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModalLogout() {
        modalLogout.classList.add('hidden');
        document.body.style.overflow = '';
    }

    if (openModalLogoutButton && closeModalLogoutButton && modalLogout) {
        openModalLogoutButton.addEventListener('click', openModalLogout);
        closeModalLogoutButton.addEventListener('click', closeModalLogout);
        modalLogout.addEventListener('click', (e) => {
            if (!modalLogoutContent.contains(e.target)) {
                closeModalLogout();
            }
        });
    } else {
        console.error('Modal elements not found:', {
            openModalLogoutButton, closeModalLogoutButton, modalLogout
        });
    };
</script> --}}
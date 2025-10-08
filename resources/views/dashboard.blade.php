<x-layout>
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
    <x-slot:title>{{ $title }}</x-slot:title>
    @php
        $role = Auth::user()->role;
    @endphp
    @if ($role === 'Administrator')
        <div class="w-full bg-white p-5 flex flex-col gap-2 rounded-lg shadow-lg">
            <h1 class="text-red-main text-xl font-bold h-[39.2px] flex items-center">Data Summary</h1>
            <hr class="w-full border border-black-main" />
            <div class="grid grid-cols-4 gap-2">
                <div class="w-full flex justify-between items-center gap-2 p-3.5 border-2 border-red-main rounded-lg">
                    <x-lucide-users class="w-14 p-2 bg-red-main text-white-main rounded-md" />
                    <h3 class="max-w-24 font-bold text-red-main text-center">Total Customer</h3>
                    <h3 class="font-bold text-red-main text-4xl">{{ $totalCustomers }}</h3>
                </div>
                <div class="w-full flex justify-between items-center gap-2 p-3.5 border-2 border-red-main rounded-lg">
                    <x-lucide-sandwich class="w-14 p-2 bg-red-main text-white-main rounded-md" />
                    <h3 class="max-w-24 font-bold text-red-main text-center">Total Menu</h3>
                    <h3 class="font-bold text-red-main text-4xl">{{ $totalMenus }}</h3>
                </div>
                <div class="w-full flex justify-between items-center gap-2 p-3.5 border-2 border-red-main rounded-lg">
                    <x-lucide-layers-2 class="w-14 p-2 bg-red-main text-white-main rounded-md" />
                    <h3 class="max-w-24 font-bold text-red-main text-center">Total Table</h3>
                    <h3 class="font-bold text-red-main text-4xl">{{ $totalTables }}</h3>
                </div>
                <div class="w-full flex justify-between items-center gap-2 p-3.5 border-2 border-red-main rounded-lg">
                    <x-lucide-user-pen class="w-14 p-2 bg-red-main text-white-main rounded-md" />
                    <h3 class="max-w-24 font-bold text-red-main text-center">Total User</h3>
                    <h3 class="font-bold text-red-main text-4xl">{{ $totalUsers }}</h3>
                </div>
            </div>
        </div>
        <div class="w-full bg-white p-5 flex flex-col gap-2 rounded-lg shadow-lg">
            <div class="flex justify-between items-center">
                <h1 class="text-red-main text-xl font-bold h-[39.2px] flex items-center">Recent Activities</h1>
                <a href="/activity-log" class="w-fit">
                    <x-primary-button color='red-main'>See More<x-lucide-chevrons-right class="w-5" /></x-primary-button>
                </a>
            </div>
            <hr class="w-full border border-black-main" />
            <table class="w-full rounded-md overflow-hidden">
                <thead class="bg-red-main text-white-main">
                    <tr>
                        <th class="border-b border-r p-2" style="width: 4%">No</th>
                        <th class="border-b border-r" style="width: 15%">Time</th>
                        <th class="border-b border-r" style="width: 10%">Type</th>
                        <th class="border-b border-r" style="width: 25%">User</th>
                        <th class="border-b">Description</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($activityLogs as $log)
                        <tr class="{{ $loop->even ? 'bg-white-main' : 'bg-white' }} text-black-main">
                            <td class="border-b border-white p-2 text-center font-bold">{{ $loop->iteration }}</td>
                            <td class="border border-white p-2 text-center">{{ $log->created_at->diffForHumans() }}</td>
                            <td class="border border-white p-2 text-center">
                                @php
                                    $badgeClass = match ($log->activity_type) {
                                        'login' => 'bg-cyan-500',
                                        'logout' => 'bg-cyan-500',
                                        'create' => 'bg-green-500',
                                        'update' => 'bg-yellow-500',
                                        'delete' => 'bg-red-500',
                                        'export' => 'bg-orange-500',
                                        'print' => 'bg-orange-500',
                                    };
                                @endphp
                                <span class="px-3 py-1 {{ $badgeClass }} rounded-md text-white text-sm font-medium">
                                    {{ ucfirst($log->activity_type) }}
                                </span>
                            </td>
                            <td class="border border-white p-2">{{ $log->user->full_name }} ({{ $log->user->role }})</td>
                            <td class="border border-white p-2">{{ $log->description }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center py-10 bg-white-main" colspan="6">There is no data :(</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @elseif ($role === 'Waiter')
        <div class="w-full bg-white p-5 flex flex-col gap-2 rounded-lg shadow-lg">
            <h1 class="text-red-main text-xl font-bold h-[39.2px] flex items-center">Data Summary</h1>
            <hr class="w-full border border-black-main" />
            <div class="grid grid-cols-4 gap-2">
                <div class="w-full flex justify-between items-center gap-2 p-3.5 border-2 border-red-main rounded-lg">
                    <x-lucide-users class="w-14 p-2 bg-red-main text-white-main rounded-md" />
                    <h3 class="max-w-24 font-bold text-red-main text-center">Total Customer</h3>
                    <h3 class="font-bold text-red-main text-4xl">{{ $totalCustomers }}</h3>
                </div>
                <div class="w-full flex justify-between items-center gap-2 p-3.5 border-2 border-red-main rounded-lg">
                    <x-lucide-sandwich class="w-14 p-2 bg-red-main text-white-main rounded-md" />
                    <h3 class="max-w-24 font-bold text-red-main text-center">Total Menu</h3>
                    <h3 class="font-bold text-red-main text-4xl">{{ $totalMenus }}</h3>
                </div>
                <div class="w-full flex justify-between items-center gap-2 p-3.5 border-2 border-red-main rounded-lg">
                    <x-lucide-clipboard-list class="w-14 p-2 bg-red-main text-white-main rounded-md" />
                    <h3 class="max-w-24 font-bold text-red-main text-center">Total Order</h3>
                    <h3 class="font-bold text-red-main text-4xl">{{ $totalOrderGroups }}</h3>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div class="w-full flex flex-col gap-2 p-3.5 border-2 border-red-main rounded-lg">
                    <h3 class="font-bold text-red-main text-center">Table Status Ratio</h3>
                    <div class="w-full h-72">
                        <canvas id="tableStatusChart" class="w-full"></canvas>
                    </div>
                </div>
            </div>
        </div>
    @elseif ($role === 'Cashier')
        <div class="w-full bg-white p-5 flex flex-col gap-2 rounded-lg shadow-lg">
            <h1 class="text-red-main text-xl font-bold h-[39.2px] flex items-center">Data Summary</h1>
            <hr class="w-full border border-black-main" />
            <div class="grid grid-cols-4 gap-2">
                <div class="w-full flex justify-between items-center gap-2 p-3.5 border-2 border-red-main rounded-lg">
                    <x-lucide-clipboard-list class="w-14 p-2 bg-red-main text-white-main rounded-md" />
                    <h3 class="max-w-24 font-bold text-red-main text-center">Total Order</h3>
                    <h3 class="font-bold text-red-main text-4xl">{{ $totalOrderGroups }}</h3>
                </div>
                <div class="w-full flex justify-between items-center gap-2 p-3.5 border-2 border-red-main rounded-lg">
                    <x-lucide-dollar-sign class="w-14 p-2 bg-red-main text-white-main rounded-md" />
                    <h3 class="max-w-24 font-bold text-red-main text-center">Total Transaction</h3>
                    <h3 class="font-bold text-red-main text-4xl">{{ $totalTransactions }}</h3>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div class="w-full flex flex-col gap-2 p-3.5 border-2 border-red-main rounded-lg">
                    <h3 class="font-bold text-red-main text-center">Order Status Ratio</h3>
                    <div class="w-full h-72">
                        <canvas id="orderStatusChart" class="w-full"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full bg-white p-5 flex flex-col gap-2 rounded-lg shadow-lg">
            <h1 class="text-red-main text-xl font-bold h-[39.2px] flex items-center">Recent Orders</h1>
            <hr class="w-full border border-black-main" />
            <div class="grid grid-cols-3 gap-2">
                @forelse ($unpaidOrderGroups as $unpaidOrderGroup)
                    <x-order-card :unpaidOrderGroup="$unpaidOrderGroup" />
                @empty
                    <h3 class="col-span-3 flex justify-center items-center">There are no active orders yet :)</h3>
                @endforelse
            </div>
        </div>
    @elseif ($role === 'Owner')
        <div class="w-full bg-white p-5 flex flex-col gap-2 rounded-lg shadow-lg">
            <h1 class="text-red-main text-xl font-bold h-[39.2px] flex items-center">Data Summary</h1>
            <hr class="w-full border border-black-main" />
            <div class="grid grid-cols-4 gap-2">
                <div class="w-full flex justify-between items-center gap-2 p-3.5 border-2 border-red-main rounded-lg">
                    <x-lucide-users class="w-14 p-2 bg-red-main text-white-main rounded-md" />
                    <h3 class="max-w-24 font-bold text-red-main text-center">Total Customer</h3>
                    <h3 class="font-bold text-red-main text-4xl">{{ $totalCustomers }}</h3>
                </div>
                <div class="w-full flex justify-between items-center gap-2 p-3.5 border-2 border-red-main rounded-lg">
                    <x-lucide-sandwich class="w-14 p-2 bg-red-main text-white-main rounded-md" />
                    <h3 class="max-w-24 font-bold text-red-main text-center">Total Menu</h3>
                    <h3 class="font-bold text-red-main text-4xl">{{ $totalMenus }}</h3>
                </div>
                <div class="w-full flex justify-between items-center gap-2 p-3.5 border-2 border-red-main rounded-lg">
                    <x-lucide-clipboard-list class="w-14 p-2 bg-red-main text-white-main rounded-md" />
                    <h3 class="max-w-24 font-bold text-red-main text-center">Total Order</h3>
                    <h3 class="font-bold text-red-main text-4xl">{{ $totalOrderGroups }}</h3>
                </div>
                <div class="w-full flex justify-between items-center gap-2 p-3.5 border-2 border-red-main rounded-lg">
                    <x-lucide-layers-2 class="w-14 p-2 bg-red-main text-white-main rounded-md" />
                    <h3 class="max-w-24 font-bold text-red-main text-center">Total Table</h3>
                    <h3 class="font-bold text-red-main text-4xl">{{ $totalTables }}</h3>
                </div>
                <div class="w-full flex justify-between items-center gap-2 p-3.5 border-2 border-red-main rounded-lg">
                    <x-lucide-dollar-sign class="w-14 p-2 bg-red-main text-white-main rounded-md" />
                    <h3 class="max-w-24 font-bold text-red-main text-center">Total Transaction</h3>
                    <h3 class="font-bold text-red-main text-4xl">{{ $totalTransactions }}</h3>
                </div>
                <div class="w-full flex justify-between items-center gap-2 p-3.5 border-2 border-red-main rounded-lg">
                    <x-lucide-users class="w-14 p-2 bg-red-main text-white-main rounded-md" />
                    <h3 class="max-w-24 font-bold text-red-main text-center">Total User</h3>
                    <h3 class="font-bold text-red-main text-4xl">{{ $totalUsers }}</h3>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div class="w-full flex flex-col gap-2 p-3.5 border-2 border-red-main rounded-lg">
                    <h3 class="font-bold text-red-main text-center">Daily Revenue</h3>
                    <div class="w-full h-72">
                        <canvas id="revenueChart" class="w-full"></canvas>
                    </div>
                </div>
                <div class="w-full flex flex-col gap-2 p-3.5 border-2 border-red-main rounded-lg">
                    <h3 class="font-bold text-red-main text-center">Top 5 Best-Selling Menus</h3>
                    <div class="w-full h-72">
                        <canvas id="topMenusChart" class="w-full"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full bg-white p-5 flex flex-col gap-2 rounded-lg shadow-lg">
            <div class="flex justify-between items-center">
                <h1 class="text-red-main text-xl font-bold h-[39.2px] flex items-center">Recent Activities</h1>
                <a href="/activity-log" class="w-fit">
                    <x-primary-button color='red-main'>See More<x-lucide-chevrons-right class="w-5" /></x-primary-button>
                </a>
            </div>
            <hr class="w-full border border-black-main" />
            <table class="w-full rounded-md overflow-hidden">
                <thead class="bg-red-main text-white-main">
                    <tr>
                        <th class="border-b border-r p-2" style="width: 4%">No</th>
                        <th class="border-b border-r" style="width: 15%">Time</th>
                        <th class="border-b border-r" style="width: 25%">User</th>
                        <th class="border-b border-r" style="width: 10%">Type</th>
                        <th class="border-b">Description</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($activityLogs as $log)
                        <tr class="{{ $loop->even ? 'bg-white-main' : 'bg-white' }} text-black-main">
                            <td class="border-b border-white p-2 text-center font-bold">{{ $loop->iteration }}</td>
                            <td class="border border-white p-2 text-center">{{ $log->created_at->diffForHumans() }}</td>
                            <td class="border border-white p-2">{{ $log->user->full_name }} ({{ $log->user->role }})</td>
                            <td class="border border-white p-2 text-center">
                                @php
                                    $badgeClass = match ($log->activity_type) {
                                        'login' => 'bg-cyan-500',
                                        'logout' => 'bg-cyan-500',
                                        'create' => 'bg-green-500',
                                        'update' => 'bg-yellow-500',
                                        'delete' => 'bg-red-500',
                                        'export' => 'bg-orange-500',
                                        'print' => 'bg-orange-500',
                                    };
                                @endphp
                                <span class="px-3 py-1 {{ $badgeClass }} rounded-md text-white text-sm font-medium">
                                    {{ ucfirst($log->activity_type) }}
                                </span>
                            </td>
                            <td class="border border-white p-2">{{ $log->description }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center py-10 bg-white-main" colspan="6">There is no data :(</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif

    <x-modal id="modalCreateTransaction" title="Pay Order">
        <form method="POST" id="formCreateTransaction" class="flex flex-col gap-3">
            @csrf
            <div class="flex flex-col">
                <label for="orderGroupId" class="font-bold text-sm w-fit">Order Group ID</label>
                <input type="text" name="orderGroupLabel" id="orderGroupLabel" autocomplete="off" readonly
                class="w-90 p-2 flex items-center border-2 border-black-main rounded-lg outline-none transition cursor-not-allowed">
                <input type="hidden" name="orderGroupId" id="orderGroupId">
            </div>
            <div class="flex flex-col">
                <label for="totalPrice" class="font-bold text-sm w-fit">Total Price</label>
                <div class="w-90 flex items-center border-2 border-black-main rounded-lg outline-none transition cursor-not-allowed">
                    <div class="pl-2">$</div>
                    <input type="number" name="totalPrice" id="totalPrice" placeholder="Total Price" autocomplete="off" readonly
                    class="w-full p-2 pl-0 text-sm outline-none cursor-not-allowed">
                </div>
            </div>
            <div class="flex flex-col">
                <label for="payAmount" class="font-bold text-sm w-fit">Pay Amount</label>
                <div class="w-90 flex items-center border-2 border-black-main rounded-lg outline-none focus-within:bg-red-main/10 focus-within:border-red-main transition">
                    <div class="pl-2">$</div>
                    <input type="number" name="payAmount" id="payAmount" placeholder="Pay Amount" autocomplete="off" required
                    class="w-full p-2 pl-0 text-sm outline-none">
                </div>
            </div>
            <div class="flex flex-col">
                <label for="changeAmount" class="font-bold text-sm w-fit">Change Amount</label>
                <div class="w-90 flex items-center border-2 border-black-main rounded-lg outline-none transition cursor-not-allowed">
                    <div class="pl-2">$</div>
                    <input type="number" name="changeAmount" id="changeAmount" placeholder="Change Amount" autocomplete="off" readonly
                    class="w-full p-2 pl-0 text-sm outline-none cursor-not-allowed">
                    <p id="changeAmountAlert" class="w-full p-2 pl-0 text-sm text-red-500 cursor-not-allowed hidden"></p>
                </div>
            </div>
            <hr class="w-full border border-black-main" />
            <div class="w-full flex gap-3">
                <div class="w-1/2">
                    <x-secondary-button color='red-main' type="button" data-close-modal>Cancel</x-secondary-button>
                </div>
                <div class="w-1/2">
                    <x-primary-button color='red-main' type="submit">Pay</x-primary-button>
                </div>
            </div>
        </form>
    </x-modal>

    <x-toast />

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const unpaidOrderGroups = @json($unpaidOrderGroups);

            // === MODAL CREATE ===
            const createOrderGroupLabel = document.querySelector('#modalCreateTransaction #orderGroupLabel');
            const createOrderGroupId = document.querySelector('#modalCreateTransaction #orderGroupId');
            const createTotal = document.querySelector('#modalCreateTransaction #totalPrice');
            const createPay = document.querySelector('#modalCreateTransaction #payAmount');
            const createChange = document.querySelector('#modalCreateTransaction #changeAmount');
            const createAlert = document.querySelector('#modalCreateTransaction #changeAmountAlert');
            let createTotalPrice = 0;

            if (createOrderGroupId) {
                createOrderGroupId.addEventListener('change', (e) => {
                    const group = unpaidOrderGroups.find(g => g.order_group_id == e.target.value);
                    if (group) {
                        createTotalPrice = parseFloat(group.total_price).toFixed(2);
                        createTotal.value = createTotalPrice;
                        createPay.value = '';
                        createChange.value = '';
                        createAlert.classList.add('hidden');
                        createChange.classList.remove('hidden');
                    }
                });

                createPay?.addEventListener('input', (e) => {
                    const pay = parseFloat(e.target.value);
                    if (isNaN(pay) || pay < createTotalPrice) {
                        createChange.value = '';
                        createAlert.textContent = 'Pay amount is less than total price!';
                        createAlert.classList.remove('hidden');
                        createChange.classList.add('hidden');
                    } else {
                        const change = (pay - createTotalPrice).toFixed(2);
                        createChange.value = change;
                        createAlert.classList.add('hidden');
                        createChange.classList.remove('hidden');
                    }
                });
            }

            document.querySelectorAll('[data-open-modal="modalCreateTransaction"]').forEach(button => {
                button.addEventListener('click', () => {
                    const orderGroupId = button.dataset.orderGroupId;
                    const orderGroupLabel = button.dataset.orderGroupLabel;
                    const totalPrice = button.dataset.totalPrice;

                    createTotalPrice = parseFloat(totalPrice);
                    createOrderGroupId.value = orderGroupId;
                    createOrderGroupLabel.value = orderGroupLabel;
                    createTotal.value = parseFloat(totalPrice).toFixed(2);
                    createPay.value = '';
                    createChange.value = '';
                    createAlert.textContent = '';
                    createAlert.classList.add('hidden');
                    createChange.classList.remove('hidden');
                });
            });

            const tableStatusCanvas = document.getElementById('tableStatusChart');
            if (tableStatusCanvas) {
                const tableStatusChart = new Chart(tableStatusCanvas, {
                    type: 'pie',
                    data: {
                        labels: ['Available', 'Occupied'],
                        datasets: [{
                            label: 'Total Tables',
                            data: [{{ $availableTablesChart }}, {{ $occupiedTablesChart }}],
                            backgroundColor: ['#B43F3F', '#FF8225'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {position: 'bottom'},
                        }
                    }
                });
            }

            const orderStatusCanvas = document.getElementById('orderStatusChart');
            if (orderStatusCanvas) {
                const orderStatusChart = new Chart(orderStatusCanvas, {
                    type: 'pie',
                    data: {
                        labels: ['Not Yet Paid', 'Already Paid'],
                        datasets: [{
                            label: 'Total Orders',
                            data: [{{ $unpaidOrderGroupsChart }}, {{ $paidOrderGroupsChart }}],
                            backgroundColor: ['#B43F3F', '#FF8225'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {position: 'bottom'},
                        }
                    }
                });
            }

            const revenueCanvas = document.getElementById('revenueChart');
            if (revenueCanvas) {
                const revenueChart = new Chart(revenueCanvas, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($revenueLabelsChart) !!},
                        datasets: [{
                            label: 'Daily Revenue',
                            data: {!! json_encode($revenueDataChart) !!},
                            // backgroundColor: ['#B43F3F'],
                            borderColor: ['#B43F3F'],
                            fill: false,
                            tension: 0.4,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {position: 'bottom'},
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const value = context.parsed.y || 0;
                                        return new Intl.NumberFormat('en-US', {
                                            style: 'currency',
                                            currency: 'USD',
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2,
                                        }).format(value);
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return new Intl.NumberFormat('en-US', {
                                            style: 'currency',
                                            currency: 'USD',
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2,
                                        }).format(value);
                                    }
                                }
                            }
                        }
                    }
                });
            }

            const topMenusCanvas = document.getElementById('topMenusChart');
            if (topMenusCanvas) {
                const topMenusChart = new Chart(topMenusCanvas, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($topMenusLabelsChart) !!},
                        datasets: [{
                            label: 'Total Ordered',
                            data: {!! json_encode($topMenusDataChart) !!},
                            backgroundColor: ['#B43F3F'],
                            borderRadius: 5,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {position: 'bottom'},
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.parsed.y + ' orders';
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
</x-layout>
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
    <div class="w-full bg-white px-8 py-6 flex flex-col gap-2 rounded-lg shadow-lg">
        <div class="flex justify-between items-center">
            <h1 class="text-red-main text-xl font-bold h-[39.2px] flex items-center">{{ $title }} List</h1>
            <div class="flex justify-center items-center gap-2">
                <div class="w-fit">
                    <form action="{{ route('transaction.export-excel') }}" method="POST" target="__blank">
                        @csrf
                        <x-primary-button color="yellow-main" type="submit">
                            <x-lucide-download class="w-5" /> Export Excel
                        </x-primary-button>
                    </form>
                </div>
                @if ($role === 'Cashier')
                    <div class="w-fit">
                        <x-secondary-button color='red-main'
                            data-open-modal="modalCreateTransaction"
                            data-type="create"
                            data-create-url="{{ route('transaction.store') }}"
                            data-target-form="formCreateTransaction"
                        >
                            <x-lucide-plus-circle class="w-5" />Pay Order
                        </x-secondary-button>
                    </div>
                @endif
            </div>
        </div>
        <hr class="w-full border border-black-main" />
        <table class="w-full rounded-md overflow-hidden">
            <thead class="bg-red-main text-white-main">
                <tr>
                    <th class="border-b border-r p-2" style="width: 4%">No</th>
                    <th class="border-b border-r">Order Group ID</th>
                    <th class="border-b border-r">Total Price</th>
                    <th class="border-b border-r">Pay Amount</th>
                    <th class="border-b border-r">Change Amount</th>
                    <th class="border-b border-r" style="width: 14%">Status</th>
                    <th class="border-b" style="width: 12%">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transactions as $transaction)
                    <tr class="{{ $loop->even ? 'bg-white-main' : 'bg-white'}} text-black-main">
                        <td class="border-b border-r border-white p-2 text-center font-bold">{{ $transactions->firstItem() + $loop->index }}</td>
                        <td class="border border-white p-2 text-center">ORD #{{ $transaction->order_group_id }}-{{ $transaction->orderGroup->customer_id }}-{{ $transaction->orderGroup->table_id }}</td>
                        <td class="border border-white p-2 text-center">${{ $transaction->total_price }}</td>
                        <td class="border border-white p-2 text-center">${{ $transaction->pay_amount }}</td>
                        <td class="border border-white p-2 text-center">${{ $transaction->change_amount }}</td>
                        <td class="border border-white p-2 text-center">{{ $transaction->transaction_status ? 'Success ✅' : 'Pending ❌' }}</td>
                        <td class="border-b border-white">
                            <div class="flex justify-center items-center gap-1">
                                <x-icon-button color='cyan'
                                    data-open-modal="modalTransactionDetail"
                                    data-type="detail"
                                    data-transaction-id="{{ $transaction->transaction_id }}"
                                    data-order-group-id="ORD #{{ $transaction->order_group_id }}-{{ $transaction->orderGroup->customer_id }}-{{ $transaction->orderGroup->table_id }}"
                                    data-total-price="${{ $transaction->total_price }}"
                                    data-pay-amount="${{ $transaction->pay_amount }}"
                                    data-change-amount="${{ $transaction->change_amount }}"
                                    data-transaction-status="{{ $transaction->transaction_status ? 'Success ✅' : 'Pending ❌' }}"
                                    data-cashier-name="{{ $transaction->user->full_name }}"
                                    data-created-at="{{ $transaction->created_at }}"
                                    data-updated-at="{{ $transaction->updated_at }}"
                                >
                                    <x-lucide-info class="w-6" />
                                </x-icon-button>
                                @if ($role === 'Cashier')
                                    |
                                    <x-icon-button color='yellow'
                                        data-open-modal="modalUpdateTransaction"
                                        data-type="update"
                                        data-update-url="{{ route('transaction.update', $transaction->transaction_id) }}"
                                        data-target-form="formUpdateTransaction"
                                        data-order-group-id="ORD #{{ $transaction->order_group_id }}-{{ $transaction->orderGroup->customer_id }}-{{ $transaction->orderGroup->table_id }}"
                                        data-total-price="{{ $transaction->total_price }}"
                                        data-pay-amount="{{ $transaction->pay_amount }}"
                                        data-change-amount="{{ $transaction->change_amount }}"
                                    >
                                        <x-lucide-pen class="w-6" />
                                    </x-icon-button>
                                    |
                                    <x-icon-button color='red'
                                        data-open-modal="modalDeleteTransaction"
                                        data-type="delete"
                                        data-delete-url="{{ route('transaction.destroy', $transaction->transaction_id) }}"
                                    >
                                        <x-lucide-trash-2 class="w-6" />
                                    </x-icon-button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center py-10 bg-white-main" colspan="7">There is no data :(</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <td colspan="7">
                    {{ $transactions->links('vendor.pagination.tailwind') }}
                </td>
            </tfoot>
        </table>
    </div>

    <x-modal id="modalCreateTransaction" title="Pay Order">
        <form method="POST" id="formCreateTransaction" class="flex flex-col gap-3">
            @csrf
            <div class="flex flex-col">
                <label for="orderGroupId" class="font-bold text-sm w-fit">Order Group ID</label>
                <select name="orderGroupId" id="orderGroupId" required class="w-90 py-2 px-1 text-sm border-2 border-black-main rounded-lg outline-none focus:bg-red-main/10 focus:border-red-main transition">
                    <option value="" selected disabled class="bg-white">Choose Order Group ID</option>
                    @foreach ($unpaidOrderGroups as $group)
                        <option value="{{ $group->order_group_id }}">ORD #{{ $group->order_group_id }}-{{ $group->customer->customer_id }}-{{ $group->table->table_id }}</option>
                    @endforeach
                </select>
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

    <x-modal id="modalTransactionDetail" title="Transaction Detail">
        <div class="grid grid-cols-[auto_1fr] gap-1.5 font-medium">
            <p>Transaction ID</p>
            <p>: <span id="modalTransactionId"></span></p>
            <p>Order Group ID</p>
            <p>: <span id="modalOrderGroupId"></span></p>
            <p>Total Price</p>
            <p>: <span id="modalTotalPrice"></span></p>
            <p>Pay Amount</p>
            <p>: <span id="modalPayAmount"></span></p>
            <p>Change Amount</p>
            <p>: <span id="modalChangeAmount"></span></p>
            <p>Transaction Status</p>
            <p>: <span id="modalTransactionStatus"></span></p>
            <p>Cashier Name</p>
            <p>: <span id="modalCashierName"></span></p>
            <p>Created At</p>
            <p>: <span id="modalCreatedAt"></span></p>
            <p>Updated At</p>
            <p>: <span id="modalUpdatedAt"></span></p>
        </div>
        <hr class="w-full border border-black-main" />
        <div class="w-full flex justify-center items-center">
            <div class="w-30">
                <x-secondary-button color='red-main' type="button" data-close-modal>Close</x-secondary-button>
            </div>
        </div>
    </x-modal>

    <x-modal id="modalUpdateTransaction" title="Pay Order">
        <form method="POST" id="formUpdateTransaction" class="flex flex-col gap-3">
            @csrf
            @method('PUT')
            <div class="flex flex-col">
                <label for="orderGroupId" class="font-bold text-sm w-fit">Order Group ID</label>
                <input type="text" name="orderGroupId" id="orderGroupId" placeholder="Username" autocomplete="off" readonly
                class="order-group-select w-90 p-2 text-sm border-2 border-black-main rounded-lg outline-none cursor-not-allowed transition">
            </div>
            <div class="flex flex-col">
                <label for="totalPrice" class="font-bold text-sm w-fit">Total Price</label>
                <div class="w-90 flex items-center border-2 border-black-main rounded-lg outline-none transition cursor-not-allowed">
                    <div class="pl-2">$</div>
                    <input type="number" name="totalPrice" id="totalPrice" placeholder="Total Price" autocomplete="off" readonly
                    class="total-price-input w-full p-2 pl-0 text-sm outline-none cursor-not-allowed">
                </div>
            </div>
            <div class="flex flex-col">
                <label for="payAmount" class="font-bold text-sm w-fit">Pay Amount</label>
                <div class="w-90 flex items-center border-2 border-black-main rounded-lg outline-none focus-within:bg-red-main/10 focus-within:border-red-main transition">
                    <div class="pl-2">$</div>
                    <input type="number" name="payAmount" placeholder="Pay Amount" autocomplete="off" required
                    class="pay-amount-input w-full p-2 pl-0 text-sm outline-none">
                </div>
            </div>
            <div class="flex flex-col">
                <label for="changeAmount" class="font-bold text-sm w-fit">Change Amount</label>
                <div class="w-90 flex items-center border-2 border-black-main rounded-lg outline-none transition cursor-not-allowed">
                    <div class="pl-2">$</div>
                    <input type="number" name="changeAmount" placeholder="Change Amount" autocomplete="off" readonly
                    class="change-amount-input w-full p-2 pl-0 text-sm outline-none cursor-not-allowed">
                    <p id="changeAmountAlert" class="w-full p-2 pl-0 text-sm text-red-500 cursor-not-allowed hidden"></p>
                </div>
            </div>
            <hr class="w-full border border-black-main" />
            <div class="w-full flex gap-3">
                <div class="w-1/2">
                    <x-secondary-button color='red-main' type="button" data-close-modal>Cancel</x-secondary-button>
                </div>
                <div class="w-1/2">
                    <x-primary-button color='red-main' type="submit">Update</x-primary-button>
                </div>
            </div>
        </form>
    </x-modal>

    <x-modal id="modalDeleteTransaction" title="Delete Transaction">
        <div class="min-h-20">
            <p class="text-black-main font-medium">Are you sure want to delete this transaction?</p>
        </div>
        <hr class="w-full border border-black-main" />
        <div class="w-full flex gap-3">
            <div class="w-1/2">
                <x-secondary-button color='red-main' type="button" data-close-modal>Cancel</x-secondary-button>
            </div>
            <form method="POST" class="w-1/2" data-delete-form>
                @csrf
                @method('DELETE')
                <x-primary-button color='red-main' type='submit'>Delete</x-primary-button>
            </form>
        </div>
    </x-modal>

    @if (session('success') || $errors->any())
        <div id="alert" class="fixed bottom-4 right-4 z-10 transition-opacity duration-700">
            <div class="p-4 font-semibold rounded-md flex justify-center items-center {{ session('success') ? 'bg-green-500' : 'bg-red-500 text-white-main' }}">
                @if (session('success'))
                    <x-lucide-circle-check class="w-10 mr-1" />| {{ session('success') }}
                @else
                    <x-lucide-circle-x class="w-10 mr-1" />| {{ $errors->first() }}
                @endif
            </div>
        </div>

        <script>
            const alert = document.getElementById('alert');

            if (alert) {
                setTimeout(() => {
                    alert.classList.add('opacity-0');
                    
                    setTimeout(() => {
                        alert.remove();
                    }, 700)
                }, 3000);
            }
        </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const unpaidOrderGroups = @json($unpaidOrderGroups);
            const allOrderGroups = @json($allOrderGroups);
    
            // === MODAL CREATE ===
            const createSelect = document.querySelector('#modalCreateTransaction #orderGroupId');
            const createTotal = document.querySelector('#modalCreateTransaction #totalPrice');
            const createPay = document.querySelector('#modalCreateTransaction #payAmount');
            const createChange = document.querySelector('#modalCreateTransaction #changeAmount');
            const createAlert = document.querySelector('#modalCreateTransaction #changeAmountAlert');
            let createTotalPrice = 0;
    
            if (createSelect) {
                createSelect.addEventListener('change', (e) => {
                    const group = unpaidOrderGroups.find(g => g.order_group_id == e.target.value);
                    if (group) {
                        createTotalPrice = group.total_price;
                        createTotal.value = createTotalPrice;
                        createPay.value = '';
                        createChange.value = '';
                        createAlert.classList.add('hidden');
                        createChange.classList.remove('hidden');
                    }
                });
    
                createPay?.addEventListener('input', (e) => {
                    const pay = parseInt(e.target.value);
                    if (isNaN(pay) || pay < createTotalPrice) {
                        createChange.value = '';
                        createAlert.textContent = 'Pay amount is less than total price!';
                        createAlert.classList.remove('hidden');
                        createChange.classList.add('hidden');
                    } else {
                        createChange.value = pay - createTotalPrice;
                        createAlert.classList.add('hidden');
                        createChange.classList.remove('hidden');
                    }
                });
            }
    
            // === MODAL UPDATE ===
            const updateSelect = document.querySelector('#modalUpdateTransaction .order-group-select');
            const updateTotal = document.querySelector('#modalUpdateTransaction .total-price-input');
            const updatePay = document.querySelector('#modalUpdateTransaction .pay-amount-input');
            const updateChange = document.querySelector('#modalUpdateTransaction .change-amount-input');
            const updateAlert = document.querySelector('#modalUpdateTransaction #changeAmountAlert');
            let updateTotalPrice = 0;
    
            updateSelect?.addEventListener('change', (e) => {
                const group = allOrderGroups.find(g => g.order_group_id == e.target.value);
                if (group) {
                    updateTotalPrice = group.total_price;
                    updateTotal.value = updateTotalPrice;
                    updatePay.value = '';
                    updateChange.value = '';
                    updateAlert.classList.add('hidden');
                    updateChange.classList.remove('hidden');
                }
            });
    
            updatePay?.addEventListener('input', (e) => {
                const pay = parseInt(e.target.value);
                if (isNaN(pay) || pay < updateTotalPrice) {
                    updateChange.value = '';
                    updateAlert.textContent = 'Pay amount is less than total price!';
                    updateAlert.classList.remove('hidden');
                    updateChange.classList.add('hidden');
                } else {
                    updateChange.value = pay - updateTotalPrice;
                    updateAlert.classList.add('hidden');
                    updateChange.classList.remove('hidden');
                }
            });
    
            // === Set data saat buka modal UPDATE ===
            document.querySelectorAll('[data-open-modal="modalUpdateTransaction"]').forEach(button => {
                button.addEventListener('click', () => {
                    const modal = document.getElementById('modalUpdateTransaction');
                    const orderGroupId = button.dataset.orderGroupId;
                    const totalPrice = button.dataset.totalPrice;
                    const payAmount = button.dataset.payAmount;
                    const changeAmount = button.dataset.changeAmount;
    
                    updateTotalPrice = parseInt(totalPrice);
    
                    modal.querySelector('.order-group-select').value = String(orderGroupId);
                    modal.querySelector('.total-price-input').value = totalPrice;
                    modal.querySelector('.pay-amount-input').value = payAmount;
                    modal.querySelector('.change-amount-input').value = changeAmount;
    
                    if (payAmount < updateTotalPrice) {
                        updateAlert.textContent = 'Pay amount is less than total price!';
                        updateAlert.classList.remove('hidden');
                        updateChange.classList.add('hidden');
                    } else {
                        updateAlert.textContent = '';
                        updateAlert.classList.add('hidden');
                        updateChange.classList.remove('hidden');
                    }
                });
            });
        });
    </script>
    
</x-layout>
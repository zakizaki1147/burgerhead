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
            @if ($role === 'Administrator' || $role === 'Waiter')
                <div class="w-fit">
                    <x-secondary-button color='red-main'
                        data-open-modal="modalCreateCustomer"
                        data-type="create"
                        data-create-url="{{ route('customer.store') }}"
                        data-target-form="formCreateCustomer"
                    >
                        <x-lucide-plus-circle class="w-5" />Create Customer
                    </x-secondary-button>
                </div>
            @endif
        </div>
        {{-- <div class="flex justify-between items-center">
            <div class="w-fit flex">
                <input type="text" name="" id="" placeholder="Search" autocomplete="off"
                class="w-80 p-2 border-2 border-red-main text-sm rounded-l-lg outline-none focus:bg-red-main/10 focus:border-red-main transition">
                <button class="px-3 py-2 bg-red-main text-white-main outline-none rounded-r-lg hover:bg-red-main/85 active:bg-red-main transition cursor-pointer">
                    <x-lucide-search class="w-6"></x-lucide-search>
                </button>
            </div>
            <div class="w-fit">
                <x-secondary-button color='red-main'
                    data-open-modal="modalCreateCustomer"
                    data-type="create"
                    data-create-url="{{ route('customer.store') }}"
                    data-target-form="formCreateCustomer"
                >
                    <x-lucide-plus-circle class="w-5" />Create Customer
                </x-secondary-button>
            </div>
        </div> --}}
        <hr class="w-full border border-black-main" />
        <table class="w-full rounded-md overflow-hidden">
            <thead class="bg-red-main text-white-main">
                <tr>
                    <th class="border-b border-r p-2" style="width: 4%">No</th>
                    <th class="border-b border-r">Customer Name</th>
                    <th class="border-b border-r" style="width: 10%">Gender</th>
                    <th class="border-b border-r" style="width: 15%">Phone Number</th>
                    <th class="border-b border-r" style="width: 20%">Address</th>
                    <th class="border-b" style="width: 15%">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($customers as $customer)
                    <tr class="{{ $loop->even ? 'bg-white-main' : 'bg-white'}} text-black-main">
                        <td class="border-b border-r border-white p-2 text-center font-bold">{{ $customers->firstItem() + $loop->index }}</td>
                        <td class="border border-white p-2">{{ $customer->customer_name }}</td>
                        <td class="border border-white p-2 text-center">{{ $customer->gender ? 'Male' : 'Female' }}</td>
                        <td class="border border-white p-2 text-center">{{ $customer->phone_number }}</td>
                        <td class="border border-white p-2">{{ $customer->address }}</td>
                        <td class="border-b border-white">
                            <div class="flex justify-center items-center gap-1">
                                <x-icon-button color='cyan'
                                    data-open-modal="modalCustomerDetail"
                                    data-type="detail"
                                    data-customer-id="{{ $customer->customer_id }}"
                                    data-customer-name="{{ $customer->customer_name }}"
                                    data-gender="{{ $customer->gender ? 'Male' : 'Female' }}"
                                    data-phone-number="{{ $customer->phone_number }}"
                                    data-address="{{ $customer->address }}"
                                    data-created-at="{{ $customer->created_at }}"
                                    data-updated-at="{{ $customer->updated_at }}"
                                >
                                    <x-lucide-info class="w-6" />
                                </x-icon-button>
                                @if ($role === 'Administrator' || $role === 'Waiter')
                                    |
                                    <x-icon-button color='yellow'
                                        data-open-modal="modalUpdateCustomer"
                                        data-type="update"
                                        data-update-url="{{ route('customer.update', $customer->customer_id) }}"
                                        data-target-form="formUpdateCustomer"
                                        data-customer-name="{{ $customer->customer_name }}"
                                        data-gender="{{ $customer->gender }}"
                                        data-phone-number="{{ $customer->phone_number }}"
                                        data-address="{{ $customer->address }}"
                                    >
                                        <x-lucide-pen class="w-6" />
                                    </x-icon-button>
                                    |
                                    <x-icon-button color='red'
                                        data-open-modal="modalDeleteCustomer"
                                        data-type="delete"
                                        data-delete-url="{{ route('customer.destroy', $customer->customer_id) }}"
                                    >
                                        <x-lucide-trash-2 class="w-6" />
                                    </x-icon-button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center py-10 bg-white-main" colspan="6">There is no data :(</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <td colspan="6">
                    {{ $customers->links('vendor.pagination.tailwind') }}
                </td>
            </tfoot>
        </table>
    </div>

    <x-modal id="modalCreateCustomer" title="Create Customer">
        <form method="POST" id="formCreateCustomer" class="flex flex-col gap-3">
            @csrf
            <div class="flex flex-col">
                <label for="customerName" class="font-bold text-sm w-fit">Customer Name</label>
                <input type="text" name="customerName" id="customerName" placeholder="Customer Name" autocomplete="off" required
                class="w-90 p-2 text-sm border-2 border-black-main rounded-lg outline-none focus:bg-red-main/10 focus:border-red-main transition">
            </div>
            <div class="flex flex-col">
                <label for="gender" class="font-bold text-sm w-fit">Gender</label>
                <select name="gender" id="gender" required class="w-90 py-2 px-1 text-sm border-2 border-black-main rounded-lg outline-none focus:bg-red-main/10 focus:border-red-main transition">
                    <option value="" selected disabled class="bg-white">Gender</option>
                    <option value="1" class="bg-white">Male</option>
                    <option value="0" class="bg-white">Female</option>
                </select>
            </div>
            <div class="flex flex-col">
                <label for="phoneNumber" class="font-bold text-sm w-fit">Phone Number</label>
                <input type="number" name="phoneNumber" id="phoneNumber" placeholder="Phone Number" autocomplete="off" required
                class="w-90 p-2 text-sm border-2 border-black-main rounded-lg outline-none focus:bg-red-main/10 focus:border-red-main transition">
            </div>
            <div class="flex flex-col">
                <label for="address" class="font-bold text-sm w-fit">Address</label>
                <input type="text" name="address" id="address" placeholder="Address" autocomplete="off" required
                class="w-90 p-2 text-sm border-2 border-black-main rounded-lg outline-none focus:bg-red-main/10 focus:border-red-main transition">
            </div>
            <hr class="w-full border border-black-main" />
            <div class="w-full flex gap-3">
                <div class="w-1/2">
                    <x-secondary-button color='red-main' type="button" data-close-modal>Cancel</x-secondary-button>
                </div>
                <div class="w-1/2">
                    <x-primary-button color='red-main' type="submit">Create</x-primary-button>
                </div>
            </div>
        </form>
    </x-modal>

    <x-modal id="modalCustomerDetail" title="Customer Detail">
        <div class="grid grid-cols-[auto_1fr] gap-1.5 font-medium">
            <p>Customer ID</p>
            <p>: <span id="modalCustomerId"></span></p>
            <p>Customer Name</p>
            <p>: <span id="modalCustomerName"></span></p>
            <p>Gender</p>
            <p>: <span id="modalGender"></span></p>
            <p>Phone Number</p>
            <p>: <span id="modalPhoneNumber"></span></p>
            <p>Address</p>
            <p>: <span id="modalAddress"></span></p>
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

    <x-modal id="modalUpdateCustomer" title="Update Customer">
        <form method="POST" id="formUpdateCustomer" class="flex flex-col gap-3">
            @csrf
            @method('PUT')
            <div class="flex flex-col">
                <label for="customerName" class="font-bold text-sm w-fit">Customer Name</label>
                <input type="text" name="customerName" id="modalCustomerName" placeholder="Customer Name" autocomplete="off" required
                class="w-90 p-2 text-sm border-2 border-black-main rounded-lg outline-none focus:bg-red-main/10 focus:border-red-main transition">
            </div>
            <div class="flex flex-col">
                <label for="gender" class="font-bold text-sm w-fit">Gender</label>
                <select name="gender" id="modalGender" required class="w-90 py-2 px-1 text-sm border-2 border-black-main rounded-lg outline-none focus:bg-red-main/10 focus:border-red-main transition">
                    <option value="" selected disabled class="bg-white">Gender</option>
                    <option value="1" class="bg-white">Male</option>
                    <option value="0" class="bg-white">Female</option>
                </select>
            </div>
            <div class="flex flex-col">
                <label for="phoneNumber" class="font-bold text-sm w-fit">Phone Number</label>
                <input type="number" name="phoneNumber" id="modalPhoneNumber" placeholder="Phone Number" autocomplete="off" required
                class="w-90 p-2 text-sm border-2 border-black-main rounded-lg outline-none focus:bg-red-main/10 focus:border-red-main transition">
            </div>
            <div class="flex flex-col">
                <label for="address" class="font-bold text-sm w-fit">Address</label>
                <input type="text" name="address" id="modalAddress" placeholder="Address" autocomplete="off" required
                class="w-90 p-2 text-sm border-2 border-black-main rounded-lg outline-none focus:bg-red-main/10 focus:border-red-main transition">
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

    <x-modal id="modalDeleteCustomer" title="Delete Customer">
        <div class="min-h-20">
            <p class="text-black-main font-medium">Are you sure want to delete this customer?</p>
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
</x-layout>
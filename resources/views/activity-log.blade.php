<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="w-full bg-white p-5 flex flex-col gap-2 rounded-lg shadow-lg">
        <h1 class="text-red-main text-xl font-bold h-[39.2px] flex items-center">{{ $title }}</h1>
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
                        <td class="border-b border-r border-white p-2 text-center font-bold">{{ $activityLogs->firstItem() + $loop->index }}</td>
                        <td class="border border-white p-2 text-center">{{ $log->created_at->format('d M Y H:i') }}</td>
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
            <tfoot>
                <td colspan="5">
                    {{ $activityLogs->links('vendor.pagination.tailwind') }}
                </td>
            </tfoot>
        </table>
    </div>
</x-layout>
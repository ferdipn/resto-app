<div>
    <div class="mb-6">
        <div class="flex justify-end gap-5">
            <div class="relative max-w-sm" wire:ignore>
                <input
                    id="default-datepicker" 
                    type="datetime-local"
                    class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Select date"
                    wire:model.live.debounce.500ms="filterByDate">
                </div>
            <div>
                <input
                    class="bg-white w-full pr-11 h-10 pl-3 py-2 placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md"
                    type="text"
                    wire:model.live.debounce.500ms="search"
                    placeholder="Search Restaurant"
                />

                <button
                    class="absolute h-8 w-8 right-1 top-1 my-auto px-2 flex items-center bg-white rounded "
                    type="button"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" 
                        fill="none" 
                        viewBox="0 0 24 24"
                        stroke-width="3"
                        stroke="currentColor"
                        class="w-8 h-8 text-slate-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <table class="table-auto text-left w-full">
        <thead>
            <tr>
                <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50"></th>
                <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">Name</th>
                <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">Address</th>
                <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">Status</th>
                <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">Operation Hours</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $key => $item)
            <tr class="hover:bg-slate-50">
                <td class="p-4 w-2">{{ $key+1 }}</td>
                <td class="p-4 w-3/12">{{ $item['name'] }}</td>
                <td class="p-4 w-3/12">{{ $item['address'] }}</td>
                <td class="p-4 w-1/12">{{ $item['is_active'] ? "Active" : "Inactive" }}</td>
                <td class="p-4 w-4/12">{{ $item['schedule_label']}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="py-5">
    {{ $data->links() }}
    </div>
</div>




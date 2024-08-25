<div>
    <div class="w-full flex justify-between items-center mb-6 mt-1 pl-3">
        <div>
            <h3 class="text-lg font-semibold ml-3 text-slate-800">Restaurants</h3>
            <p class="text-slate-500 ml-3">List of Restaurant</p>
        </div>
        <div>
            <button class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                type="button"
                wire:click="openModal"
            >
                    Add Restaurant
            </button>
        </div>
    </div>

    @livewire('admin.restaurant.table')

    @if($isModalOpen)
        @livewire('admin.restaurant.form')
    @endif
    
</div>

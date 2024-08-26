<div>
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">

        <form class="max-w-sm mx-auto" wire:submit.prevent="storeData">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
            <div class="modal-header flex items-center justify-between py-3 border-b rounded-t">
                <h2 class="text-xl font-semibold">Modal</h2>
            </div>
            <div class="modal-body py-4 border-b">

                <div class="mb-5">
                    <label for="restaurantName" 
                        class="block mb-2 text-sm font-medium">
                        Restaurant Name
                    </label>
                    <input type="text" 
                        id="restaurantName" 
                        class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500  block w-full p-2.5" 
                        placeholder="Bro Burger" 
                        required
                        wire:model="name" />

                    @error('name') <span class="invalid-feedback">{{ $message }}<span> @enderror
                </div>
                <div class="mb-5">
                    <label for="address" 
                        class="block mb-2 text-sm font-medium">
                        Address</label>
                    <textarea id="address" 
                        class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500  block w-full p-2.5"
                        required 
                        placeholder="jl. Jayu Jati no 14, Kec. Rawa sari" 
                        wire:model="address"></textarea>

                    @error('address') <span class="invalid-feedback">{{ $message }}<span> @enderror
                </div>

                <div class="mb-5">
                    <label for="operationHours" 
                        class="block mb-2 text-sm font-medium">
                        Operation hours</label>

                        @foreach($operationHours as $day => $operationHour)
                        <div class="flex mb-2 ml-5">
                            <div class="flex items-center w-36 gap-2">
                                <input type="checkbox"
                                    wire:key="post-field-{{ $day }}"
                                    wire:click="toogleOpenOperational('{{ $day }}')"
                                    id="is_open_{{ $day }}">
                                <label for="is_open_{{ $day }}">{{ $day }}</label>
                            </div>
                            <div class="flex justify-between gap-2">
                                <input 
                                    class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 block p-2.5" 
                                    type="time" 
                                    placeholder="jam buka" 
                                    wire:model="operationHours.{{ $day }}.open"
                                    @if(!$operationHour['is_open']) disabled @endif
                                >
                                <input 
                                    class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 block p-2.5" 
                                    type="time" 
                                    placeholder="jam tutup"
                                    min="{{ $operationHour['open']}}"
                                    wire:model="operationHours.{{ $day }}.close"
                                    @if(!$operationHour['is_open']) disabled @endif
                                >
                            </div>
                        </div>
                        @endforeach
                </div>
            </div>

            <div class="modal-footer flex justify-end pt-3">
                <button class="mr-1 px-4 py-2 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-red-500"
                    type="submit">
                    Save
                </button>
                <button class="px-4 py-2 bg-red-500 text-white font-semibold rounded-lg shadow-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500"
                    wire:click="closeModal">
                    Close
                </button>
            </div>
        </div>

        </form>
    </div>
</div>
<div class="p-2">
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <div class="flex flex-col md:flex-row space-x-5">
        <div class="flex-auto">
            <div class="flex flex-col w-full">
                <label class="leading-loose">Date:</label>
                <div class=" focus-within:text-gray-600 text-gray-400">
                    <input type="text" placeholder="Date" wire:model="date"
                        class="date pr-4 pl-2 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300  focus:outline-none text-gray-600 @error('date') border-red-500 @enderror">
                    @error('date') <div class="error">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>
        <div class="flex-auto">
            <div class="flex flex-col w-full">
                <label class="leading-loose">Holiday Name: </label>
                <div class=" focus-within:text-gray-600 text-gray-400">
                    <input type="text" placeholder="Holiday Name"
                        wire:model="holiday_name"
                        class=" pr-4 pl-2 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300  focus:outline-none text-gray-600 @error('holiday_name') border-red-500 @enderror">
                    @error('holiday_name') <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="grid justify-items-stretch mt-2">
        <div class="justify-self-center">

            @if ($holiday_hash != null)
                <button
                    class="inline-block px-6 py-2 text-xs font-medium leading-6 text-center text-white uppercase transition bg-green-500 rounded shadow ripple hover:shadow-lg hover:bg-green-600 focus:outline-none"
                    wire:click="updateHoliday('{{$holiday_hash}}')"> Update Holiday</button>
                    <div class="flex items-center bg-blue-900 text-white text-sm font-bold px-4 py-3" wire:loading
                    wire:target="updateHoliday">
                    Updating Holiday
                </div>
            @else
                <button
                    class="inline-block px-6 py-2 text-xs font-medium leading-6 text-center text-white uppercase transition bg-green-500 rounded shadow ripple hover:shadow-lg hover:bg-green-600 focus:outline-none"
                    wire:click="saveHoliday"> Save Holiday</button>
                    <div class="flex items-center bg-blue-900 text-white text-sm font-bold px-4 py-3" wire:loading
                    wire:target="saveHoliday">
                    Saving Holiday
                </div>
            @endif
        </div>
    </div>
    <hr class="mt-2"/>
    <div class="grid justify-items-stretch">
        <div class="justify-self-center">
            <div wire:loading class="bg-green-700 text-white p-1 shadow-sm">
                Loading ...
            </div>
        </div>
    </div>
    <table class="table-auto w-full mt-2" wire:loading.class="cursor-wait">
        <thead>
            <tr class="bg-gray-400">
                <th class="pr-5 pl-5 border-r border-t border-l border-gray-300 cursor-pointer">#</th>
                <th wire:click.prevent="sortBy('staff')"
                    class="pr-5 pl-5  border-r border-t border-gray-300 cursor-pointer">Holiday Name</th>
                <th wire:click.prevent="sortBy('staff')"
                    class="pr-5 pl-5  border-r border-t border-gray-300 cursor-pointer">Date</th>
                <th wire:click.prevent="sortBy('staff')"
                    class="pr-5 pl-5  border-r border-t border-gray-300 cursor-pointer">Actions</th>


            </tr>
        </thead>
        <tbody>
            @foreach ($holidays as $holiday)
                <tr class="">
                    <td class="p-3 border border-r border-gray-50 w-2">{{$loop->index+1}}</td>
                    <td class="p-3 border border-r border-gray-50">
                        {{ $holiday->holiday_name }}
                    </td>
                    <td class="p-3 border border-r border-gray-50 text-center">
                        {{ Carbon\Carbon::parse($holiday->date)->format('j-M-y') }}<br />
                    </td>


                    <td class="p-3 border border-r border-gray-50 text-center">
                        <div class="inline-block mr-2 mt-2">
                            <div class="w-full py-3">
                                <div class="inline-block mr-2 mt-2">
                                    <button wire:click="editHoliday({{$holiday->id}})" class="focus:outline-none text-white text-sm py-2 px-2 rounded-md bg-blue-500 hover:bg-blue-600 hover:shadow-lg flex items-center">
                                        <svg class="w-4 h-4 " xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                          </svg>


                                        </button>
                                </div>
                                <div class="inline-block mr-2 mt-2">
                                    <button wire:click="deleteHoliday('{{$holiday->hashed}}')"  class="focus:outline-none text-white text-sm py-2 px-2 rounded-md bg-red-500 hover:bg-red-600 hover:shadow-lg flex items-center">
                                        <svg class="w-4 h-4 " xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                          </svg>


                                    </a>
                                </button>
                            </div>
                        </div>
                    </td>


                </tr>
            @endforeach



        </tbody>
    </table>
    <div class="pt-4">
        {{ $holidays->links() }}
    </div>
</div>
@include('livewire.includes.modal')
<script>
    document.addEventListener('livewire:load', function() {
        @if($holiday_id)
 flatpickr(".date", {
        mode: "range",
        dateFormat: 'Y-m-d'
    }).setDate("{{$startDate}} to {{$endDate}}", true);
    @else
    flatpickr(".date", {
        mode: "range",
        dateFormat: 'Y-m-d'
    })
    @endif

        Livewire.on('message', postId => {
            MicroModal.show('modal-message');
        });

    })

</script>

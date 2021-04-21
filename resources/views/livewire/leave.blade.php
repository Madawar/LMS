<div class="p-2">
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    @if ($errors->any())
        <div class="alert alert-error">
            <div class="flex-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    class="w-6 h-6 mx-2 stroke-current">
                    <!---->
                    <!---->
                    <!---->
                    <!---->
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                    </path>
                    <!---->
                    <!---->
                    <!---->
                    <!---->
                    <!---->
                    <!---->
                    <!---->
                    <!---->
                    <!---->
                    <!---->
                    <!---->
                    <!---->
                    <!---->
                    <!---->
                    <!---->
                    <!---->
                    <!---->
                    <!---->
                    <!---->
                    <!---->
                    <!---->
                </svg>
                <label>
                    {!! implode('', $errors->all('<div>:message</div>')) !!}
                </label>
            </div>
        </div>

    @endif
    <div class="flex flex-col md:flex-row space-x-5">
        <div class="flex flex-auto">
            <div class="flex flex-col w-full">
                <label class="leading-loose">Date: </label>
                <div class=" focus-within:text-gray-600 text-gray-400">
                    <input type="text" placeholder="Date" wire:model="date"
                        class="date pr-4 pl-2 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300  focus:outline-none text-gray-600 @error('date') border-red-500 @enderror">
                    @error('date') <div class="error">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>
        <div class="flex flex-auto">
            <div class="flex flex-col w-full">
                <label class="leading-loose">Leave Type:</label>
                <div class=" focus-within:text-gray-600 text-gray-400">
                    <select type="text" placeholder="Leave Type" wire:model="leaveType" wire:change="calculateDays"
                        class="pr-4 pl-2 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300  focus:outline-none text-gray-600 @error('leaveType') border-red-500 @enderror">
                        <option value="">Please Choose ({{ $leaveDays }} Days)</option>
                        @if ($leaveDays < 1)
                            <option value="unpaid">Unpaid Leave</option>
                            <option value="maternity">Maternity Leave</option>
                            <option value="paternity">Paternity Leave</option>
                        @else
                            <option value="maternity">Maternity Leave</option>
                            <option value="paternity">Paternity Leave</option>
                            <option value="annual">Annual</option>
                        @endif


                    </select>
                    @error('leaveType') <div class="text-red-600">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>
    </div>
    <hr class="mt-2" />
    <div>
        @if (!$calculation)
            <div class="alert alert-info mt-2">
                <div class="flex-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="w-6 h-6 mx-2 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <label>Kindly Select a Date Range and select the leave Type you want, if you have no leave days the
                        system will force you to take unpaid leave, see below example</label>
                </div>
            </div>
            <div class="grid justify-items-center mt-2">
                <video width="80%" controls loop autoplay class="border shadow">
                    <source src="{{ asset('fill.mp4') }}" type="video/mp4">
                    <source src="{{ asset('fill.mp4') }}" type="video/ogg">
                    Your browser does not support the video tag.
                </video>
            </div>
        @endif
        @if ($calculation)
            <table class="table-auto w-full mt-5" wire:loading.class="cursor-wait">
                <thead>
                    <tr class="bg-gray-400">

                        <th class="pr-5 pl-5 border-r border-t border-l border-gray-300 cursor-pointer">Week Days</th>
                        <th class="pr-5 pl-5 border-r border-t border-l border-gray-300 cursor-pointer">Saturdays</th>
                        <th class="pr-5 pl-5 border-r border-t border-l border-gray-300 cursor-pointer">Sundays</th>
                        <th class="pr-5 pl-5 border-r border-t border-l border-gray-300 cursor-pointer">Public Holidays
                        </th>
                        <th class="pr-5 pl-5 border-r border-t border-l border-gray-300 cursor-pointer">Days Taken</th>

                    </tr>
                </thead>
                <tbody>

                    <tr>

                        <td class="p-3 border border-r border-gray-50">{{ count($calculation['weekdays']) }}</td>
                        <td class="p-3 border border-r border-gray-50">{{ count($calculation['saturdays']) }}</td>
                        <td class="p-3 border border-r border-gray-50">{{ count($calculation['sundays']) }}</td>
                        <td class="p-3 border border-r border-gray-50">{{ count($calculation['holidays']) }}</td>
                        <td class="p-3 border border-r border-gray-50">{{ $calculation['calculation'] }}</td>

                    </tr>


                </tbody>
            </table>

            <div class="flex flex-col md:flex-row mt-2" wire:ignore>
                <div class="flex flex-auto w-full">
                    @php
                        $selected = json_encode($selected);
                    @endphp

                    <div wire:ignore class="w-full">
                        <label class="leading-loose">Select Staff to relieve you:</label>
                        <x-input.selectmultiple wire:ignore wire:model="relievers" prettyname="relievers"
                            :max="$max_relievers" :options="$relievers_list" :selected="$selected" />

                    </div>

                </div>
            </div>

            <div class="mt-2">
                <table class="table-auto w-full mt-5" wire:loading.class="cursor-wait">
                    <thead>
                        <tr class="bg-gray-400">
                            <th class="pr-5 pl-5 border-r border-t border-l border-gray-300 cursor-pointer">Name</th>
                            <th class="pr-5 pl-5 border-r border-t border-l border-gray-300 cursor-pointer">Function
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (is_array($relievers_display))
                            @foreach ($relievers_display as $user)
                                <tr>
                                    <td class="p-3 border border-r border-gray-50">{{ $user['staff'] }}</td>
                                    <td class="p-3 border border-r border-gray-50">{{ $user['function'] }}</td>



                                </tr>
                            @endforeach
                        @endif

                    </tbody>
                </table>
            </div>

            <div class="mt-2">
                <div class="grid justify-items-stretch">
                    <div class="justify-self-center">
                        @if ($leaveid)
                            <button
                                class="inline-block px-6 py-2 text-xs font-medium leading-6 text-center text-white uppercase transition bg-green-500 rounded shadow ripple hover:shadow-lg hover:bg-green-600 focus:outline-none"
                                wire:click="updateLeave"> Update Leave</button>
                            <div class="flex items-center bg-blue-900 text-white text-sm font-bold px-4 py-3"
                                wire:loading wire:target="updateLeave">
                                Updating Leave
                            </div>
                        @else
                            <button
                                class="inline-block px-6 py-2 text-xs font-medium leading-6 text-center text-white uppercase transition bg-green-500 rounded shadow ripple hover:shadow-lg hover:bg-green-600 focus:outline-none"
                                wire:click="saveLeave"> Save Leave</button>
                            <div class="flex items-center bg-blue-900 text-white text-sm font-bold px-4 py-3"
                                wire:loading wire:target="saveLeave">
                                Saving Leave
                            </div>
                        @endif
                    </div>
                </div>
            </div>


        @endif
        @include('livewire.includes.modal')
    </div>

    <script>
        document.addEventListener('livewire:load', function() {
            @if ($leaveid)
                flatpickr(".date", {
                mode: "range",
                dateFormat: 'Y-m-d'
                }).setDate("{{ $startDate }} to {{ $endDate }}", true);
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

</div>

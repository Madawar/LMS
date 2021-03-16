<div class="p-2">
    <div class="mt-2">
        <div class="my-2 flex sm:flex-row flex-col justify-center bg-gray-100 p-2 shadow-sm">
            <div class="flex flex-row mb-1 sm:mb-0">
                <div class="relative">
                    <select wire:model="pagination"
                        class="appearance-none h-full rounded-l border block appearance-none w-full bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                    </select>

                </div>

                <div class="relative">
                    <select wire:model="filter"
                        class="appearance-none h-full rounded-r border-t sm:rounded-r-none sm:border-r-0 border-r border-b block appearance-none w-full bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:border-l focus:border-r focus:bg-white focus:border-gray-500">
                        <option value="null">All</option>
                        <option value="1">Finalized</option>
                        <option value="unapproved">Unapproved</option>
                        <option value="review">For Review By Osh Department</option>
                        <option value="unresponsive">Assigned But No Response</option>
                        <option value="toMe">Assigned To Me</option>
                    </select>

                </div>
            </div>
            <div class="block relative">
                <span class="h-full absolute inset-y-0 left-0 flex items-center pl-2">
                    <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current text-gray-500">
                        <path
                            d="M10 4a6 6 0 100 12 6 6 0 000-12zm-8 6a8 8 0 1114.32 4.906l5.387 5.387a1 1 0 01-1.414 1.414l-5.387-5.387A8 8 0 012 10z">
                        </path>
                    </svg>
                </span>
                <input placeholder="Search" wire:model="search"
                    class="appearance-none rounded-r rounded-l sm:rounded-l-none border border-gray-400 border-b block pl-8 pr-6 py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none" />
            </div>

        </div>
        <div class="grid justify-items-stretch">
            <div class="justify-self-center">
                <div wire:loading class="bg-green-700 text-white p-1 shadow-sm">
                    Loading ...
                </div>
            </div>
        </div>
        <table class="table-auto w-full" wire:loading.class="cursor-wait">
            <thead>
                <tr class="bg-gray-400">
                    <th class="pr-5 pl-5 border-r border-t border-l border-gray-300 cursor-pointer">#</th>
                    <th wire:click.prevent="sortBy('staff')"
                        class="pr-5 pl-5  border-r border-t border-gray-300 cursor-pointer">Staff</th>
                    <th wire:click.prevent="sortBy('staff')"
                        class="pr-5 pl-5  border-r border-t border-gray-300 cursor-pointer">Department</th>
                    <th wire:click.prevent="sortBy('staff')"
                        class="pr-5 pl-5  border-r border-t border-gray-300 cursor-pointer">Email</th>
                    <th wire:click.prevent="sortBy('staff')"
                        class="pr-5 pl-5  border-r border-t border-gray-300 cursor-pointer">Leave Days</th>
                    <th wire:click.prevent="sortBy('staff')"
                        class="pr-5 pl-5  border-r border-t border-gray-300 cursor-pointer">Employed On</th>
                        <th wire:click.prevent="sortBy('staff')"
                        class="pr-5 pl-5  border-r border-t border-gray-300 cursor-pointer">Actions</th>


                </tr>
            </thead>
            <tbody>
                @foreach ($staff_list as $stf)
                    <tr class="cursor-pointer">
                        <td>{{ $stf->pno }}</td>
                        <td class="p-3 border border-r border-gray-50">
                            {{ $stf->staff }}</td>
                        <td class="p-3 border border-r border-gray-50">
                            @if($stf->dep)
                            {{ $stf->dep->department }}
                            @endif
                        </td>
                        <td class="p-3 border border-r border-gray-50">{{ $stf->email }}</td>
                        <td class="p-3 border border-r border-gray-50">{{ $stf->leave_days }}</td>
                        <td class="p-3 border border-r border-gray-50">
                            {{ Carbon\Carbon::parse($stf->dateOfEmployment)->format('j-M-y') }}<br />
                        </td>
                        <td>
                            <div class="w-full py-3">
                                <div class="inline-block mr-1 ">
                                    <a wire:click="editStaff({{ $stf->id }})"  class="focus:outline-none text-white text-sm py-2 px-2 rounded-md bg-blue-500 hover:bg-blue-600 hover:shadow-lg flex items-center">

                                        <svg class="w-4 h-4 " xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                          </svg>


                                    </a>
                                </div>
                                <div class="inline-block mr-1 ">
                                    <button wire:click="resetPassword({{$stf->id}})"  class="focus:outline-none text-white text-sm py-2 px-2 rounded-md bg-green-500 hover:bg-green-600 hover:shadow-lg flex items-center">
                                        <svg class="w-4 h-4 "  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                          </svg>
                                        </button>
                                </button>
                            </div>

                        <div class="inline-block mr-1 ">
                            <button wire:click="resignStaff({{$stf->id}})"  class="focus:outline-none text-white text-sm py-2 px-2 rounded-md bg-yellow-500 hover:bg-yellow-600 hover:shadow-lg flex items-center">

                                  <svg class="w-4 h-4 " xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6" />
                                  </svg>


                                </button>
                        </button>
                    </div>
                        </div>

                        </td>

                    </tr>
                @endforeach



            </tbody>
        </table>
        @include('livewire.includes.modal')
        <div class="pt-4">
            {{ $staff_list->links() }}
        </div>
        <div class="grid justify-items-stretch">
            <div class="justify-self-center ">
                <div class="bg-green-700 text-white p-5 inline-block cursor-pointer" wire:click="addStaff">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 inline-block" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Add Staff
                </div>


            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal micromodal-slide w-full" id="modal-1" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
            <div class="modal__container w-1/2" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
                <header class="modal__header">
                    <h2 class="modal__title" id="modal-1-title">
                        Staff Info
                    </h2>
                    <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
                </header>
                <main class="modal__content " id="modal-1-content">
                    <div class="flex flex-row space-x-5">
                        <div class="flex-auto">
                            <div class="flex flex-col w-full">
                                <label class="leading-loose">Staff: </label>
                                <div class=" focus-within:text-gray-600 text-gray-400">
                                    <input type="text" placeholder="Staff Name" wire:model="staff"
                                        class=" pr-4 pl-2 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300  focus:outline-none text-gray-600 @error('staff') border-red-500 @enderror">
                                    @error('staff') <div class="error">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="flex-auto">
                            <div class="flex flex-col w-full">
                                <label class="leading-loose">Payroll Number: </label>
                                <div class=" focus-within:text-gray-600 text-gray-400">
                                    <input type="text" placeholder="Payroll Number" wire:model="pno"
                                        class=" pr-4 pl-2 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300  focus:outline-none text-gray-600 @error('pno') border-red-500 @enderror">
                                    @error('pno') <div class="error">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="flex-auto">
                            <div class="flex flex-col w-full">
                                <label class="leading-loose">Date Of employment </label>
                                <div class="focus-within:text-gray-600 text-gray-400">
                                    <input type="text" placeholder="Date of employment" wire:model="dateOfEmployment"
                                        class="date  pr-4 pl-2 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300  focus:outline-none text-gray-600 @error('dateOfEmployment') border-red-500 @enderror">
                                    @error('dateOfEmployment') <div class="error">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Start Row -->
                    <div class="flex flex-row space-x-5">
                        <div class="flex-auto">
                            <div class="flex flex-col w-full">
                                <label class="leading-loose">Leave Days: </label>
                                <div class=" focus-within:text-gray-600 text-gray-400">
                                    <input type="text" placeholder="Current Leave Days" wire:model="leave_days"
                                        class=" pr-4 pl-2 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300  focus:outline-none text-gray-600 @error('leave_days') border-red-500 @enderror">
                                    @error('leave_days') <div class="error">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="flex-auto">
                            <div class="flex flex-col w-full">
                                <label class="leading-loose">Leave Increments: </label>
                                <div class=" focus-within:text-gray-600 text-gray-400">
                                    <input type="text" placeholder="Leave Increments" wire:model="leaveIncrements"
                                        class=" pr-4 pl-2 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300  focus:outline-none text-gray-600 @error('leaveIncrements') border-red-500 @enderror">
                                    @error('leaveIncrements') <div class="error">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="flex-auto">
                            <div class="flex flex-col w-full">
                                <label class="leading-loose">Department:</label>
                                <div class=" focus-within:text-gray-600 text-gray-400">
                                    <select type="text" placeholder="Department Manager" wire:model="department"
                                        class="pr-4 pl-2 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300  focus:outline-none text-gray-600 @error('department') border-red-500 @enderror">
                                        @foreach ($departments as $department)
                                            <option>Please Choose ... </option>
                                            <option value="{{ $department->id }}">{{ $department->department }}
                                            </option>
                                        @endforeach

                                    </select>
                                    @error('department') <div class="text-red-600">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <!---->
                    <div class="flex flex-row space-x-5">
                        <div class="flex-auto">
                            <div class="flex flex-col w-full">
                                <label class="leading-loose">Email: </label>
                                <div class=" focus-within:text-gray-600 text-gray-400">
                                    <input type="text" placeholder="Email" wire:model="email"
                                        class=" pr-4 pl-2 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300  focus:outline-none text-gray-600 @error('email') border-red-500 @enderror">
                                    @error('email') <div class="error">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="flex-auto">
                            <div class="flex flex-col w-full">
                                <label class="leading-loose">Working Days:</label>
                                <div class=" focus-within:text-gray-600 text-gray-400">
                                    <select type="text" placeholder="Working Days" wire:model="workingDays"
                                        class="pr-4 pl-2 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300  focus:outline-none text-gray-600 @error('workingDays') border-red-500 @enderror">

                                        <option>Please Choose ..</option>
                                        <option value="[1,2,3,4,5]">Monday To Friday</option>
                                        <option value="[1,2,3,4,5,6]">Monday To Saturday</option>
                                        <option value="[1,2,3,4,5,6,7]">Shift Employee</option>


                                    </select>
                                    @error('workingDays') <div class="text-red-600">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="modal__footer">
                    <div class="mt-2">
                        <div class="grid justify-items-stretch">
                            <div class="justify-self-center">
                                @if ($staff_id)
                                    <button
                                        class="inline-block px-6 py-2 text-xs font-medium leading-6 text-center text-white uppercase transition bg-green-500 rounded shadow ripple hover:shadow-lg hover:bg-green-600 focus:outline-none"
                                        wire:click="updateStaff({{ $staff_id }})"> Update Staff</button>
                                    <div class="flex items-center bg-blue-900 text-white text-sm font-bold px-4 py-3"
                                        wire:loading wire:target="updateStaff">
                                        Updating Staff
                                    </div>
                                @else
                                    <button
                                        class="inline-block px-6 py-2 text-xs font-medium leading-6 text-center text-white uppercase transition bg-green-500 rounded shadow ripple hover:shadow-lg hover:bg-green-600 focus:outline-none"
                                        wire:click="saveStaff"> Save Staff</button>
                                    <div class="flex items-center bg-blue-900 text-white text-sm font-bold px-4 py-3"
                                        wire:loading wire:target="saveStaff">
                                        Saving Staff
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </footer>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', function() {
            flatpickr(".date", {

                dateFormat: 'Y-m-d'
            });

            Livewire.on('edit', postId => {
                flatpickr(".date", {

                    dateFormat: 'Y-m-d'
                });
                MicroModal.show('modal-1');
            });

            Livewire.on('message', postId => {
                MicroModal.show('modal-message');
            });
        })

    </script>
</div>

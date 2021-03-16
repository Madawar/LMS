<div class="p-2">
    {{-- In work, do what you enjoy. --}}



    <div>
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
                    <th wire:click.prevent="sortBy('department')"
                        class="pr-5 pl-5  border-r border-t border-gray-300 cursor-pointer">Department</th>

                    <th class="pr-5 pl-5  border-r border-t border-gray-300 cursor-pointer">Managers</th>
                    <th class="pr-5 pl-5  border-r border-t border-gray-300 cursor-pointer">Supervisors</th>


                </tr>
            </thead>
            <tbody>
                @foreach ($departments as $department)
                    <tr class="cursor-pointer">
                        <td class="p-3 border border-r border-gray-50">{{ $loop->index + 1 }}</td>
                        <td wire:click="editDepartment({{ $department->id }})"
                            class="p-3 border border-r border-gray-50">{{ $department->department }}</td>
                        <td wire:click="editDepartment({{ $department->id }})"
                            class="p-3 border border-r border-gray-50">
                            @if (isset($department->manager))
                                {{ $department->manager->staff }}
                            @endif
                        </td>
                        <td wire:click="editDepartment({{ $department->id }})"
                            class="p-3 border border-r border-gray-50">
                            @foreach ($department->supervisors as $supervisor)
                                {{ $supervisor->staff }},
                            @endforeach
                        </td>


                    </tr>
                @endforeach



            </tbody>
        </table>
        <div class="pt-4">
            {{ $departments->links() }}
        </div>
        <div class="grid justify-items-stretch">
            <div class="justify-self-center ">
                <div class="bg-green-700 text-white p-5 inline-block cursor-pointer" wire:click="addDepartment" >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      Add Department
                </div>


            </div>
        </div>
    </div>



    <div wire:ignore.self class="modal micromodal-slide" id="modal-1" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
            <div class="modal__container w-1/2" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
                <header class="modal__header">
                    <h2 class="modal__title" id="modal-1-title">
                        Department Info
                    </h2>
                    <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
                </header>
                <main class="modal__content " id="modal-1-content">
                    <div>
                        <div class="flex flex-row space-x-5">
                            <div class="flex-auto">
                                <div class="flex flex-col w-full">
                                    <label class="leading-loose">Department: </label>
                                    <div class=" focus-within:text-gray-600 text-gray-400">
                                        <input type="text" placeholder="Department" wire:model="department"
                                            class=" pr-4 pl-2 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300  focus:outline-none text-gray-600 @error('department') border-red-500 @enderror">
                                        @error('department') <div class="error">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="flex-auto">
                                <div class="flex flex-col w-full">
                                    <label class="leading-loose">Number of Relievers: </label>
                                    <div class=" focus-within:text-gray-600 text-gray-400">
                                        <input type="text" placeholder="Number Of Relievers"
                                            wire:model="number_of_relievers"
                                            class=" pr-4 pl-2 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300  focus:outline-none text-gray-600 @error('number_of_relievers') border-red-500 @enderror">
                                        @error('number_of_relievers') <div class="error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="flex-auto">
                                <div class="flex flex-col w-full">
                                    <label class="leading-loose">Department Manager: {{$department_manager}}</label>
                                    <div class=" focus-within:text-gray-600 text-gray-400">
                                        <select type="text" placeholder="Department Manager"
                                            wire:model="department_manager"
                                            class="pr-4 pl-2 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300  focus:outline-none text-gray-600 @error('department_manager') border-red-500 @enderror">
                                            <option> Please Choose </option>
                                            @foreach ($staff as $stf)
                                                <option value="{{ $stf->id }}">{{ $stf->staff }}</option>
                                            @endforeach

                                        </select>
                                        @error('department_manager') <div class="text-red-600">{{ $message }}
                                        </div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!----->
                        <div class="flex flex-row space-x-5">

                            <div class="flex-auto">
                                <div class="flex flex-col w-full">
                                    <label class="leading-loose">Department Supervisor:</label>
                                    @php
                                        $selected = json_encode($selected);
                                    @endphp
                                    {{ $selected }}
                                    <div wire:ignore class="w-full">
                                        <x-input.selectmultiple wire:ignore wire:model="supervisors"
                                            prettyname="supervisors" :max="100" :options="$supervisor_list"
                                            :selected="$selected" />
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </main>
                <footer class="modal__footer">

                    <div class="grid justify-items-stretch">
                        <div class="justify-self-center">

                            @if ($department_id != null)
                                <button
                                    class="inline-block px-6 py-2 text-xs font-medium leading-6 text-center text-white uppercase transition bg-green-500 rounded shadow ripple hover:shadow-lg hover:bg-green-600 focus:outline-none"
                                    wire:click="updateDepartment({{ $department_id }})"> Update Department</button>
                                    <div class="flex items-center bg-blue-900 text-white text-sm font-bold px-4 py-3" wire:loading
                                    wire:target="updateDepartment">
                                    Updating Department
                                </div>
                            @else
                                <button
                                    class="inline-block px-6 py-2 text-xs font-medium leading-6 text-center text-white uppercase transition bg-green-500 rounded shadow ripple hover:shadow-lg hover:bg-green-600 focus:outline-none"
                                    wire:click="saveDepartment"> Save Department</button>
                                    <div class="flex items-center bg-blue-900 text-white text-sm font-bold px-4 py-3" wire:loading
                                    wire:target="saveDepartment">
                                    Saving Department
                                </div>
                            @endif
                        </div>
                    </div>

                </footer>
            </div>
        </div>
    </div>





    <script>
        document.addEventListener('livewire:load', function() {

            Livewire.on('edit', postId => {
                MicroModal.show('modal-1');
            });

            Livewire.on('selecting', items => {

            });
        })

    </script>
</div>

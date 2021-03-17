<div>
    <?php
    use App\Http\Controllers\LeaveController;
    use Illuminate\Support\Str;
    ?>
    <div class="my-2 flex sm:flex-row flex-col justify-center bg-gray-100 p-2 shadow-sm border border-gray-400">
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
                    <option value="approved">Finalized</option>
                    <option value="unapproved">Unapproved</option>
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
                    class="pr-5 pl-5  border-r border-t border-gray-300 cursor-pointer">Period</th>
                <th wire:click.prevent="sortBy('staff')"
                    class="pr-5 pl-5  border-r border-t border-gray-300 cursor-pointer">Type</th>
                <th class="w-52" wire:click.prevent="sortBy('staff')"
                    class="pr-5 pl-5  border-r border-t border-gray-300 cursor-pointer">Days</th>
                    <th
                    class="pr-5 pl-5  border-r border-t border-gray-300 cursor-pointer">Actions</th>


            </tr>
        </thead>
        <tbody>
            @foreach ($leaves as $leave)
                <tr class="">
                    <td class="p-3 border border-r border-gray-50 w-2">{{$loop->index+1}}</td>
                    <td class="p-3 border border-r border-gray-50">
                        {{ $leave->raiser->staff }}
                    </td>
                    <td class="p-3 border border-r border-gray-50 text-center">
                        {{ Carbon\Carbon::parse($leave->startDate)->format('j-M-y') }} To {{ Carbon\Carbon::parse($leave->endDate)->format('j-M-y') }} (   {{ $leave->amendedDays }} Days)

                    </td>
                    <td class="p-3 border border-r border-gray-50">
                        {{ Str::upper($leave->leaveType) }}

                    </td>
                    <td class="p-3 border border-r border-gray-50">
                        <div class="flex flex-wrap items-stretch w-full mb-4 relative">
                            <input type="text" value="{{$leave->amendedDays}}"  class="flex-shrink flex-grow flex-auto leading-normal w-6 flex-1 border h-10 border-grey-light rounded rounded-r-none px-3 relative" placeholder="Recipient's username">
                            <div class="flex -mr-px cursor-pointer" wire:click="approveLeave({{$leave->id}},{{$leave->amendedDays}})">
                                <span class="flex items-center leading-normal bg-grey-lighter rounded rounded-l-none border border-l-0 border-grey-light px-3 whitespace-no-wrap text-grey-dark text-sm">Finalize</span>
                            </div>
                        </div>

                    </td>

                    <td class="p-3 border border-r border-gray-50">
                        <div class="inline-block mr-2 mt-2">
                            <div class="w-full py-3">

                            <div class="inline-block mr-1 mt-2">
                                <a href="{{route('toWord', $leave->id)}}" class="focus:outline-none text-white text-sm py-2 px-2 rounded-md bg-green-500 hover:bg-green-600 hover:shadow-lg flex items-center">
                                    <svg class="w-4 h-4 " xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                      </svg>




                                </a>
                            </a>
                        </div>
                        </div>
                    </td>


                </tr>
            @endforeach



        </tbody>
    </table>
    <div class="pt-4">
        {{ $leaves->links() }}
    </div>

</div>

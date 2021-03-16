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
                    class="pr-5 pl-5  border-r border-t border-gray-300 cursor-pointer">Period</th>
                <th wire:click.prevent="sortBy('staff')"
                    class="pr-5 pl-5  border-r border-t border-gray-300 cursor-pointer">Type</th>
                <th wire:click.prevent="sortBy('staff')"
                    class="pr-5 pl-5  border-r border-t border-gray-300 cursor-pointer">Approvers</th>
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
                        {{ Carbon\Carbon::parse($leave->startDate)->format('j-M-y') }}<br />
                       <b> To</b><br />
                        {{ Carbon\Carbon::parse($leave->endDate)->format('j-M-y') }} (   {{ $leave->amendedDays }} Days)

                    </td>
                    <td class="p-3 border border-r border-gray-50">
                        {{ Str::upper($leave->leaveType) }}

                    </td>
                    <td class="p-3 border border-r border-gray-50">
                        <div class="flex flex-row">
                            <div class="">
                            </div>
                        </div>
                        @foreach ($leave->approvers as $approver)
                            <span class="flex flex-row">
                                <div class="flex">
                                    {{ $approver->staff->staff }}
                                </div>
                                <div class="flex">
                                    @if ($approver->approved)
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                            class="h-5 mt-1  text-green-600" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 mt-1  text-red-600"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @endif
                                </div>
                                <br />
                            </span>
                        @endforeach

                    </td>
                    <td>
                        <div class="inline-block mr-2 mt-2">
                            <div class="w-full py-3">
                                <div class="inline-block mr-1 mt-2">
                                    <a href="{{route('leave.edit', $leave->id)}}" class="focus:outline-none text-white text-sm py-2 px-2 rounded-md bg-blue-500 hover:bg-blue-600 hover:shadow-lg flex items-center">
                                        <svg class="w-4 h-4 " xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                          </svg>


                                    </a>
                                </div>
                                <div class="inline-block mr-1 mt-2">
                                    <button wire:click="deleteLeave({{$leave->id}})"  class="focus:outline-none text-white text-sm py-2 px-2 rounded-md bg-red-500 hover:bg-red-600 hover:shadow-lg flex items-center">
                                        <svg class="w-4 h-4 " xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                          </svg>


                                    </a>
                                </button>
                            </div>
                            <div class="inline-block mr-1 mt-2">
                                <a href="{{route('word', $leave->id)}}" class="focus:outline-none text-white text-sm py-2 px-2 rounded-md bg-green-500 hover:bg-green-600 hover:shadow-lg flex items-center">
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

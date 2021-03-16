<p class="p-2">
    {{ $leave->raiser->staff }} has applied for {{ $leave->leaveType }} leave starting
    {{ $leave->startDate }} to
    {{ $leave->endDate }}.
</p>
<p class="p-2">
    They have also requested the below staff to relieve them
</p>
<table class="table-auto w-full mt-5" wire:loading.class="cursor-wait">
    <thead>
        <tr class="bg-gray-400">
            <th class="pr-5 pl-5 border-r border-t border-l border-gray-300 cursor-pointer">Name
            </th>
            <th class="pr-5 pl-5 border-r border-t border-l border-gray-300 cursor-pointer">Approved
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($leave->approvers as $approver)
            <tr>
                <td class="p-3 border border-r border-gray-50">{{ $approver->staff->staff }}</td>
                <td class="p-3 border border-r border-gray-50">
                    @if ($approver->approved)
                        Yes
                    @else
                        No
                    @endif
                </td>



            </tr>
        @endforeach


    </tbody>
</table>

<div class="grid justify-items-stretch">
    <div class="justify-self-center">
        @if ($leave->approvers->where('staff_id', Auth::user()->id)->first()->approved)
            <div class="flex bg-green-200 p-4">
                <div class="mr-4">
                    <div
                        class="h-10 w-10 text-white bg-green-600 rounded-full flex justify-center items-center">
                        <i class="material-icons">done</i>
                    </div>
                </div>
                <div class="flex justify-between w-full">
                    <div class="text-green-600">
                        <p class="mb-2 font-bold">
                            Approved
                        </p>
                        <p class="text-xs">
                            You already approved to relieve.
                        </p>
                    </div>
                    <div class="text-sm text-gray-500">
                        <span>x</span>
                    </div>
                </div>
            </div>

        @else
            <button
                class="inline-block px-6 py-2 text-xs font-medium leading-6 text-center text-white uppercase transition bg-green-500 rounded shadow ripple hover:shadow-lg hover:bg-green-600 focus:outline-none"
                wire:click="approveLeave({{ $leave->id }})"> Approve Leave</button>

            <button
                class="inline-block px-6 py-2 text-xs font-medium leading-6 text-center text-white uppercase transition bg-red-500 rounded shadow ripple hover:shadow-lg hover:bg-red-600 focus:outline-none"
                wire:click="rejectLeave({{ $leave->id }})"> Reject Leave</button>
        @endif
    </div>
</div>

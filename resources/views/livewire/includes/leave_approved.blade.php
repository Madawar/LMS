<p class="p-2">
    Your leave starting
    {{ $leave->startDate }} to
    {{ $leave->endDate }} has been approved.
</p>
<div class="flex bg-red-200 p-4">
    <div class="mr-4">
      <div class="h-10 w-10 text-white bg-red-600 rounded-full flex justify-center items-center">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
      </div>
    </div>
    <div class="flex justify-between w-full">
      <div class="text-red-600">
        <p class="mb-2 font-bold">
          Your Leave hasn't been finalized
        </p>
        <p class="text-xs">
          Please note that your Leave has not been finalized and you will need to print it out and hand it over to HR department.
          This Notification will remain unread until the HR department finalizes on your application.
        </p>
      </div>

    </div>
  </div>
<p class="p-2">
    The below staff Relieved you
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

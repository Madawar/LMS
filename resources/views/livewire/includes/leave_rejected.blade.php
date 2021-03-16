<p class="p-2">
    Your leave starting
    {{ $leave->startDate }} to
    {{ $leave->endDate }} has been rejected.
</p>
<div class="flex bg-red-200 p-4">
    <div class="mr-4">
        <div class="h-10 w-10 text-white bg-red-600 rounded-full flex justify-center items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
    </div>
    <div class="flex justify-between w-full">
        <div class="text-red-600">
            <p class="mb-2 font-bold">
                Your Leave Relieval has been Rejected
            </p>
            <p class="text-xs">
                Please note that your Leave has been rejected by {{ $notification->data['rejecter']['name'] }}.
                <br />
                Please reraise your leave without this staff for approvals
            </p>
        </div>

    </div>
</div>
<p class="p-2">
<div class="grid justify-items-stretch">
    <div class="justify-self-center">

        <a class="inline-block px-6 py-2 text-xs font-medium leading-6 text-center text-white uppercase transition bg-green-500 rounded shadow ripple hover:shadow-lg hover:bg-green-600 focus:outline-none" href="">
             Ammend Leave
        </a>



    </div>
</div>
</p>

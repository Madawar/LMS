<div class="h-full">
    <div class="grid   md:grid-cols-3 md:divide-x divide-gray divide-opacity-25  h-full">
        <div class=" h-full">
            <div class="text-center border-b border-gray-300 p-5 text  shadow-sm">Notifications</div>
            <div class="flex mb-1">
                @if ($filter == 'unread')
                    <a wire:click="filterNotifications('unread')"
                        class="cursor-pointer flex-grow text-indigo-500 border-indigo-500 border-b-2  py-2  px-1 inline-flex items-center text-sm">
                    @else
                        <a wire:click="filterNotifications('unread')"
                            class="cursor-pointer flex-grow  border-b-2  py-2  px-1 inline-flex items-center text-sm">
                @endif
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    class="h-6 w-6 pr-1">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                Unread ({{ $unReadCount }})
                </a>
                @if ($filter == 'read')
                    <a wire:click="filterNotifications('read')"
                        class="cursor-pointer flex-grow text-indigo-500 border-indigo-500 border-b-2  py-2  px-1 inline-flex items-center text-sm">
                    @else
                        <a wire:click="filterNotifications('read')"
                            class="cursor-pointer flex-grow  border-b-2  py-2  px-1 inline-flex items-center text-sm">
                @endif
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    class="h-6 w-6 pr-1">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                </svg>
                Read ({{ $readCount }})
                </a>

            </div>
            <div wire:loading wire:target="filterNotifications" class="w-full bg-green-800 text-white text-center p-2">
                Loading ...
            </div>
            @foreach ($notifications as $notice)
                @if ($notice->type == 'App\Notifications\LeaveRaised')
                    <div wire:click="readNotification('{{ $notice->id }}')"
                        class="border-b border-gray-200 hover:bg-blue-200 cursor-pointer">
                        <p class="p-2">
                            {{ $notice->data['raiser'] }} has requested you relieve him from
                            <b>{{ \Carbon\Carbon::parse($notice->data['startDate'])->format('jS M, Y') }}</b>
                            to
                            <b>{{ \Carbon\Carbon::parse($notice->data['endDate'])->format('jS M, Y') }}</b>
                        </p>
                    </div>
                @endif
                @if ($notice->type == 'App\Notifications\LeaveApproved')
                    <div wire:click="readNotification('{{ $notice->id }}')"
                        class="border-b border-gray-200 hover:bg-blue-200 cursor-pointer">
                        <p class="p-2">
                            Your Leave application for
                            <b>{{ \Carbon\Carbon::parse($notice->data['startDate'])->format('jS M, Y') }}</b>
                            to
                            <b>{{ \Carbon\Carbon::parse($notice->data['endDate'])->format('jS M, Y') }}</b>
                            has been approved.
                        </p>
                    </div>
                @endif
                @if ($notice->type == 'App\Notifications\LeaveRelieveRejected')
                    <div wire:click="readNotification('{{ $notice->id }}')"
                        class="border-b border-gray-200 hover:bg-blue-200 cursor-pointer">
                        <p class="p-2">
                            Your Leave application for

                            has been rejected by {{ $notice->data['rejecter']['name'] }}.
                        </p>
                    </div>
                @endif


            @endforeach
            <div class="mt-2">

            </div>
        </div>

        <div class="col-span-2">
            <div class="text-center border-b border-gray-300 p-5 text  shadow-sm">Message</div>
            <div class="p-2">
                <div wire:loading wire:target="readNotification" class="w-full bg-green-800 text-white text-center p-2">
                    Loading ...
                </div>
                @if (!$leave)
                    <div class="flex bg-blue-200 p-4">
                        <div class="mr-4">
                            <div class="h-10 w-10 text-white bg-blue-600 rounded-full flex justify-center items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex justify-between w-full">
                            <div class="text-blue-600">
                                <p class="mb-2 font-bold">
                                    Get Started
                                </p>
                                <p class="text-xs">
                                    Please Click on a notification on the left to act on it
                                </p>
                            </div>

                        </div>
                    </div>
                @else

                    @if ($notification->type == 'App\Notifications\LeaveRaised')
                        @include('livewire.includes.leave_raised')
                    @elseif($notification->type == 'App\Notifications\LeaveApproved')
                        @include('livewire.includes.leave_approved')
                    @elseif($notification->type =='App\Notifications\LeaveRelieveRejected')
                    @include('livewire.includes.leave_rejected')
                    @endif
                @endif
            </div>
        </div>

    </div>

</div>

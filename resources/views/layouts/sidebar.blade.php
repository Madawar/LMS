<div class="flex w-full max-w-xs p-4 bg-white shadow">
    <?php use App\Http\Controllers\LeaveController;?>
    <?php use App\Http\Controllers\DepartmentController;?>
    <?php use App\Http\Controllers\InsightController;?>
    <?php use App\Http\Controllers\NotificationController;?>
    <?php use App\Http\Controllers\StaffController;?>
    <?php use App\Http\Controllers\ProfileController;?>
    <?php use App\Http\Controllers\HolidayController;?>
    <?php use  App\Models\Incident;?>
    <ul class="flex flex-col w-full">
        <li class="my-px">
            <a href="{{action([LeaveController::class, 'index'])}}"
               class="flex flex-row items-center h-12 px-4 rounded-lg text-gray-600 {{ (request()->is('leave')) ? 'bg-gray-100' : '' }} ">
                <span class="flex items-center justify-center text-lg text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"  class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                      </svg>
                </span>
                <span class="ml-3">Leaves</span>
                <span class="flex items-center justify-center text-sm text-gray-500 font-semibold bg-gray-200 h-6 px-2 rounded-full ml-auto">{{$leaveCount}}</span>
            </a>
        </li>

        <li class="my-px">
            <a href="{{action([DepartmentController::class, 'index'])}}"
               class="flex flex-row items-center h-12 px-4 rounded-lg text-gray-600 hover:bg-gray-100 {{ (request()->is('department')) ? 'bg-gray-100' : '' }} ">
                <span class="flex items-center justify-center text-lg text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                      </svg>
                </span>
                <span class="ml-3">Departments</span>
            </a>
        </li>
        <li class="my-px">
            <a href="{{action([HolidayController::class, 'index'])}}"
               class="flex flex-row items-center h-12 px-4 rounded-lg text-gray-600 hover:bg-gray-100 {{ (request()->is('holiday')) ? 'bg-gray-100' : '' }} ">
                <span class="flex items-center justify-center text-lg text-gray-400">

                      <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                      </svg>
                </span>
                <span class="ml-3">Holiday Managment</span>
            </a>
        </li>
        <li class="my-px">
            <a href="{{action([InsightController::class, 'index'])}}"
               class="flex flex-row items-center h-12 px-4 rounded-lg text-gray-600 hover:bg-gray-100 {{ (request()->is('insight')) ? 'bg-gray-100' : '' }} ">
                <span class="flex items-center justify-center text-lg text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                      </svg>
                </span>
                <span class="ml-3">Insights</span>
            </a>
        </li>

        <li class="my-px">
            <a href="{{action([StaffController::class, 'index'])}}"
               class="flex flex-row items-center h-12 px-4 rounded-lg text-gray-600 hover:bg-gray-100 {{ (request()->is('staff')) ? 'bg-gray-100' : '' }} ">
                <span class="flex items-center justify-center text-lg text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                      </svg>
                </span>
                <span class="ml-3">Staff Managment</span>
            </a>
        </li>

        <li class="my-px">
            <a href="{{action([LeaveController::class, 'create'])}}"
               class="flex flex-row items-center h-12 px-4 rounded-lg text-gray-600 hover:bg-gray-100">
                <span class="flex items-center justify-center text-lg text-green-400">
                    <svg fill="none"
                         stroke-linecap="round"
                         stroke-linejoin="round"
                         stroke-width="2"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         class="h-6 w-6">
                        <path d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </span>
                <span class="ml-3">Fill Out A Leave</span>
            </a>
        </li>
        <li class="my-px">
            <span class="flex font-medium text-sm text-gray-400 px-4 my-4 uppercase">Account</span>
        </li>
        <li class="my-px">
            <a href="{{action([ProfileController::class, 'index'])}}"
               class="flex flex-row items-center h-12 px-4 rounded-lg text-gray-600 hover:bg-gray-100 {{ (request()->is('profile')) ? 'bg-gray-100' : '' }} ">
                <span class="flex items-center justify-center text-lg text-gray-400">
                    <svg fill="none"
                         stroke-linecap="round"
                         stroke-linejoin="round"
                         stroke-width="2"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         class="h-6 w-6">
                        <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </span>
                <span class="ml-3">Profile</span>
            </a>
        </li>
        <li class="my-px">
            <a href="{{action([NotificationController::class, 'index'])}}"
               class="flex flex-row items-center h-12 px-4 rounded-lg text-gray-600 hover:bg-gray-100 {{ (request()->is('notification')) ? 'bg-gray-100' : '' }}">
                <span class="flex items-center justify-center text-lg text-gray-400">
                    <svg fill="none"
                         stroke-linecap="round"
                         stroke-linejoin="round"
                         stroke-width="2"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         @if($notificationCount > 0)
                         class="h-6 w-6 animate-ping text-red-600">
                         @else
                         class="h-6 w-6">
                         @endif
                        <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                </span>
                <span class="ml-3">Notifications</span>
                <span class="flex items-center justify-center text-sm text-gray-500 font-semibold bg-gray-200 h-6 px-2 rounded-full ml-auto">{{$notificationCount}}</span>
            </a>
        </li>

        <li class="my-px">
            <form method="POST" action="{{ route('logout')}}">
                @csrf
            <a href="#" onclick="event.preventDefault();
            this.closest('form').submit();"
               class="flex flex-row items-center h-12 px-4 rounded-lg text-gray-600 hover:bg-gray-100">
                <span class="flex items-center justify-center text-lg text-red-400">
                    <svg fill="none"
                         stroke-linecap="round"
                         stroke-linejoin="round"
                         stroke-width="2"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         class="h-6 w-6">
                        <path d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                    </svg>
                </span>
                <span class="ml-3">Logout</span>
            </a>
        </form>
        </li>
    </ul>
</div>

<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ env('APP_NAME') }}</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('/favicon.ico') }}">
    @livewireStyles
</head>

<body>
    @include('layouts.header')
    <div class=" mx-auto  ">
        <div class="grid md:grid-cols-5 md:divide-x divide-gray divide-opacity-25  gap-3">
            @include('layouts.sidebar')
            <div class=" col-span-4 border border-gray-50 shadow">
                @if (Auth::user()->unreadNotifications->count() > 0)
                    <div class="border-b border-gray-50 p-5">
                        <div class="flex bg-pink-700 p-4">
                            <div class="mr-4">
                                <div
                                    class="h-10 w-10 text-white bg-orange-600 rounded-full flex justify-center items-center">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex justify-between w-full">
                                <div class="text-orange-600">
                                    <p class="mb-2 font-bold">
                                        Active Notifications
                                    </p>
                                    <p class="text-xs">
                                        Dear {{ Auth::user()->name }} you have unprocessed notifications please click
                                        here to work on them.
                                    </p>
                                </div>
                                <div class="text-sm text-gray-500">
                                    <span>x</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @yield('content')
            </div>

        </div>

    </div>
    @livewireScripts
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/plugins.js') }}"></script>

    @yield('jquery')
</body>

</html>

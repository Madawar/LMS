@extends('layouts.app')

@section('content')
    <div class="p-2">
        @if (!$verified)
            <div class="border-b border-gray-50 p-5">
                <div class="flex bg-pink-700 p-4">
                    <div class="mr-4">
                        <div class="h-10 w-10 text-white bg-orange-600 rounded-full flex justify-center items-center">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex justify-between w-full">
                        <div class="text-orange-600">
                            <p class="mb-2 font-bold">
                                Update Your info
                            </p>
                            <p class="text-xs">
                                Dear {{ Auth::user()->name }} please update your personal information only afske emails
                                are allowed.
                            </p>
                        </div>
                        <div class="text-sm text-gray-500">
                            <span>x</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <form method="post" action="{{ route('profile.store') }}">
            <div class="flex flex-col w-full">
                <label class="leading-loose">Email: </label>
                <div class=" focus-within:text-gray-600 text-gray-400">
                    <input type="text" placeholder="Your Email Address" name="email"
                        value="{{ old('email') ?? $staff->email }}"
                        class=" pr-4 pl-2 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300  focus:outline-none text-gray-600 @error('email') border-red-500 @enderror">
                    @error('email') <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="flex flex-col w-full">
                <label class="leading-loose">Telephone: </label>
                <div class=" focus-within:text-gray-600 text-gray-400">
                    <input type="text" name="telephone" placeholder="Your Telephone Number"
                        value="{{ old('relephone') ?? $staff->telephone }}"
                        class=" pr-4 pl-2 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300  focus:outline-none text-gray-600 @error('telephone') border-red-500 @enderror">
                    @error('telephone') <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="flex flex-col w-full">
                <label class="leading-loose">Department: </label>
                <div class=" focus-within:text-gray-600 text-gray-400">
                    <select name="department"
                        class=" pr-4 pl-2 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300  focus:outline-none text-gray-600 @error('department') border-red-500 @enderror">
                        <option>Please Choose</option>
                        @foreach ($departments as $department)

                            <option value="{{ $department->id }}">{{ $department->department }}</option>
                        @endforeach
                    </select>
                    @error('department') <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="flex flex-col w-full">
                <label class="leading-loose">New Password: </label>
                <div class=" focus-within:text-gray-600 text-gray-400">
                    <input type="password" placeholder="New Password" name="password"
                        class=" pr-4 pl-2 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300  focus:outline-none text-gray-600 @error('password') border-red-500 @enderror">
                    @error('password') <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="flex flex-col w-full">
                <label class="leading-loose">New Password Confirm: </label>
                <div class=" focus-within:text-gray-600 text-gray-400">
                    <input type="password" placeholder="New Password Confirm" name="password_confirm"
                        class=" pr-4 pl-2 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300  focus:outline-none text-gray-600 @error('password_confirm') border-red-500 @enderror">
                    @error('password_confirm') <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="grid justify-items-stretch mt-2">
                <div class="justify-self-center">

                    <button type="submit"
                        class="inline-block px-6 py-2 text-xs font-medium leading-6 text-center text-white uppercase transition bg-green-500 rounded shadow ripple hover:shadow-lg hover:bg-green-600 focus:outline-none">
                        Update Settings
                    </button>


                </div>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <input type="hidden" name="detailsVerified" value="1" />
        </form>
    </div>
@endsection

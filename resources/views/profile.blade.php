@extends('layouts.app')

@section('content')
    <div class="p-2">
        <form>
            <div class="flex flex-col w-full">
                <label class="leading-loose">Email: </label>
                <div class=" focus-within:text-gray-600 text-gray-400">
                    <input type="text" placeholder="Your Email Address"
                        class=" pr-4 pl-2 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300  focus:outline-none text-gray-600 @error('email') border-red-500 @enderror">
                    @error('email') <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="flex flex-col w-full">
                <label class="leading-loose">Telephone: </label>
                <div class=" focus-within:text-gray-600 text-gray-400">
                    <input type="text" placeholder="Your Telephone Number"
                        class=" pr-4 pl-2 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300  focus:outline-none text-gray-600 @error('telephone') border-red-500 @enderror">
                    @error('telephone') <div class="error">{{ $message }}</div>
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
        </form>
    </div>
@endsection

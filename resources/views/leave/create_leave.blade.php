@extends('layouts.app')

@section('content')
    <div class="p-2">

        @livewire('leave',['leaveid'=>$id])

    </div>
@endsection

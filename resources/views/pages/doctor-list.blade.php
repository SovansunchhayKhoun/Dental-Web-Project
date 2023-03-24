@extends('layouts.admin')
@section('content')
<main class="">
    <div class="mt-3 px-2 patient-container">
        @forelse($doctors as $doctor)
            <div style="background-color: white"
                class="px-3 py-2 rounded-lg parent-card flex justify-between items-center mb-3">
                <div class="left-section flex flex-col" style="color: #4F9298">
                    <a href=" {{ url('/admin/doctor-list/'.$doctor->id) }}" class="font-bold">
                        {{ $doctor->title }} {{ $doctor->name }}
                        <sup class="font-normal italic">
                            #{{ $doctor->id }}
                        </sup>
                    </a>
                    <div class="text-sm">
                        <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $doctor->email }}" target="_blank"
                            class="text-sm hover:underline hover:cursor-pointer">
                            {{ $doctor->email }}
                            <i class="fa fa-mail-reply"> </i>
                        </a>
                    </div>
                </div>
                {{-- <div class="right-section text-white">
                    <button class="bg-green-400 text-sm px-2 py-1 rounded-md mr-2">
                        Accept
                    </button>
                    <button class="bg-red-500 text-sm px-2 py-1 rounded-md">
                        Decline
                    </button>
                </div> --}}
            </div>
        @empty
            <div class="text-center">
                <span class="font-bold">{{ count($doctors) }}</span> Doctors found
            </div>
        @endforelse
        {{-- <div class="mt-6">
            {{ $patients->appends(['appointment' => request()->query('appointment')])->links() }}
        </div> --}}

    </div>
</main>
@endsection

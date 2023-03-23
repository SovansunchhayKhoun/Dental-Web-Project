@extends('layouts.admin')
@section('content')
	<main class="">
		<x-header title="Patient List"/>
		<div class="mt-3 px-2 patient-container">
			@forelse($patients as $patient)
				<div style="background-color: white"
						 class="px-3 py-2 rounded-lg parent-card flex justify-between items-center mb-3">
					<div class="left-section flex flex-col" style="color: #4F9298">
						<a href=" {{ url('/patient-list/') }}/{{ $patient->id }}" class="font-bold">
							{{ $patient->firstName }} {{ $patient->lastName }}
							<sup class="font-normal italic">
								#{{ $patient->id }}
							</sup>
						</a>
						<div class="text-xs">
							<span class="underline">Phone No</span> >>> <span
								class="italic font-bold">{{ $patient->phoneNum }}</span>
						</div>
						<div class="text-sm">
							Appointment <i class="fa fa-long-arrow-right"></i>
							<span class="text-xs font-bold ">
									{{ $patient->appointmentDate }} |
								</span>
							<a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $patient->email }}" target="_blank"
								 class="text-sm hover:underline hover:cursor-pointer">
								{{ $patient->email }}
								<i class="fa fa-mail-reply"> </i>
							</a>
						</div>
					</div>
					<div class="right-section text-white">
						<button class="bg-green-400 text-sm px-2 py-1 rounded-md mr-2">
							Accept
						</button>
						<button class="bg-red-500 text-sm px-2 py-1 rounded-md">
							Decline
						</button>
					</div>
				</div>
			@empty
				<div class="text-center">
					<span class="font-bold">{{ count($patients) }}</span> patients found
				</div>
			@endforelse
			<div class="mt-6">
				{{ $patients -> appends(['appointment' => request ()->query('appointment')]) -> links() }}
			</div>
		</div>
	</main>
@endsection

@extends('layouts.admin')
@section('content')
	<main class="">
		<x-header title="Pending Appointments"/>
		<div class="mt-3 px-2 patient-container">
			@forelse($patients as $patient)
				<x-patient.patient-item :patient="$patient"/>
				<div class=" {{ auth()->user ()->acc_type != 'admin' ? 'hidden' : ''}} right-section text-white">
					<form action="/admin/mailbox/{{ $patient->id }}" method="POST">
						@csrf
						@method('PATCH')
						<input required type="submit" hidden class="border border-gray-200 rounded p-2 w-full text-black mb-2"
									 name="doctorValue" value="{{ request()->query('doctorValue') }}"  placeholder="{{ request()->query('doctorValue') }}"/>
						<select class="{{ $patient->appointedDoctor == NULL ? '':'hidden' }} text-black" name="doctorValue"
										id="doctorValue">
							@foreach ($doctors as $doctor)
								<option value="{{ $patient->appointedDoctor == NULL ? $doctor->name : $patient->appointedDoctor }}">{{ $doctor->name }}</option>
							@endforeach
						</select>
						
						<button type="submit" class="bg-green-400 text-sm px-2 py-1 rounded-md mr-2 mb-2">
							Accept
						</button>
					</form>
					<form action="/admin/mailbox/{{ $patient->id }}" method="POST">
						@csrf
						@method('DELETE')
						<button class="bg-red-500 text-sm px-2 py-1 rounded-md">
							Decline
						</button>
					</form>
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

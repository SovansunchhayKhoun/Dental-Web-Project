@extends('layouts.admin')
@section('content')
	<main class="">
		<x-header title="Pending Appointments"/>
		<div class="mt-3 px-2 patient-container">
			@forelse($patients as $patient)
				<x-patient.patient-item :patient="$patient" :doctors="$doctors"/>
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

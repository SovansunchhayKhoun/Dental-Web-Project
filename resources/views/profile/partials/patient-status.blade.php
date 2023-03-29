<div style="background-color: white" class="px-3 py-2 rounded-lg parent-card flex justify-between items-center mb-3">
	<x-patient.patient-item :patient="$patient" :doctors="$doctors"/>
	
	<div class="{{ $patient->status == "Approve" ? "hidden" : "" }} text-sm flex">
		<div class="mr-1">
			<form method="POST" action="/admin/update/{{ $patient->id }}">
				@csrf
				@method('PATCH')
				Appointed Doctor <i class="fa fa-long-arrow-right"></i>
				<select class="border px-2 py-1 text-black"
								{{ $patient->appointedDoctor == NULL ? '' : 'disabled' }} name="doctorValue">
					@foreach ($doctors as $doctor)
						<option
							value="{{ $patient->appointedDoctor == NULL ? $doctor->name : $patient->appointedDoctor }}">{{ $patient->appointedDoctor == NULL ? $doctor->name : $patient->appointedDoctor }}</option>
					@endforeach
				</select>
				
				<button type="submit" class="text-white bg-green-400 text-sm px-2 py-1 rounded-md mr-2 mb-2">
					Accept
				</button>
			</form>
		</div>
		<form action="/admin/delete/{{ $patient->id }}" method="POST">
			@csrf
			@method('DELETE')
			<button class="text-white bg-red-500 text-sm px-2 py-1 rounded-md">
				Decline
			</button>
		</form>
	</div>
</div>

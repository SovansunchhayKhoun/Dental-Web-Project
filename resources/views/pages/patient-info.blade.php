@extends('layouts.admin')
@section('content')
	{{--	<div class="h-16 bg-[#C0F3F7] flex justify-center items-center">--}}
	{{--		<h1 class="text-center text-2xl">Patient Name: {{ $appointment->firstName }} {{ $appointment->lastName }}</h1>--}}
	{{--	</div>--}}
	<x-header title=" {{ $appointment->firstName }} {{ $appointment->lastName }}"/>
	<div class="flex p-2">
		<div class="w-6/12 bg-[#FFE2C8] rounded-2xl h-72 justify-center items-center p-5">
			<h1 class="text-xl">Patient No: {{ $appointment->id }}</h1>
			<hr class="border-black">
			<h1 class="text-xl">Phone Number: {{ $appointment->phoneNum }}</h1>
			<h1 class="text-xl">Email: {{ $appointment->email }}</h1>
			<h1 class="text-xl">Date of Birth: 06/06/03</h1>
			<hr class="border-black">
			<h1 class="text-xl">Appointment Date: {{ $appointment->appointmentDate }}</h1>
			<hr class="border-black">
		</div>
		<div class="w-3/12 bg-[#E0E0E0] rounded-2xl mx-2 p-5">
			<h1 class="text-center">Message</h1>
			<hr class="border-black">
			{{ $appointment->message }}
		</div>
		<div class="w-3/12 flex justify-center items-center p-5">
			<div>
				<button class="bg-green-500 md:w-40 lg:w-60 h-12 px-2 m-2 rounded-2xl">Reschedule</button>
				<br>
				<button class="bg-red-500 md:w-40 lg:w-60 h-12 px-2 m-2 rounded-2xl">Cancel</button>
			</div>
		</div>
	</div>
@endsection

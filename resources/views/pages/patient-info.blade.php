{{--@extends('layouts.admin')--}}
@section('content')
	<x-header title="{{ $appointment->firstName.' '.$appointment->lastName }}"/>
	<form class="flex flex-col">
{{--		{{ csrf_field () }}--}}
{{--		@method('PUT')--}}
		<div>
			First Name
			<input class="sb-search-input" type="text" value="{{ $appointment->firstName }}" name="firstName">
		</div>
		<div>
			Last Name
			<input name="lastName" class="sb-search-input" type="text" value="{{ $appointment->lastName }}">
		</div>
		<div>
			Appointed Doctor
			<input name="appointedDoctor" class="sb-search-input" type="text" value="{{ $appointment->appointedDoctor }}">
		</div>
		<div>
			Phone Number
			<input name="phoneNum" class="sb-search-input" type="text" value="{{ $appointment->phoneNum }}">
		</div>
		<div>
			Email
			<input name="email" class="sb-search-input" type="text" value="{{ $appointment->email }}">
		</div>
		<div class="mt-3">
			<a href="{{ url('/appointment/edit/'.$appointment->id) }}"
				 class="p-3 text-white rounded-md bg-orange-300">Confirm</a>
		</div>
	</form>
@endsection

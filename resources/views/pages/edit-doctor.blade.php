@extends('layouts.admin')
@section('content')
	<input type="text" value="{{ $user->name }}" disabled>
	<input type="text" value="{{ $user->email }}" disabled>
	<input type="text" value="{{ $user->specialist }}" disabled>
	<input type="text" value="{{ $user->description }}" disabled>
	<input type="text" value="{{ $user->work_experience }}" disabled>
	<input type="text" value="{{ $user->acc_type }}" disabled>
@endsection

@extends('layouts.master')
@section('content')
<div>
    <input type="text" value="{{ $user->name }}" disabled>
</div>
@endsection


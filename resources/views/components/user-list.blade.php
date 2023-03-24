<li>
{{--	url('/doctor/'.auth()->user ()->name.'/patient-list')--}}
	<a href="{{ url($url) }}">
		<i class="fa fa-th"></i> <span>{{ $userType }}</span>
		<small class="label pull-right label-info {{ $count == 0 ? 'hidden' : '' }}">
			{{ $count }}
		</small>
	</a>
</li>
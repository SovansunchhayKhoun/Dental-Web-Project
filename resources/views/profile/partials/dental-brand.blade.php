{{--		logo--}}
<a href="{{ url ('/') }}" class="flex items-center gap-4 hover:scale-75 transition">
	<div>
		<img style="height:{{ $img_height }}" src="{{ asset ('assets/image/logo.png') }}" alt="">
	</div>
	<div class="font-bold text-xl {{ $text_color }}">
		<p>Smile</p>
		<p style="margin-top: -5px">Line</p>
	</div>
</a>
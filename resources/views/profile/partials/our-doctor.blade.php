@extends('layouts.master')
@section('content')
	<!-- Container for demo purpose -->
	<div class="container py-12 px-6 mx-auto">
		
		<!-- Meet our Doctor Title -->
		<section class="mb-32 text-gray-800 text-center">
			<h2 class="text-3xl font-bold mb-32">Meet our Dentists</h2>
		</section>
		<!-- Meet our Doctor Title -->
		
		<!-- Section: Design Block -->
		<section class="mb-32 text-gray-800 text-center">
			@if(count($doctors) == 0)
				<label> No Doctor</label>
			@endif
			<div class="grid gap-x-6 gap-y-32 lg:gap-x-12 md:grid-cols-3 max-md:gap-y-6">
				@foreach($doctors as $doctor)
					<div class="mb-24 md:mb-0">
						<div class="rounded-lg border shadow-lg h-full block bg-white">
							<div class="flex justify-center">
								<div class="flex justify-center" style="margin-top: -75px">
									<img src="assets/image/1.jpg" class="mx-auto shadow-lg" alt=""
											 style="border-radius: 50%; height:200px"/>
								</div>
							</div>
							<div class="p-6">
								<h5 class="text-lg font-bold mb-4">
									{{ $doctor->title }} {{ $doctor->name }}
									<br>
									<div class="text-sm">
										Specialized in <i class="fa fa-arrow-right"></i> {{ $doctor->specialist }}
									</div>
								</h5>
								<p class="mb-6">{{ $doctor->description }}</p>
								
								<!-- Small icons here -->
								<ul class="list-inside flex mx-auto justify-center">
									<a href="#!" class="px-2"><i class="fa-solid fa-phone fa-xl"></i></a>
									<a href="#!" class="px-2"><i class="fa-brands fa-telegram fa-xl" style="color: #0088cc;"></i></a>
									<a href="#!" class="px-2"><i class="fa-brands fa-square-whatsapp fa-xl" style="color: #25d366;"></i>
									</a>
								</ul>
								<!-- Small icons here -->
							</div>
						</div>
					</div>
				@endforeach
			</div>
		</section>
	</div>
	<!-- Container for demo purpose -->
@endsection
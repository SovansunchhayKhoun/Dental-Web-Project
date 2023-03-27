<div style="background-color: white" class="px-3 py-2 rounded-lg parent-card flex justify-between items-center mb-3">
	<div class="left-section flex flex-col" style="color: #4F9298">
		<a href="{{ url('/appointment/' . $patient->id) }}" class="font-bold">
			{{ $patient->firstName }} {{ $patient->lastName }}
			<sup class="font-normal italic">
				#{{ $patient->id }}
			</sup>
		</a>
		<div class="text-xs">
			<span class="underline">Phone No</span> >>> <span class="italic font-bold">{{ $patient->phoneNum }}</span>
		</div>
		<div class="text-sm">
			Appointment Date <i class="fa fa-long-arrow-right"></i>
			<span class="text-xs font-bold ">
                    {{ $patient->appointmentDate }} |
                </span>
			<a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $patient->email }}" target="_blank"
				 class="text-sm hover:underline hover:cursor-pointer">
				{{ $patient->email }}
				<i class="fa fa-mail-reply"> </i>
			</a>
		</div>
		<div class="text-sm">
			Appointed Doctor <i class="fa fa-long-arrow-right"></i>
			<span class="text-xs font-bold ">
                    {{ $patient->appointedDoctor }}
                </span>
		</div>
	</div>
</div>

{{--@endif--}}
{{--		@else--}}
{{--			<div style="background-color: white"--}}
{{--					 class="px-3 py-2 rounded-lg parent-card flex justify-between items-center mb-3">--}}
{{--				<div class="left-section flex flex-col" style="color: #4F9298">--}}
{{--					<a href="{{ url('/appointment/' . $patient->id) }}" class="font-bold">--}}
{{--						{{ $patient->firstName }} {{ $patient->lastName }}--}}
{{--						<sup class="font-normal italic">--}}
{{--							#{{ $patient->id }}--}}
{{--						</sup>--}}
{{--					</a>--}}
{{--					<div class="text-xs">--}}
{{--						<span class="underline">Phone No</span> >>> <span--}}
{{--							class="italic font-bold">{{ $patient->phoneNum }}</span>--}}
{{--					</div>--}}
{{--					<div class="text-sm">--}}
{{--						Appointment <i class="fa fa-long-arrow-right"></i>--}}
{{--						<span class="text-xs font-bold ">--}}
{{--                        {{ $patient->appointmentDate }} |--}}
{{--                    </span>--}}
{{--						<a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $patient->email }}" target="_blank"--}}
{{--							 class="text-sm hover:underline hover:cursor-pointer">--}}
{{--							{{ $patient->email }}--}}
{{--							<i class="fa fa-mail-reply"> </i>--}}
{{--						</a>--}}
{{--					</div>--}}
{{--					<div class="text-sm">--}}
{{--						Appointed Doctor <i class="fa fa-long-arrow-right"></i>--}}
{{--						<span class="text-xs font-bold ">--}}
{{--                        {{ $patient->appointedDoctor }}--}}
{{--                    </span>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--				<div class="right-section text-white">--}}
{{--					<form action="/admin/mailbox/{{ $patient->id }}" method="POST">--}}
{{--						@csrf--}}
{{--						@method('PATCH')--}}
{{--						<input type="text" class="hidden border border-gray-200 rounded p-2 w-full text-black mb-2"--}}
{{--									 name="doctorValue" value="{{ $patient->appointedDoctor }}"--}}
{{--									 placeholder="{{ $patient->appointedDoctor }}" disabled/>--}}
{{--						<button class="bg-green-400 text-sm px-2 py-1 rounded-md mr-2 mr-2 mb-2">--}}
{{--							Accept--}}
{{--						</button>--}}
{{--					</form>--}}
{{--					--}}
{{--					<form action="/admin/mailbox/{{ $patient->id }}" method="POST">--}}
{{--						@csrf--}}
{{--						@method('DELETE')--}}
{{--						<button class="bg-red-500 text-sm px-2 py-1 rounded-md">--}}
{{--							Decline--}}
{{--						</button>--}}
{{--					</form>--}}
{{--				</div>--}}



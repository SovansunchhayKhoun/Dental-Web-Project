<div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
	<!--left-fixed -navigation-->
	<aside class="sidebar-left">
		<nav class="navbar navbar-inverse">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".collapse"
								aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				
				{{--				brand --}}
				<div class="px-2 py-1">
					@include('profile.partials.dental-brand', [
							($text_color = 'text-white'),
							($img_height = '40px'),
					])
				</div>
			
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="sidebar-menu">
					<li class="header">MAIN NAVIGATION</li>
					<li class="treeview">
						<a href="{{ auth()->user()->acc_type == 'Doctor' ? url('/doctor') : '/admin' }}">
							<i class="fa fa-dashboard"></i> <span>Home</span>
						</a>
					</li>
					@if (auth()->user()->acc_type == 'admin')
						<x-user-list url="/admin/doctor-list" user-type="Doctor List"/>
					@else
						<x-user-list url="/doctor/patient-list"
												 user-type="Patient List"/>
					@endif
					<li>
						<a href="#"><i class="fa fa-angle-right text-red"></i> <span>Important</span></a>
						<ul class="treeview-menu">
							@foreach($doctors as $doctor)
								@if($doctor['acc_type'] == 'Doctor')
									<li class="treeview {{ auth()->user()->acc_type == 'Doctor' ? 'hidden' : '' }}">
										<a href="{{ url('/admin/mailbox/'. $doctor->name) }}">
											<i class="fa fa-envelope"></i> <span>{{ $doctor->name }}</span>
										</a>
									</li>
								@endif
							@endforeach
							{{--								{{ auth()->user()->acc_type == 'Doctor' ? 'hidden' : '' }}--}}
							<li class="treeview">
								<a href="{{ auth()->user ()->acc_type == 'Doctor' ? url('/doctor/mailbox') : url ('/admin/mailbox') }}">
									<i class="fa fa-envelope"></i> <span>Mailbox</span>
								</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
			<!-- /.navbar-collapse -->
		</nav>
	</aside>
</div>

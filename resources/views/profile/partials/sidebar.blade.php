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
				
				{{--				brand--}}
				<div class="px-2 py-1">
					@include('profile.partials.dental-brand', [$text_color= 'text-white', $img_height = '40px'])
				</div>
			
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="sidebar-menu">
					<li class="header">MAIN NAVIGATION</li>
					<li class="treeview">
						<a href="{{ auth()->user()->acc_type == 'Doctor' ? url('/doctor/'.auth()->user()->name ) : '/admin' }}">
							<i class="fa fa-dashboard"></i> <span>Home</span>
						</a>
					</li>
					@if(auth()->user()->acc_type == 'admin')
						<x-user-list url="/admin/doctor-list" count="{{$count}}" user-type="Doctor"/>
					@else
						<x-user-list url="/doctor/{{auth()->user ()->name}}/patient-list" count="{{$count}}" user-type="Patients"/>
					@endif
					
					{{--					hidden if acc_type = admin--}}
					<li class="treeview" {{ auth()->user ()->acc_type == 'Doctor' ? "hidden" : "" }}>
						<a href="{{ url('/admin/mailbox') }}">
							<i class="fa fa-envelope"></i> <span>Mailbox</span>
							{{--							patients with no doctor appointed--}}
							<span class="label label-primary1 pull-right {{ $mailCount == 0 ? 'hidden' : '' }}">{{ $mailCount }}</span>
						</a>
					</li>
					{{--					//hidden if acc_type = admin--}}
					<li class="treeview">
						<a href="#">
							<i class="fa fa-folder"></i> <span>Examples</span>
							<i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="treeview-menu">
							<li><a href="login.html"><i class="fa fa-angle-right"></i> Login</a></li>
							<li><a href="signup.html"><i class="fa fa-angle-right"></i> Register</a></li>
							<li><a href="404.html"><i class="fa fa-angle-right"></i> 404 Error</a></li>
							<li><a href="500.html"><i class="fa fa-angle-right"></i> 500 Error</a></li>
							<li><a href="blank-page.html"><i class="fa fa-angle-right"></i> Blank Page</a></li>
						</ul>
					</li>
					<li class="header">LABELS</li>
					<li><a href="#"><i class="fa fa-angle-right text-red"></i> <span>Important</span></a></li>
				</ul>
			</div>
			<!-- /.navbar-collapse -->
		</nav>
	</aside>
</div>

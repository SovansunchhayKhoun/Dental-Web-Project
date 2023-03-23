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
						<a href="{{ route('admin') }}">
							<i class="fa fa-dashboard"></i> <span>Home</span>
						</a>
					</li>
					<li>
						<a href="{{ route('patient-list') }}">
							<i class="fa fa-th"></i> <span>Patient List</span>
							<small class="label pull-right label-info {{ count($patients) == 0 ? 'hidden' : '' }}">
									{{ $count }}
							</small>
						</a>
					</li>
					<li class="treeview">
						<a href="#">
							<i class="fa fa-envelope"></i> <span>Mailbox</span>
							<i class="fa fa-angle-left pull-right"></i><small class="label pull-right label-info1">08</small><span
								class="label label-primary1 pull-right">02</span></a>
						<ul class="treeview-menu">
							<li><a href="inbox.html"><i class="fa fa-angle-right"></i> Mail Inbox</a></li>
							<li><a href="compose.html"><i class="fa fa-angle-right"></i> Compose Mail </a></li>
						</ul>
					</li>
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
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inria+Sans:ital,wght@0,300;0,400;0,700;1,700&family=Montserrat:wght@100;300;400;500;600;700&display=swap');

    img {
        min-height: 60px;
    }

    .underline-animation {
        display: inline-block;
        position: relative;
        color: inherit;
    }

    .underline-animation:after {
        content: '';
        position: absolute;
        width: 100%;
        transform: scaleX(0);
        height: 2px;
        bottom: 0;
        left: 0;
        background-color: black;
        transform-origin: bottom right;
        transition: transform 0.25s ease-out;
        cursor: pointer;
    }

    .underline-animation:hover:after {
        transform: scaleX(1);
        transform-origin: bottom left;
        cursor: pointer;
    }

    @media only screen and (max-width: 768px) {
        .navigation {
            display: none;
        }
    }

    @media only screen and (min-width: 768px) {
        .dropdown-menu {
            display: none;
        }
    }
</style>

<nav class="sticky top-0 bg-white">
	<div class="nav-container shadow-md flex justify-between p-2 items-center">
		@include('profile.partials.dental-brand', [
	$text_color = "text-black",
	$img_height = ''])
		{{--		right side--}}
		<div style="font-family: Monospace">
			<div class="navigation flex gap-4 items-center">
				<a href="{{ url('/') }}" class="p-1 text-lg hover:cursor-pointer underline-animation">Home</a>
				<a href="{{ url('/') }}" class="p-1 text-lg hover:cursor-pointer underline-animation">Services</a>
				<a href="{{ url('/our-doctor') }}" class="p-1 text-lg hover:cursor-pointer underline-animation">Our Doctors</a>
				<a href="{{ url('/') }}" class="p-1 text-lg hover:cursor-pointer underline-animation">Contact</a>
				<a href="{{ url('/') }}" class="p-1 text-lg hover:cursor-pointer underline-animation">Community</a>
				<a style="background-color: #65C7D0" href="{{ url('/appointment') }}"
					 class="px-4 py-2 text-lg italic rounded-full hover:cursor-pointer hover: active:opacity-80">Appointment</a>
			</div>
			{{--			dropdown when small --}}
			<div class="dropdown-menu relative inline-block text-left">
				<div>
					<button type="button" id="dropdownDefaultButton" data-dropdown-toggle="dropdown"
									class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
									aria-expanded="true" aria-haspopup="true">
						Menu
						<svg class="-mr-1 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
							<path fill-rule="evenodd"
										d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
										clip-rule="evenodd"/>
						</svg>
					</button>
				</div>
				<div id="dropdown"
						 class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
						 role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
					<div class="py-1" role="none">
						<!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
						<a href="{{ url('/appointment') }}" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem"
							 tabindex="-1" id="menu-item-2">Appointment</a>
						<a href="{{ url('/') }}" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1"
							 id="menu-item-0">Home</a>
						<a href="{{ url('/') }}" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1"
							 id="menu-item-1">Service</a>
						<a href="{{ url('/') }}" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1"
							 id="menu-item-2">Contact</a>
						<a href="{{ url('/') }}" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1"
							 id="menu-item-2">Community</a>
						<a href="{{ url('/') }}" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1"
							 id="menu-item-2">Cost</a>
					</div>
				</div>
			</div>
		</div>
	</div>

</nav>

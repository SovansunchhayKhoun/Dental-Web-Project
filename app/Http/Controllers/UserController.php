<?php
	
	namespace App\Http\Controllers;
	
	use App\Models\Appointment;
	use App\Models\OurDoctor;
	use Illuminate\Http\Request;
	use App\Models\User;
	use Illuminate\Support\Facades\App;
	use Illuminate\Validation\Rule;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Facades\Hash;
	
	class UserController extends Controller
	{
		// public function create()
		// {
		//     return view('register');
		// }
		public function index ()
		{
			$count = Appointment ::all ();
			return view ( 'pages.doctor-list' , [
				'doctors' => User ::all () ,
				'count' => $count
			] );
		}
		
		public function register ()
		{
			return view ( 'pages.register' );
		}
		
		public function store ( Request $request )
		{
			$formField = $request -> validate ( [
				'name' => 'required|string|min:3' ,
				'email' => [ 'required' , 'email' , Rule ::unique ( 'users' , 'email' ) ] ,
				'password' => 'required|confirmed|min:6' ,
				'title' => 'required' ,
				'specialist' => 'required' ,
				'description' => 'required' ,
				'work_experience' => 'required' ,
			] );
			$formField[ 'acc_type' ] = 'Doctor';
			if ( $request -> hasFile ( 'photo' ) ) {
				$formField[ 'photo' ] = $request -> file ( 'photo' ) -> store ( 'photos' , 'public' );
			}
			//Hash Password
			$formField[ 'password' ] = bcrypt ( $formField[ 'password' ] );
			
			$user = User ::create ( $formField );
			
			//Login
			return redirect ( '/' ) -> with ( 'message' , 'User created and logged in' );
		}
		
		public function login ()
		{
			return view ( 'pages.login' );
		}
		
		public function authenticate ( Request $request )
		{
			$formField = $request -> validate ( [
				'email' => [ 'required' , 'email' ] ,
				'password' => 'required'
			] );
			if ( auth () -> attempt ( $formField ) ) {
				$request -> session () -> regenerate ();
				if ( auth () -> user () -> acc_type == 'Doctor' ) {
					return redirect ( '/doctor' );
				} else {
					return redirect ( '/admin' );
				}
			}
			return back () -> withErrors ( [ 'email' => 'Invalid Credentials' ] ) -> onlyInput ( 'email' );
		}
		
		public function logout ( Request $request )
		{
			auth () -> logout ();
			$request -> session () -> invalidate ();
			$request -> session () -> regenerateToken ();
			return redirect ( '/' ) -> with ( 'message' , 'You have been log out' );
		}
		
		public function show ( User $user )
		{
			return view ( 'pages.doctor-info' , compact ('user') );
		}
	}
	
	//{{$user->photo ? asset ('storage/' . $user->photo) : asset('/image/1.jpg)}}

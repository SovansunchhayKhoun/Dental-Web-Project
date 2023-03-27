<?php
	
	namespace App\Http\Controllers;
	
	use App\Models\Appointment;
	use App\Models\OurDoctor;
	use App\View\Components\Patient\PatientItem;
	use Illuminate\Http\Request;
	use App\Models\User;
	use Illuminate\Support\Facades\App;
	use Illuminate\Validation\Rule;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Facades\Hash;
	use Illuminate\Support\Facades\Session;
	
	class UserController extends AdminController
	{
		public function index ()
		{
			if ( Auth ::check () ) {
				if ( auth () -> user () -> acc_type == 'Doctor' ) {
					// The user is logged in...
					$doctors = User ::all ();
					$patients = Appointment ::where ( 'appointedDoctor' , auth () -> user () -> name ) -> paginate ( 6 );
					$count = count ( Appointment ::where ( 'appointedDoctor' , auth () -> user () -> name ) -> get () );
					$mailCount = count ( Appointment ::where ( 'appointedDoctor' , NULL ) -> get () );
					return view ( 'layouts.admin' , compact ( 'patients' , 'count' , 'mailCount' , 'doctors' ) );
				} else {
					auth ::logout ();
					return view ( 'pages.login' );
				}
			} else {
				auth ::logout ();
				return view ( 'pages.login' );
			}
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
		
		public function login ( Request $request )
		{
			auth () -> logout ();
			$request -> session () -> invalidate ();
			$request -> session () -> regenerateToken ();
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
			} else {
				return back () -> withErrors ( [ 'email' => 'Invalid Credentials' ] ) -> onlyInput ( 'email' );
			}
		}
		
		public function logout ( Request $request )
		{
			auth () -> logout ();
			$request -> session () -> invalidate ();
			$request -> session () -> regenerateToken ();
			return redirect ( '/login' );
		}
		
		public function patientInfo ( Appointment $appointment )
		{
			return view ( 'pages.patient-info' , compact ( 'appointment' ) );
		}
		
		public function myPatients ( Auth $auth )
		{
			$doctors = User ::latest () -> paginate ( 6 );
			$patients = Appointment ::where ( [
				'appointedDoctor' => auth () -> user () -> name ,
				'status' => 'Approve'
			] ) -> paginate ( 6 );
			return view ( 'pages.patient-list' , compact ( 'patients' , 'doctors' ) );
		}
		
		public function search ()
		{
			$doctors = User ::all ();
			$search = request () -> query ( 'appointment' );
			if ( $search == "" ) {
				return redirect ( '/doctor/patient-list' );
			}
			if ( $search ) {
				$patients = Appointment ::where ( 'firstName' , 'LIKE' , "%{$search}%" )
					-> where ( [ 'status' => 'Approve' ] )
					-> wherein ( 'appointedDoctor' , [ auth () -> user () -> name ] )
					-> paginate ( 6 );
			} else {
				$patients = Appointment :: where ( 'appointedDoctor' , auth () -> user () -> name ) -> paginate ( 6 );
			}
			return view ( 'pages.patient-list' , compact ( 'patients' , 'doctors' ) );
		}
	}
	
	//{{$user->photo ? asset ('storage/' . $user->photo) : asset('/image/1.jpg)}}

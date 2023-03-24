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
	
	class UserController extends Controller
	{
		// public function create()
		// {
		//     return view('register');
		// }
		public function index ()
		{
			$patients = Appointment :: where ( 'appointedDoctor' , auth () -> user () -> name ) -> paginate ( 6 );
			$count = count ( Appointment :: where ( 'appointedDoctor' , auth () -> user () -> name ) -> get () );
			$mailCount = count ( Appointment :: where ( 'appointedDoctor' , NULL ) -> get () );
			return view ( 'layouts.admin' , compact (
				'patients' ,
				'count' ,
				'mailCount'
			) );
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
					return redirect ( '/doctor/' . auth () -> user () -> name );
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
		public function patientInfo (Appointment $appointment)
		{
			return view ( 'pages.patient-info', compact ('appointment'));
		}
		public function myPatients ( Auth $auth )
		{
			$patients = Appointment :: where ( 'appointedDoctor' , auth () -> user () -> name ) -> paginate ( 6 );
			$mailCount = count ( Appointment :: where ( 'appointedDoctor' , NULL ) -> get () );
			$count = count ( Appointment :: where ( 'appointedDoctor' , auth () -> user () -> name ) -> get () );
			return view ( 'pages.patient-list' , compact ( 'patients' , 'mailCount' , 'count' ) );
		}
		
		public function myMail ()
		{
			$patients = Appointment :: where ( 'appointedDoctor' , NULL ) -> paginate ( 6 );
			$mailCount = count ( Appointment :: where ( 'appointedDoctor' , NULL ) -> get () );
			$count = count ( Appointment :: where ( 'appointedDoctor' , auth () -> user () -> name ) -> get () );
			return view ( 'pages.patient-list' , compact ( 'patients' , 'count' , 'mailCount' ) );
		}

		public function search(){
			$search = request () -> query ( 'appointment' );
			$mailCount = count ( Appointment :: where ( 'appointedDoctor' , NULL ) -> get () );
			if ( $search ) {
				$patients = Appointment ::where ( 'firstName' , 'LIKE' , "%{$search}%" )
					-> orwhere('lastName', 'LIKE', "%{$search}%")->paginate(6);
				$count = count($patients);
			} else {
				$patients = Appointment ::latest () -> paginate ( 6 );
				$count = count(Appointment::all());
			}
			return view ( 'pages.patient-list' , compact ( 'count', 'patients', 'mailCount') );
		}
	}
	
	//{{$user->photo ? asset ('storage/' . $user->photo) : asset('/image/1.jpg)}}

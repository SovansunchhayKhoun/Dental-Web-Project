<?php
	
	namespace App\Http\Controllers;
	
	use App\Models\Appointment;
	use App\Models\User;
	use Illuminate\Http\Request;
	use function PHPUnit\Framework\isEmpty;
	use function PHPUnit\Framework\never;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Facades\Hash;
	
	class AdminController extends Controller
	{
		public function update ( Request $request , Appointment $appointment )
		{
			$appointment -> update ( [ 'status' => 'Approve' , 'appointedDoctor' => $request[ 'doctorValue' ] ] );
			return redirect () -> back ();
		}
		
		public function destroyAppointment ( Appointment $appointment )
		{
			$appointment -> delete ();
			return redirect () -> back ();
		}
		
		public function destroyUser ( User $user )
		{
			$user -> delete ();
			return redirect () -> back ();
		}
		
		public function passwordView ( User $user )
		{
			return view ( 'pages.change-password' , [ 'user' => $user ] );
		}
		
		public function passwordCorrect ( $suppliedPassword , $oldPassword )
		{
			return Hash ::check ( $suppliedPassword , $oldPassword , [] );
		}
		
		public function updatePassword ( Request $request , User $user )
		{
			//Hash Password
			if ( self ::passwordCorrect ( $request[ 'oldPassword' ] , $user -> password ) ) {
				$user -> update ( [ 'password' => bcrypt ( $request[ 'password' ] ) ] );
				return redirect ( '/admin/doctor-list/' . $user -> id );
			} else {
				return redirect ( '/admin/doctor-list/' . $user -> id . '/password' );
			}
		}
		
		public function __invoke ()
		{
			if ( Auth ::check () ) {
				if ( auth () -> user () -> acc_type == 'admin' ) {
					// The user is logged in...
					$doctors = User ::latest () -> paginate ( 6 );
//					$count = count ( User ::all () );
//					$mailCount = count ( Appointment ::where ( 'appointedDoctor' , NULL ) -> get () );
//					return view ( 'layouts.admin' , compact ( 'doctors' , 'count' , 'mailCount' ) );
					return view ( 'layouts.admin' , compact ( 'doctors' ) );
				} else {
					auth ::logout ();
					return view ( 'pages.login' );
				}
			} else {
				auth ::logout ();
				return view ( 'pages.login' );
			}
		}
		
		public function index ()
		{
			$doctors = User ::where ( 'acc_type' , 'Doctor' ) -> paginate ( 6 );
//			$count = count ( User ::all () );
//			$mailCount = count ( Appointment ::all () );
//			return view ( 'pages.doctor-list' , compact ( 'doctors' , 'count' , 'mailCount' ) );
			return view ( 'pages.doctor-list' , compact ( 'doctors' ) );
		}
		
		public function doctorMail ( $doctor )
		{
//			dd($doctor);
			$doctors = User :: all ();
			$patients = Appointment ::where ( [
				'appointedDoctor' => $doctor ,
				'status' => 'PENDING'
			] )
				-> paginate ( 6 );
//			$count = count ( $patients );
//			$mailCount = count ( Appointment ::where ( 'appointedDoctor' , NULL ) -> get () );
//			return view ( 'pages.patient-list' , compact ( 'patients' , 'count' , 'doctors' , 'mailCount' ) );
			return view ( 'pages.patient-list' , compact ( 'patients' , 'doctors' ) );
		}
		
		public function myMail ()
		{
			$doctors = User ::where ( 'acc_type' , 'Doctor' ) -> get ();
			$patients = Appointment ::where ( 'appointedDoctor' , NULL ) -> paginate ( 6 );
//			$mailCount = count ( $patients );
//			$count = count ( Appointment ::where ( 'appointedDoctor' , auth () -> user () -> name ) -> get () );
//			$count = count ( Appointment::where('appointedDoctor', $doctor)->get() );
//			return view ( 'pages.patient-list' , compact ( 'patients' , 'count' , 'mailCount' , 'doctors' ) );
			return view ( 'pages.patient-list' , compact ( 'patients' , 'doctors' ) );
		}
		
		public function show ( User $user )
		{
//			$count = count ( Appointment ::where ( 'appointedDoctor' , $user -> name ) -> get () );
//			$mailCount = count ( Appointment ::all () );
			$doctors = User ::all ();
			return view ( 'pages.edit-doctor' , compact ( 'user' , 'doctors' ) );
		}
	}

<?php
	
	namespace App\Http\Controllers;
	
	use App\Models\Appointment;
	use App\Models\User;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\App;
	use function PHPUnit\Framework\isEmpty;
	use function PHPUnit\Framework\never;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Facades\Hash;
	
	class AdminController extends Controller
	{
		public function update ( Request $request , Appointment $appointment )
		{
			if ( ! $appointment -> appointedDoctor ) {
				$appointment -> appointedDoctor = $request[ 'doctorValue' ];
			}
			$appointment -> status = 'Approve';
			$appointment -> update ();
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
					$doctors = User ::latest () -> paginate ( 6 );
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
			return view ( 'pages.doctor-list' , compact ( 'doctors' ) );
		}
		
		public function doctorMail ( $doctor )
		{
			$doctors = User :: all ();
			$patients = Appointment ::where ( [
				'appointedDoctor' => $doctor ,
				'status' => 'PENDING'
			] )
				-> paginate ( 6 );
			return view ( 'pages.patient-list' , compact ( 'patients' , 'doctors' ) );
		}
		
		public function myMail ()
		{
			$doctors = User ::where ( 'acc_type' , 'Doctor' ) -> get ();
			$patients = Appointment ::where ( 'appointedDoctor' , NULL ) -> paginate ( 6 );
			return view ( 'pages.patient-list' , compact ( 'patients' , 'doctors' ) );
		}
		
		public function show ( User $user )
		{
			$doctors = User ::all ();
			return view ( 'pages.edit-doctor' , compact ( 'user' , 'doctors' ) );
		}
	}

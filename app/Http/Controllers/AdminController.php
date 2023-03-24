<?php
	
	namespace App\Http\Controllers;
	
	use App\Models\Appointment;
	use App\Models\User;
	use Illuminate\Http\Request;
	use function PHPUnit\Framework\isEmpty;
	use function PHPUnit\Framework\never;
	
	class AdminController extends Controller
	{
		public function __invoke ()
		{
			$doctors = User ::all ();
			$count = count ( User ::all () );
			$mailCount = $count;
			return view('layouts.admin', compact ('doctors', 'count', 'mailCount'));
		}
		
		public function index ()
		{
//			$patients = Appointment ::latest () -> paginate ( 6 );
			$doctors = User ::all ();
			$count = count ( User ::all () );
			$mailCount = $count;
			return view ( 'pages.doctor-list' , compact ( 'doctors' , 'count' , 'mailCount' ) );
		}
		
		public function show ( User $user )
		{
			$doctors = User ::all ();
			$count = count ( Appointment ::all () );
			$mailCount = $count;
			return view ( 'pages.edit-doctor' , compact ( 'user', 'count', 'mailCount' ) );
		}
		
//		public function patientList ()
//		{
//			$search = request () -> query ( 'appointment' );
//			if ( $search ) {
//				$patients = Appointment ::where ( 'firstName' , 'LIKE' , "%{$search}%" )
//					-> orwhere('lastName', 'LIKE', "%{$search}%")->paginate(6);
//				$count = count($patients);
//			} else {
//				$patients = Appointment ::latest () -> paginate ( 6 );
//				$count = count(Appointment::all());
//			}
//			return view ( 'pages.patient-list' , compact ( 'count', 'patients' ) );
//		}
	}

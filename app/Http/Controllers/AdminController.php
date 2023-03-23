<?php
	
	namespace App\Http\Controllers;
	
	use App\Models\Appointment;
	use Illuminate\Http\Request;
	use function PHPUnit\Framework\isEmpty;
	
	class AdminController extends Controller
	{
		public function __invoke ()
		{
			$count = count ( Appointment ::all () );
			return view ( 'layouts.admin' , [
				'patients' => Appointment ::latest () -> paginate ( 6 ) ,
				'count' => $count
			] );
		}
		
		public function patientList ()
		{
			$patients = Appointment ::latest () -> paginate ( 6 );
			
			$search = request () -> query ( 'appointment' );
			$count = count ( Appointment ::all () );
			
			if ( $search ) {
				$patients = Appointment ::where ( 'fullName' , 'LIKE' , "%{$search}%" ) -> paginate ( 6 );
			} else {
				$patients = Appointment ::latest () -> paginate ( 6 );
			}
			return view ( 'pages.patient-list' , compact ( 'patients' , 'count' ) );
		}
		
		public function viewPage(Request $request ){
			$patients = Appointment ::all ();
			foreach ( $patients as $patient ) {
				if ( \request ( 'patientID' ) == $patient -> id ) {
					return view ( 'pages.patient-info' , compact ( 'patient' ) );
				}
			}
		}
	}

<?php
	
	namespace App\Http\Controllers;
	
	use App\Models\Appointment;
	use App\Models\User;
	use Illuminate\Http\Request;
	
	class RequestFormController extends Controller
	{
		public function __invoke ()
		{
			$user = User ::all () -> first ();
			return view ( 'pages.appointment' , compact ( 'user' ) );
		}
		
		public function store ( User $user )
		{
			Appointment ::create ( [
				'appointedDoctor' => $user -> name ,
				'firstName' => \request ( 'fName' ) ,
				'lastName' => \request ( 'lName' ) ,
				'phoneNum' => \request ( 'phoneNum' ) ,
				'email' => \request ( 'email' ) ,
				'birthday' => \request ( 'birthday' ) ,
				'appointmentDate' => \request ( 'apntDate' ) ,
				'message' => \request ( 'message' )
			] );
			return redirect ( '/appointment' ) -> with ( 'message' , 'Appointment Booked' );
		}
	}

<?php
	
	namespace App\Http\Controllers;
	
	use App\Models\Appointment;
	use Illuminate\Http\Request;
	
	class RequestFormController extends Controller
	{
		public function __invoke(){
			return view('pages.appointment');
		}
		public function store ()
		{
			Appointment ::create ( [
				'firstName' => \request ( 'fName' ) ,
				'lastName' => \request ( 'lName' ) ,
				'phoneNum' => \request ( 'phoneNum' ) ,
				'email' => \request ( 'email' ) ,
				'birthday' => \request ( 'birthday' ) ,
				'appointmentDate' => \request ( 'apntDate' ) ,
				'message' => \request ( 'message' )
			] );
			return redirect ( '/appointment')->with('message', 'Appointment Booked');
		}
	}

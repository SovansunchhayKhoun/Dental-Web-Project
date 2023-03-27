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
			$doctors = User ::latest ()->paginate(6);
			$count = count ( User ::all () );
			$mailCount = $count;
			return view ( 'pages.doctor-list' , compact ( 'doctors' , 'count' , 'mailCount' ) );
		}

		public function show ( User $user )
		{
			$doctors = User ::all ();
			$count = count ( User ::all () );
			$mailCount = $count;
			return view ( 'pages.edit-doctor' , compact ( 'user', 'count', 'mailCount' ) );
		}

		public function myMail ()
		{
			$patients = Appointment :: where ( 'appointedDoctor' , NULL ) -> paginate ( 6 );
			$mailCount = count ( Appointment :: where ( 'appointedDoctor' , NULL ) -> get () );
			$count = count ( Appointment :: where ( 'appointedDoctor' , auth () -> user () -> name ) -> get () );
			return view ( 'pages.patient-list' , compact ( 'patients' , 'count' , 'mailCount' ) );
		}

		public function edit(){

		}
	}

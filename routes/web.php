<?php
	
	use App\Http\Controllers\AdminController;
	use App\Http\Controllers\OurDoctorController;
	use App\Http\Controllers\PatientController;
	use App\Http\Controllers\RequestFormController;
	use App\Http\Controllers\ProfileController;
	use App\Models\Appointment;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Route;
	
	
	Route ::get ( '/' , RequestFormController::class );
	
	Route ::get ( '/appointment' , function () {
		return view ( 'pages.appointment' );
	} );
	
	Route ::get ( '/our-doctor' , OurDoctorController::class );
	
	Route ::controller ( AdminController::class ) -> group ( function () {
		Route ::get ( '/admin' , AdminController::class ) -> name ( 'admin' );
		Route ::get ( '/patient-list' , 'patientList' ) -> name ( 'patient-list' );
		Route ::get ( '/patient-list/{patientID}' , [ AdminController::class , 'viewPage' ] );
	} );
	
	Route ::post ( '/appointment' , [ RequestFormController::class , 'create' ] );
	



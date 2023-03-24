<?php
	
	use App\Http\Controllers\AdminController;
	use App\Http\Controllers\OurDoctorController;
	use App\Http\Controllers\RequestFormController;
	use App\Models\Appointment;
	use App\Models\User;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Route;
	use App\Http\Controllers\UserController;
	
	
	Route ::get ( '/' , function () {
		return view ( 'welcome' );
	} );
	
	Route ::get ( '/appointment' , function () {
		return view ( 'pages.appointment' );
	} );
	Route ::post ( '/appointment' , [ RequestFormController::class , 'create' ] );

	Route ::get ( '/our-doctor' , OurDoctorController::class );
	
	Route ::controller ( AdminController::class ) -> group ( function () {
		Route ::get ( '/admin' , AdminController::class ) -> name ( 'admin' );
		Route ::get ( '/patient-list' , 'patientList' ) -> name ( 'patient-list' );
		Route ::get ( '/patient-list/{patientID}' , 'patientInfo' );
	} );
	
	Route ::controller ( UserController::class ) -> group ( function () {
		//show register view
		Route ::get ( '/register' , 'register' );
//create user
		Route ::post ( '/register/user' , 'store' );
//redirect to register view
		Route ::get ( '/login' , [ UserController::class , 'login' ] );
		Route ::post ( '/login/authenticate' , 'authenticate' );
//logout
		Route ::post ( '/logout' , 'logout' );
		Route ::get ( '/our-doctor/{user}' , 'show' );
	} );




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
	
	Route ::controller ( RequestFormController::class ) -> group ( function () {
		Route ::get ( '/appointment' , RequestFormController::class );
		Route ::post ( '/appointment' , 'store' );
	} );
	
	Route ::controller ( OurDoctorController::class ) -> group ( function () {
		Route ::get ( '/our-doctor' , OurDoctorController::class );
		Route ::get ( '/our-doctor/{user}' , 'show' );
	} );
	
	Route ::controller ( AdminController::class ) -> group ( function () {
		Route ::get ( '/admin' , AdminController::class ) -> name ( 'admin' );
		Route ::get ( '/admin/doctor-list' , 'index' );
		Route ::get ( '/admin/doctor-list/{user}' , 'show' );
	} );
	
	Route ::controller ( UserController::class ) -> group ( function () {
		//show register view
		Route ::get ( '/register' , 'register' );
//create user
		Route ::post ( '/register/user' , 'store' );
//redirect to register view
		Route ::get ( '/login' , 'login' );
		Route ::post ( '/login/authenticate' , 'authenticate' );
//logout
		Route ::post ( '/logout' , 'logout' );
		
		Route ::get ( '/doctor/{user}' , 'index' );
		//Show patients according to doctor
		Route ::get ( '/doctor/{user}/patient-list' , 'myPatients' );
		Route ::get ( '/doctor/{user}/mailbox' , 'myMail' );
		Route ::get ( '/doctor/{user}/{appointment}' , 'search' );
		
		Route ::get ( '/appointment/{appointment}' , 'patientInfo' );
	} );
	




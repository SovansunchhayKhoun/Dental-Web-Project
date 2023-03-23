<?php

	use App\Http\Controllers\AdminController;
	use App\Http\Controllers\OurDoctorController;
	use App\Http\Controllers\RequestFormController;
	use App\Models\Appointment;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\UserController;


	Route ::get ( '/' , function(){
		return view('welcome');
	});

	Route ::get ( '/appointment' , function () {
		return view ( 'pages.appointment' );
	} );

	Route ::get ( '/our-doctor' , OurDoctorController::class );
        //show register view
        Route::get('/register',[UserController::class,'register']);
        //create user
        Route::post('/register/user',[UserController::class,'store']);

	Route ::controller ( AdminController::class ) -> group ( function () {
		Route ::get ( '/admin' , AdminController::class ) -> name ( 'admin' );
		Route ::get ( '/patient-list' , 'patientList' ) -> name ( 'patient-list' );
		Route ::get ( '/patient-list/{patientID}' , [ AdminController::class , 'patientInfo' ] );
	} );

	Route ::post ( '/appointment' , [ RequestFormController::class , 'create' ] );

        //redirect to register view
        Route::get('/login', [UserController::class, 'login']);
        Route::post('/login/authenticate',[UserController::class,'authenticate']);

        //logout
        Route::post('/logout', [UserController::class,'logout']);




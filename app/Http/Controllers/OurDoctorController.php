<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;

class OurDoctorController extends RequestFormController
{
	public function __invoke(){
		$doctors = User::all ();
		return view('pages.our-doctor', compact ('doctors'));
	}
	public function show(User $user){
		return view('pages.doctor-info', compact ('user'));
	}
}

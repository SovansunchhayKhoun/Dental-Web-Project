<?php

namespace App\Http\Controllers;

use App\Models\OurDoctor;
use Illuminate\Http\Request;

class OurDoctorController extends Controller
{
	public function __invoke(){
		$doctors = OurDoctor::all ();
		return view('profile.partials.our-doctor', compact ('doctors'));
	}
}

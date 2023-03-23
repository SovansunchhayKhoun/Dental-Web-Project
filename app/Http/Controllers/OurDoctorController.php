<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class OurDoctorController extends Controller
{
	public function __invoke(){
		$doctors = User::all ();
		return view('profile.partials.our-doctor', compact ('doctors'));
	}
}

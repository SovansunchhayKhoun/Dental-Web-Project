<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\never;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function update(Request $request, Appointment $appointment){
        $appointment->update(['status' => 'Approve','appointedDoctor' => $request['doctorValue']]);
        return redirect()->back();
    }
    public function destroyAppointment(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->back();
    }

    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect()->back();
    }
    public function passwordView(User $user)
    {
        return view('pages.change-password', ['user' => $user]);
    }
    public function passwordCorrect($suppliedPassword, $oldPassword)
    {
        return Hash::check($suppliedPassword, $oldPassword, []);
    }
    public function updatePassword(Request $request, User $user)
    {
        //Hash Password
        if (self::passwordCorrect($request['oldPassword'],$user->password)) {
            $user->update(['password'=> bcrypt($request['password'])]);
            return redirect('/admin/doctor-list/' . $user->id);
        } else {
            return redirect('/admin/doctor-list/' . $user->id . '/password');
        }
    }
    public function __invoke()
    {
        if (Auth::check()) {
            if (auth()->user()->acc_type == 'admin') {
                // The user is logged in...
                $doctors = User::all();
                $count = count(User::all());
                $mailCount = $count;
                return view('layouts.admin', compact('doctors', 'count', 'mailCount'));
            } else {
                auth::logout();
                return view('pages.login');
            }
        } else {
            auth::logout();
            return view('pages.login');
        }
    }
    public function myMail()
    {
        $doctors = User::where('acc_type','Doctor')->get();
        $patients = Appointment::where('status', 'PENDING')->paginate(6);
        $mailCount = count(Appointment::where('appointedDoctor', NULL)->get());
        $count = count(Appointment::where('appointedDoctor', auth()->user()->name)->get());
        return view('pages.patient-list', compact('patients', 'count', 'mailCount','doctors'));
    }

    public function index()
    {
        //			$patients = Appointment ::latest () -> paginate ( 6 );
        $doctors = User::all();
        $count = count(User::all());
        $mailCount = $count;
        return view('pages.doctor-list', compact('doctors', 'count', 'mailCount'));
    }

    public function show(User $user)
    {
        $doctors = User::all();
        $count = count(Appointment::all());
        $mailCount = $count;
        return view('pages.edit-doctor', compact('user', 'count', 'mailCount'));
    }

    //		public function patientList ()
    //		{
    //			$search = request () -> query ( 'appointment' );
    //			if ( $search ) {
    //				$patients = Appointment ::where ( 'firstName' , 'LIKE' , "%{$search}%" )
    //					-> orwhere('lastName', 'LIKE', "%{$search}%")->paginate(6);
    //				$count = count($patients);
    //			} else {
    //				$patients = Appointment ::latest () -> paginate ( 6 );
    //				$count = count(Appointment::all());
    //			}
    //			return view ( 'pages.patient-list' , compact ( 'count', 'patients' ) );
    //		}
}

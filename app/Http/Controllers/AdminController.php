<?php

namespace App\Http\Controllers;

    use App\Models\Appointment;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Hash;

    class AdminController extends MailController
    {
        public function update(Request $request, Appointment $appointment)
        {
            $user = User::find($appointment->id);
            if ($user != null) {
                $user->patient_count--;
                $user->update();
            }
            if ($appointment->appointedDoctor == null) {
                $appointment->appointedDoctor = $request['doctorValue'];
            }
            $appointment->status = 'Approve';
            $appointment->update();

            $this->mail($appointment->email, 'Using Update From patient status');

            return redirect()->back();
        }

        public function destroyAppointment(Appointment $appointment)
        {
            $this->mail($appointment->email, 'Using Decline from patient status');
            if (auth()->user()->acc_type != 'admin') {
                $appointment->delete();

                return redirect('/doctor/patient-list');
            } else {
                $appointment->delete();

                return redirect()->back();
            }
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
            if (self::passwordCorrect($request['oldPassword'], $user->password)) {
                $user->update(['password' => bcrypt($request['password'])]);

                return redirect('/admin/doctor-list/'.$user->id);
            } else {
                return redirect('/admin/doctor-list/'.$user->id.'/password');
            }
        }

        public function __invoke()
        {
            if (Auth::check()) {
                if (auth()->user()->acc_type == 'admin') {
                    $doctors = User::latest()->paginate(6);
                    $countMail = Appointment::where('appointedDoctor', null)->count();

                    return view('layouts.admin', compact('doctors', 'countMail'));
                } else {
                    auth::logout();

                    return view('pages.login');
                }
            } else {
                auth::logout();

                return view('pages.login');
            }
        }

        public function index()
        {
            $countMail = Appointment::where('appointedDoctor', null)->count();
            $doctors = User::where('acc_type', 'Doctor')->paginate(6);

            return view('pages.doctor-list', compact('doctors', 'countMail'));
        }

        public function doctorMail($doctor)
        {
            $doctors = User::all();
            $patients = Appointment::where([
                'appointedDoctor' => $doctor,
                'status' => 'PENDING',
            ])
                ->paginate(6);
            $doctorMail = count($patients);
            //			$countMail = Appointment ::where ( 'appointedDoctor' , NULL ) -> count ();
            $countMail = Appointment::where([
                'appointedDoctor' => null,
                'status' => 'PENDING',
            ])->count();

            return view('pages.patient-list', compact('doctorMail', 'countMail', 'patients', 'doctors'));
        }

        public function myMail()
        {
            $doctors = User::where('acc_type', 'Doctor')->get();
            if (auth()->user()->acc_type == 'Doctor') {
                $patients = Appointment::where('appointedDoctor', auth()->user()->name)
                    ->where('status', 'PENDING')
                    ->paginate(6);
                $countMail = count($patients);
            } else { // for Acc_type = Admin
                $patients = Appointment::where(
                    'appointedDoctor', null
                )->paginate(6);
                $countMail = count($patients);
            }
            //			$countMail = Appointment ::where ( 'appointedDoctor' , NULL ) -> count ();
            return view('pages.patient-list', compact('countMail', 'patients', 'doctors'));
        }

        public function show(User $user)
        {
            $countMail = Appointment::where('appointedDoctor', null)->count();
            $doctors = User::all();

            return view('pages.edit-doctor', compact('countMail', 'user', 'doctors'));
        }

        public function search()
        {
            $countMail = Appointment::where('appointedDoctor', null)->count();
            $doctors = User::all();
            $search = request()->query('appointment');
            if ($search == '') {
                return redirect()->back();
            }
            if ($search) {
                $patients = Appointment::where('firstName', 'like', "%{$search}%")
                    ->orwhere('lastName', 'like', "%{$search}%")
                    ->orwhere('id', 'like', "%{$search}%")
                    ->paginate(6);
            } else {
                $patients = Appointment::where('appointedDoctor', auth()->user()->name)->paginate(6);
            }

            return view('pages.patient-list', compact('countMail', 'patients', 'doctors'));
        }
    }

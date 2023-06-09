<?php

	namespace App\Http\Controllers;

	use App\Models\Appointment;
    use App\Models\Temp;
use App\Models\Treatment;
	use App\Models\User;
    use Carbon\Carbon;
	use Illuminate\Http\Request;
    use Illuminate\Validation\Rules\Unique;
	use function PHPUnit\Framework\isEmpty;
	use function PHPUnit\Framework\never;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Facades\Hash;
    use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

	class AdminController extends MailController
	{
        public function clearFromTable()
    {
        DB::table('temps')->truncate();
        return redirect()->back();
    }
    public function invoiceView(Request $request)
    {
            // dd(Auth::user()->name);
            $treatments = Treatment::all();
            $doctors = User::all();
            $dName = Auth::user()->name;
            $items = Temp::all();
            $mytime = Carbon::now();
            $patients = Appointment::where('appointedDoctor', Auth::user()->name)->get();
            $countMail = Appointment::where('appointedDoctor', null)->count();
            $amount = Temp::all()->sum(function($t){
                return $t->price * $t->qty;
            });
            // $int = array_map('intval', $total);
            // dd($amount);
            return view('pages.create-invoice', [
                'doctors' => $doctors,
                'patients' => $patients,
                'treatments' => $treatments,
                'items' => $items,
                'total' => $amount,
                'date' => $mytime->toDateTimeString(),
                'countMail' => $countMail,
                'dName' => $dName
            ]);
        }

        public function generateReceipt(Request $request)
        {
            // dd($request->get('curdate'));
            DB::table('invoices')->insert([
                'patient' => $request->get('patient_name'),
                'date' => $request->get('curdate'),
                'doctor' => $request->get('doctor_name'),
                'amount' => $request->get('total')
            ]);
            self::clearFromTable();
            return redirect()->back();
        }
    public function addToTempTable(Request $request, Treatment $treatment)
    {
        $treatments = Treatment::all();
        $qty = $request->get('qty');
        foreach ($treatments as $treatment) {
            if ($treatment['id'] == $request->get('treatment')) {
                DB::table('temps')->insert([
                    'treatment_name' =>  $treatment['treatment_name'],
                    'price' => $treatment['price'],
                    'qty' => $qty,
                    'amount' => $qty*$treatment['price']
                ]);
            }
        }
        return redirect()->back();

    }
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

    public function showTreatmentList(Treatment $treatments)
    {
        $treatments = Treatment::all();
        $doctors = User::all();
        $countMail = Appointment::where('appointedDoctor', null)->count();
        return view('pages.treatment-list', [
            'treatments' => $treatments,
            'doctors' => $doctors,
            'countMail' => $countMail
        ]);
    }
    public function createTreatmentView()
    {
        $doctors = User::all();
        $countMail = Appointment::where('appointedDoctor', null)->count();
        return view('pages.add-new-treatment', [
            'doctors' => $doctors,
            'countMail' => $countMail
        ]);
    }
    public function createTreatment(Request $request)
    {
        $formfield = $request->validate([
            'treatment_name' => ['required', 'string', Rule::unique('treatments', 'treatment_name')],
            'price' => 'required'
        ]);
        $treatment = Treatment::create($formfield);
        return redirect('/admin/treatment-list')->with('message', 'Treatment created Successfully');
    }
    public function destroyTreatment(Treatment $treatment)
    {
        $treatment->delete();
        return redirect()->back();
    }
    public function editTreatmentView(Treatment $treatment)
    {
        $doctors = User::all();
        return view('pages.edit-treatment', [
            'treatment' => $treatment,
            'doctors' => $doctors
        ]);
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


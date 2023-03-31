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

class AdminController extends Controller
{
    public function clearFromTable()
    {
        DB::table('temps')->truncate();
        return redirect()->back();
    }
    public function invoiceView(Request $request)
    {
            $treatments = Treatment::all();
            $doctors = User::all();
            $items = Temp::all();
            $mytime = Carbon::now();
            $patients = Appointment::all();

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
                'date' => $mytime->toDateTimeString()
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
        $appointment->update(['status' => 'Approve', 'appointedDoctor' => $request['doctorValue']]);
        return redirect()->back();
    }
    public function showTreatmentList(Treatment $treatments)
    {
        $treatments = Treatment::all();
        $doctors = User::all();
        return view('pages.treatment-list', [
            'treatments' => $treatments,
            'doctors' => $doctors
        ]);
    }
    public function createTreatmentView()
    {
        $doctors = User::all();
        return view('pages.add-new-treatment', [
            'doctors' => $doctors
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
        if (self::passwordCorrect($request['oldPassword'], $user->password)) {
            $user->update(['password' => bcrypt($request['password'])]);
            return redirect('/admin/doctor-list/' . $user->id);
        } else {
            return redirect('/admin/doctor-list/' . $user->id . '/password');
        }
    }
    public function updateTreatment(Request $request, Treatment $treatment)
    {
        $formFields = $request->validate([
            'treatment_name' => 'required',
            'price' => 'required'
        ]);

        $treatment->update($formFields);
        return redirect('/admin/treatment-list');
    }

    public function __invoke()
    {
        if (Auth::check()) {
            if (auth()->user()->acc_type == 'admin') {
                // The user is logged in...
                $doctors = User::latest()->paginate(6);
                //					$count = count ( User ::all () );
                //					$mailCount = count ( Appointment ::where ( 'appointedDoctor' , NULL ) -> get () );
                //					return view ( 'layouts.admin' , compact ( 'doctors' , 'count' , 'mailCount' ) );
                return view('layouts.admin', compact('doctors'));
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
        $doctors = User::where('acc_type', 'Doctor')->paginate(6);
        //			$count = count ( User ::all () );
        //			$mailCount = count ( Appointment ::all () );
        //			return view ( 'pages.doctor-list' , compact ( 'doctors' , 'count' , 'mailCount' ) );
        return view('pages.doctor-list', compact('doctors'));
    }

    public function doctorMail($doctor)
    {
        //			dd($doctor);
        $doctors = User::all();
        $patients = Appointment::where([
            'appointedDoctor' => $doctor,
            'status' => 'PENDING'
        ])
            ->paginate(6);
        //			$count = count ( $patients );
        //			$mailCount = count ( Appointment ::where ( 'appointedDoctor' , NULL ) -> get () );
        //			return view ( 'pages.patient-list' , compact ( 'patients' , 'count' , 'doctors' , 'mailCount' ) );
        return view('pages.patient-list', compact('patients', 'doctors'));
    }

    public function myMail()
    {
        $doctors = User::where('acc_type', 'Doctor')->get();
        $patients = Appointment::where('appointedDoctor', NULL)->paginate(6);
        //			$mailCount = count ( $patients );
        //			$count = count ( Appointment ::where ( 'appointedDoctor' , auth () -> user () -> name ) -> get () );
        //			$count = count ( Appointment::where('appointedDoctor', $doctor)->get() );
        //			return view ( 'pages.patient-list' , compact ( 'patients' , 'count' , 'mailCount' , 'doctors' ) );
        return view('pages.patient-list', compact('patients', 'doctors'));
    }

    public function show(User $user)
    {
        //			$count = count ( Appointment ::where ( 'appointedDoctor' , $user -> name ) -> get () );
        //			$mailCount = count ( Appointment ::all () );
        $doctors = User::all();
        return view('pages.edit-doctor', compact('user', 'doctors'));
    }
}

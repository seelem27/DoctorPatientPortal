<?php

namespace App\Http\Controllers\Admin;

use App\Patient;
use App\WorkingHour;
use App\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AppointmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('appointment_access')) {
            return abort(401);
        }

        $appointments = Appointment::all();

        return view('admin.appointments.index', compact('appointments'));
    }

    public function get_appt()
    {
        if (! Gate::allows('appointment_info')) {
            return abort(401);
        }

        $userId = Auth::id();
        $patient = Patient::where('user_id', $userId)->first();

        $working_hours = WorkingHour::all();
        $appointments = Appointment::all();

        $relations = [
            'patient_appointments' => \App\Appointment::where('patient_id', $patient->id)->get(),
        ];

        return view('patients.patient.get_appt')
        ->with(compact('working_hours'))
        ->with(compact('appointments') + $relations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('appointment_create')) {
            return abort(401);
        }

        $relations = [
            'patients' => \App\Patient::get(),
            'doctors' => \App\Doctor::get(),
			'services' => \App\Service::get(),
        ];

        $appointments = Appointment::all();

        return view('admin.appointments.create', compact('appointments') + $relations);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::allows('appointment_create')) {
            return abort(401);
        }
        
        $doctor = \App\Doctor::find($request->doctor_id);

        $startTime = date('Y-m-d H:i', strtotime("".$request->date." ".$request->starting_hour .":".$request->starting_minute.":00"));
        $endTime = date('Y-m-d H:i', strtotime("".$request->date." ".$request->finish_hour .":".$request->finish_minute.":00"));

        $working_hours = \App\WorkingHour::where('doctor_id', $request->doctor_id)->whereDay('date', '=', date("d", strtotime($request->date)))->whereTime('start_time', '<=', date("H:i", strtotime("".$request->starting_hour.":".$request->starting_minute.":00")))->whereTime('finish_time', '>=', date("H:i", strtotime("".$request->finish_hour.":".$request->finish_minute.":00")))->get();
        
        if(!$doctor->provides_service($request->service_id)) return redirect()->back()->withErrors("This doctor doesn't provide your selected service")->withInput();
            if($working_hours->isEmpty()) return redirect()->back()->withErrors("This doctor isn't working at your selected time")->withInput();
        
        $booking = Appointment::where('doctor_id', '=', $request->doctor_id)->where('start_time', '<', $endTime)->where('finish_time', '>', $startTime)->count();

        if($booking > 0) {
            return redirect()->back()->with('alert', 'This date and time have already been booked. Please try another time');
        } else if($endTime <= $startTime){
            return redirect()->back()->with('alert', 'Appointment booking end time must be larger than start time');
        } else {
            $appointment = new Appointment;
            $appointment->patient_id = $request->patient_id;
            $appointment->doctor_id = $request->doctor_id;
            $appointment->start_time = "".$request->date." ".$request->starting_hour .":".$request->starting_minute.":00";
            $appointment->finish_time = "".$request->date." ".$request->finish_hour .":".$request->finish_minute.":00";
            $appointment->comments = $request->comments;
            $appointment->save();
        }   

        return redirect()->route('admin.appointments.index')->with('alert', 'Appointment booked successful');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('appointment_view')) {
            return abort(401);
        }
        $relations = [
            'patients' => \App\Patient::get()->pluck('name', 'id')->prepend('Please select', ''),
            'doctors' => \App\Doctor::get()->pluck('name', 'id')->prepend('Please select', ''),
        ];

        $appointment = Appointment::findOrFail($id);

        return view('admin.appointments.show', compact('appointment') + $relations);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('appointment_edit')) {
            return abort(401);
        }

        $relations = [
            'patients' => \App\Patient::get()->pluck('name', 'id')->prepend('Please select', ''),
            'doctors' => \App\Doctor::get()->pluck('name', 'id')->prepend('Please select', ''),
        ];

        $appointment = Appointment::findOrFail($id);

        return view('admin.appointments.edit', compact('appointment') + $relations);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (! Gate::allows('appointment_edit')) {
            return abort(401);
        }

        $input = $request->all();
        $input['start_time'] = $input['start_time'].":00";
        $input['finish_time'] = $input['finish_time'].":00";

        $appointment = Appointment::findOrFail($id);
        //dd($appointment);
        //dd($input);
        $appointment->update($input) ;

        return redirect()->route('admin.appointments.index')->with('alert', 'Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('appointment_delete')) {
            return abort(401);
        }

        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect()->route('admin.appointments.index');
    }

    // public function massDestroy(Request $request)
    // {
    //     if (! Gate::allows('appointment_delete')) {
    //         return abort(401);
    //     }
    //     if ($request->input('ids')) {
    //         $entries = Appointment::whereIn('id', $request->input('ids'))->get();

    //         foreach ($entries as $entry) {
    //             $entry->delete();
    //         }
    //     }
    // }

    public function create_appt()
    {
        if (! Gate::allows('appointment_patient_create')) {
            return abort(401);
        }

        $userId = Auth::id();
        $patient = Patient::where('user_id', $userId)->first();

        $appointments = Appointment::all();
        $relations = [
            'patient' => $patient,
            'doctors' => \App\Doctor::get(),
			'services' => \App\Service::get(),
        ];

        return view('patients.patient.create_appt', compact('appointments') + $relations);
    }

    public function store_appt(Request $request)
    {
        if (! Gate::allows('appointment_patient_create')) {
            return abort(401);
        }

        $userId = Auth::id();
        $patient = Patient::where('user_id', $userId)->first();

        $doctor = \App\Doctor::find($request->doctor_id);

        $startTime = date('Y-m-d H:i', strtotime("".$request->date." ".$request->starting_hour .":".$request->starting_minute.":00"));
        $endTime = date('Y-m-d H:i', strtotime("".$request->date." ".$request->finish_hour .":".$request->finish_minute.":00"));

        $working_hours = \App\WorkingHour::where('doctor_id', $request->doctor_id)->whereDay('date', '=', date("d", strtotime($request->date)))->whereTime('start_time', '<=', date("H:i", strtotime("".$request->starting_hour.":".$request->starting_minute.":00")))->whereTime('finish_time', '>=', date("H:i", strtotime("".$request->finish_hour.":".$request->finish_minute.":00")))->get();
        
        if(!$doctor->provides_service($request->service_id)) return redirect()->back()->withErrors("This doctor doesn't provide your selected service")->withInput();
            if($working_hours->isEmpty()) return redirect()->back()->withErrors("This doctor isn't working at your selected time")->withInput();
        
        $booking = Appointment::where('doctor_id', '=', $request->doctor_id)->where('start_time', '<', $endTime)->where('finish_time', '>', $startTime)->count();

        if($booking > 0) {
            return redirect()->back()->with('alert', 'This date and time have already been booked. Please try another time');
        } else if($endTime <= $startTime){
            return redirect()->back()->with('alert', 'Appointment booking end time must be larger than start time');
        } else {
            $appointment = new Appointment;
            $appointment->patient_id = $patient->id;
            $appointment->doctor_id = $request->doctor_id;
            $appointment->start_time = "".$request->date." ".$request->starting_hour .":".$request->starting_minute.":00";
            $appointment->finish_time = "".$request->date." ".$request->finish_hour .":".$request->finish_minute.":00";
            //$appointment->comments = $request->comments;
            $appointment->save();
        }   

        return redirect()->route('admin.appointments.get_appt')->with('alert', 'Appointment booked successful');
    }

    public function edit_appt($id)
    {
        if (! Gate::allows('appointment_patient_edit')) {
            return abort(401);
        }

        $userId = Auth::id();
        $patient = Patient::where('user_id', $userId)->first();

        $relations = [
            'patient' => $patient,
            'doctors' => \App\Doctor::get()->pluck('name', 'id')->prepend('Please select', ''),
        ];

        $appointment = Appointment::findOrFail($id);

        return view('patients.patient.edit_appt', compact('appointment') + $relations);
    }

    public function update_appt(Request $request, $id)
    {
        if (! Gate::allows('appointment_patient_edit')) {
            return abort(401);
        }

        $input = $request->all();
        $input['start_time'] = $input['start_time'].":00";
        $input['finish_time'] = $input['finish_time'].":00";

        $appointment = Appointment::findOrFail($id);
        //dd($request->all());
        $appointment->update($input) ;

        return redirect()->route('admin.appointments.get_appt')->with('alert', 'Update Successfully');
    }

    public function show_appt($id)
    {
        if (! Gate::allows('appointment_patient_view')) {
            return abort(401);
        }
        $relations = [
            'patients' => \App\Patient::get()->pluck('name', 'id')->prepend('Please select', ''),
            'doctors' => \App\Doctor::get()->pluck('name', 'id')->prepend('Please select', ''),
        ];

        $appointment = Appointment::findOrFail($id);

        return view('patients.patient.show_appt', compact('appointment') + $relations);
    }

    public function destroy_appt($id)
    {

        if (! Gate::allows('appointment_patient_delete')) {
            return abort(401);
        }

        $appointment = Appointment::findOrFail($id);
        //dd($appointment);
        $appointment->delete();
        
        return redirect()->route('admin.appointments.get_appt');
    }
}

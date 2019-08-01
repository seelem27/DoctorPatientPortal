<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Doctor;
use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;


class DoctorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('doctor_access')) {
            return abort(401);
        }

        $doctors = Doctor::all();

        return view('admin.doctors.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('doctor_create')) {
            return abort(401);
        }
		$relations = [
            'services' => \App\Service::get()->pluck('name', 'id'),
        ];

        return view('admin.doctors.create', $relations);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::allows('doctor_create')) {
            return abort(401);
        }        
        $doctor = Doctor::create($request->only(['first_name', 'last_name', 'dob', 'phone', 'email', 'address']));
        $services_ids = [];
        
		foreach($request->services as $service) :
		    $services_ids[] = $service;
        endforeach;
        
		$doctor->services()->attach($services_ids);

        return redirect()->route('admin.doctors.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('doctor_view')) {
            return abort(401);
        }
        $relations = [
            'working_hours' => \App\WorkingHour::where('doctor_id', $id)->get(),
            'appointments' => \App\Appointment::where('doctor_id', $id)->get(),
        ];

        $doctor = Doctor::findOrFail($id);

        return view('admin.doctors.show', compact('doctor') + $relations);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('doctor_edit')) {
            return abort(401);
        }
        $doctor = Doctor::findOrFail($id);

        $relations = [
            'services' => \App\Service::get()->pluck('name', 'id'),
        ];

        return view('admin.doctors.edit', compact('doctor'), $relations);
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
        if (! Gate::allows('doctor_edit')) {
            return abort(401);
        }
        $doctor = Doctor::findOrFail($id);

        $service = $request->service_id;

        if(($doctor->services())->count() == 0) {
            $doctor->services()->attach($service);
        } else {

        }

        $doctor->update($request->all());

        return redirect()->route('admin.doctors.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('doctor_delete')) {
            return abort(401);
        }
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();

        return redirect()->route('admin.doctors.index');
    }

    public function massDestroy(Request $request)
    {
        if (! Gate::allows('doctor_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Doctor::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

    public function GetDoctors(Request $request)
	{
		$doctors = DB::table('working_hours')->join('doctors', 'doctors.id', '=', 'working_hours.doctor_id')->where('working_hours.date', '=', $request->date)->get();

        // $doctors = DB::table('doctors')->join('working_hours', 'doctors.id', '=', 'working_hours.doctor_id')
        // ->where('working_hours.date', '=', $request->date)->selectRaw('doctors.*')->get();
        
        $service = \App\Service::find($request->service_id);
        
		$html = "";
		$html .= "<div class='row doctors'>";
		$html .= "<div class='col-xs-12 form-group'>";
		$html .= "<label class='control-label'>Doctor*</label>";
        $html .= "<ul class='list-inline'>";
        
		if(is_object($doctors) && count($doctors) > 0):
            foreach($doctors as $doctor) :
                $html .= "<li><label><input type='radio' name='doctor_id' class='doctor_id' value='".$doctor->id."'> ".$doctor->name." (<span class='starting_hour_$doctor->id'>".date("H", strtotime($doctor->start_time))."</span>:<span class='starting_minute_$doctor->id'>".date("i", strtotime($doctor->start_time))."</span> - <span class='finish_hour_$doctor->id'>".date("H", strtotime($doctor->finish_time))."</span>:<span class='finish_minute_$doctor->id'>".date("i", strtotime($doctor->finish_time))."</span>)</label></li>";
            endforeach;
		else :
		    $html .= "<li>No doctors working on your selected date</li>";
        endif;
        
		$html .= "</ul>";
		$html .= "</div>";
        $html .= "</div>";
        
		return $html;
	}
}

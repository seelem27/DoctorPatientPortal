<?php

namespace App\Http\Controllers\Admin;

use App\Patient;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PatientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('patient_access')) {
            return abort(401);
        }

        $patients = Patient::all();
        return view('admin.patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('patient_create')) {
            return abort(401);
        }
        return view('admin.patients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::allows('patient_create')) {
            return abort(401);
        }

        $patient = Patient::create($request->all());
        //return var_dump($patient);
        return redirect()->route('admin.patients.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('patient_view')) {
            return abort(401);
        }
        $relations = [
            'appointments' => \App\Appointment::where('patient_id', $id)->get(),
        ];

        $patient = Patient::findOrFail($id);

        return view('admin.patients.show', compact('patient') + $relations);
    }

    public function get_info()
    {
        if (! Gate::allows('patient_info')) {
            return abort(401);
        }

        $userId = Auth::id();
        $patient = Patient::where('user_id', $userId)->first();

        $relations = [
            'appointments' => \App\Appointment::where('patient_id', $patient->id)->get(),
        ];

        //$patient = Patient::findOrFail($id);

        //return var_dump($relations);
        return view('patients.patient.get_info', compact('patient') + $relations);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('patient_edit')) {
            return abort(401);
        }
        $patient = Patient::findOrFail($id);

        return view('admin.patients.edit', compact('patient'));
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
        if (! Gate::allows('patient_edit')) {
            return abort(401);
        }

        $patient = Patient::findOrFail($id);
        $patient->update($request->all());

        return redirect()->route('admin.patients.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('patient_delete')) {
            return abort(401);
        }
        $patient = Patient::findOrFail($id);
        $patient->delete();

        return redirect()->route('admin.patients.index');
    }

    public function massDestroy(Request $request)
    {
        if (! Gate::allows('patient_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Patient::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    } 
}

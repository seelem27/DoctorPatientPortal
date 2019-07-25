<?php

namespace App\Http\Controllers\Admin;

use App\WorkingHour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;

class WorkingHoursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('working_hour_access')) {
            return abort(401);
        }

        $working_hours = WorkingHour::all();

        return view('admin.working_hours.index', compact('working_hours'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('working_hour_create')) {
            return abort(401);
        }
        $relations = [
            'doctors' => \App\Doctor::get(),
        ];

        return view('admin.working_hours.create', $relations);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::allows('working_hour_create')) {
            return abort(401);
        }
        $working_hour = WorkingHour::create($request->all());

        return redirect()->route('admin.working_hours.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('working_hour_view')) {
            return abort(401);
        }

        $relations = [
            'doctors' => \App\Doctor::get()->pluck('name', 'id')->prepend('Please select', ''),
        ];

        $working_hour = WorkingHour::findOrFail($id);

        return view('admin.working_hours.show', compact('working_hour') + $relations);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('working_hour_edit')) {
            return abort(401);
        }
        $relations = [
            'doctors' => \App\Doctor::get()->pluck('name', 'id')->prepend('Please select', ''),
        ];

        $working_hour = WorkingHour::findOrFail($id);

        return view('admin.working_hours.edit', compact('working_hour') + $relations);
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
        if (! Gate::allows('working_hour_edit')) {
            return abort(401);
        }
        $working_hour = WorkingHour::findOrFail($id);
        $working_hour->update($request->all());
        
        return redirect()->route('admin.working_hours.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('working_hour_delete')) {
            return abort(401);
        }
        $working_hour = WorkingHour::findOrFail($id);
        $working_hour->delete();

        return redirect()->route('admin.working_hours.index');
    }

    public function massDestroy(Request $request)
    {
        if (! Gate::allows('working_hour_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = WorkingHour::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }
}

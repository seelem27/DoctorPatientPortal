<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Nurse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;

class NursesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('nurse_access')) {
            return abort(401);
        }

        $nurses = Nurse::all();

        return view('admin.nurses.index', compact('nurses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('nurse_create')) {
            return abort(401);
        }

        return view('admin.nurses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::allows('nurse_create')) {
            return abort(401);
        }

        $nurse = Nurse::create($request->all());

        return redirect()->route('admin.nurses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('nurse_view')) {
            return abort(401);
        }

        $nurse = Nurse::findOrFail($id);

        return view('admin.nurses.show', compact('nurse'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('nurse_edit')) {
            return abort(401);
        }

        $nurse = Nurse::findOrFail($id);

        return view('admin.nurses.edit', compact('nurse'));
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
        if (! Gate::allows('nurse_edit')) {
            return abort(401);
        }

        $nurse = Nurse::findOrFail($id);

        $nurse->update($request->all());

        return redirect()->route('admin.nurses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('nurse_delete')) {
            return abort(401);
        }

        $nurse = Nurse::findOrFail($id);
        $nurse->delete();

        return redirect()->route('admin.nurses.index');
    }

    public function massDestroy(Request $request)
    {
        if (! Gate::allows('nurse_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Nurse::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }
}

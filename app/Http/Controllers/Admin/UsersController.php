<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\User;
use App\Patient;
use App\Doctor;
use App\Nurse;
use App\WorkingHour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('user_access')) {
            return abort(401);
        }

        $users = User::withTrashed()->get();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('user_create')) {
            return abort(401);
        }
        $relations = [
            'roles' => \App\Role::get()->pluck('title', 'id')->prepend('Please select', ''),
        ];

        return view('admin.users.create', $relations);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::allows('user_create')) {
            return abort(401);
        }
        //$user = User::create($request->all());
        $user = new User;
        $user->fill($request->all());
        if($user->role_id == 4) {
            $user->save();
            $patient = new Patient;
            $patient->fill($request->all());
            $patient->user_id = $user->id;
            $patient->save();
        } 
        else if ($user->role_id == 3) {
            $user->save();
            $doctor = new Doctor;
            $doctor->fill($request->all());
            $doctor->user_id = $user->id;
            $doctor->save();
        } else if ($user->role_id == 2) {
            $user->save();
            $nurse = new Nurse;
            $nurse->fill($request->all());
            $nurse->user_id = $user->id;
            $nurse->save();
        }

        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('user_view')) {
            return abort(401);
        }

        Auth::user()->id;

        $relations = [
            'roles' => \App\Role::get()->pluck('title', 'id')->prepend('Please select', ''),
        ];

        $user = User::findOrFail($id);

        return view('admin.users.show', compact('user') + $relations);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('user_edit')) {
            return abort(401);
        }
        $relations = [
            'roles' => \App\Role::get()->pluck('title', 'id')->prepend('Please select', ''),
        ];

        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user') + $relations);
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
        if (! Gate::allows('user_edit')) {
            return abort(401);
        }
        $user = User::findOrFail($id);
        $user->update($request->all());

        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('user_delete')) {
            return abort(401);
        }

        $patient = Patient::where('user_id', $id);
        $doctor = Doctor::where('user_id', $id);
        $nurse = Nurse::where('user_id', $id);
        $user = User::findOrFail($id);
        $user->delete();
        $patient->delete();
        $doctor->delete();
        $nurse->delete();

        return redirect()->route('admin.users.index');
    }

    public function restoreUser($id) 
    {
        if (! Gate::allows('user_status')) {
            return abort(401);
        }

        $patient = Patient::where('user_id', $id)->onlyTrashed();
        $doctor = Doctor::where('user_id', $id)->onlyTrashed();
        $nurse = Nurse::where('user_id', $id)->onlyTrashed();
        $user = User::onlyTrashed()->find($id);
        if($user)
        {
            $user->restore();
            $patient->restore();
            $doctor->restore();
            $nurse->restore();
        } 

        return redirect()->route('admin.users.index');
    }

    public function massDestroy(Request $request)
    {
        if (! Gate::allows('user_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = User::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }
}

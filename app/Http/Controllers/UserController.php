<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index()
    {
        return view('pages.user.index');
    }

        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Team::all();
        return view('pages.user.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:30',
            'email' => 'email',
            'password' => 'confirmed|min:8',
        ]);

        // User::create([
        //     'name' => $request['name'],
        //     'password' => Hash::make($request['password']),
        //     'email' => $request['email'],
        //     'current_team_id' => $request['current_team_id'],
        // ]);

        DB::transaction(function () use ($request) {
            return tap(User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]), function (User $user) use ($request) {
                $selected_team = $request['current_team_id'];
                $team = Team::where('id', $selected_team)->first();
                $user->teams()->attach($team, array('role' => 'guest'));
                $user->switchTeam($team);
            });
        });

        Alert::success('Success!', 'Data has been succesfully created.');

        return redirect('/user');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $data = Team::all();
        return view('pages.user.edit', compact('user', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|min:3|max:30',
            'email' => 'email',
            'current_team_id' => 'required'
        ]);
         
        $user->update($request->all());

        Alert::success('Success!', 'Data has been succesfully updated.');

        return redirect('/user');
    }

}

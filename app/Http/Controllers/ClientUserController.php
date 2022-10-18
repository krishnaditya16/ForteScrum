<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ClientUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.client.user-index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Team::all();
        return view('pages.client.user-create', compact('data'));
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
            'email' => 'required|email|unique:users',
            'password' => 'confirmed|min:8',
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'address' => 'required'
        ]);

        $user = DB::transaction(function () use ($request) {
            return tap(User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]), function (User $user) use ($request) {
                $selected_team = $request['current_team_id'];
                $team = Team::where('id', $selected_team)->first();
                $user->teams()->attach($team, array('role' => 'product-owner'));
                $user->switchTeam($team);
            });
        });

        $client = Client::create([
            'name' => $request['company_name'],
            'email' => $request['company_email'],
            'phone_number' => $request['phone_number'],
            'address' => $request['address'],
            'user_id' => $user->id,
        ]);

        DB::table('users')->where('id', $user->id)->update(['client_id' => $client->id]);

        Alert::success('Success!', 'Data has been succesfully created.');
        
        return redirect('/client-user');
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

}

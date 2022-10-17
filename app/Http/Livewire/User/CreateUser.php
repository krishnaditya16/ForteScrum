<?php

namespace App\Http\Livewire\User;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class CreateUser extends Component
{
    public $name, $email, $password, $currentTeamId;

    /**
     * store function
     */
    public function store()
    {
        $this->validate([
            'name'   => 'required',
            'email' => 'required',
            'password' => 'required',
            'current_team_id' => 'required',
        ]);

        $user = User::create([
            'name'   => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'current_team_id' => $this->currentTeamId,
        ]);

        $user->save();

        //flash message
        session()->flash('message', 'Data Berhasil Disimpan.');

        //redirect
        return redirect()->route('user.data');
    }

    public function render()
    {
        $data = Team::all();
        return view('livewire.user.create-user', compact('data'));
    }
}

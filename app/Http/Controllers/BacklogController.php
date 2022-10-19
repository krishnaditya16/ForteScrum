<?php

namespace App\Http\Controllers;

use App\Models\Backlog;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class BacklogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.backlog.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = Project::all();
        return view('pages.backlog.create', compact('projects'));
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
            'name' => 'required',
            'project_id' => 'required',
        ]);

        Backlog::create($request->all());

        Alert::success('Success!', 'Data has been succesfully created.');

        return redirect('/backlog');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Backlog $backlog)
    {
        $data = Backlog::join('projects', 'backlogs.project_id', 'projects.id')->select('team_id')->first();
        $current_team = Auth::user()->currentTeam;
        $projects = Project::all();
        
        if (empty($data) || $current_team->id != $data->team_id) {
            abort(403);
        }
        else {
            return view('pages.backlog.edit', compact('projects', 'backlog'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Backlog $backlog)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'max:5000',
            'project_id' => 'required',
        ]);

        $desc = $request->description;

        if($desc == "<p><br></p>"){
            $backlog->update([
                'name' => $request['name'],
                'description' => "",
                'project_id' => $request['project_id']
            ]);
        } else {
            $backlog->update($request->all());
        }

        Alert::success('Success!', 'Data has been succesfully updated.');

        return redirect('/backlog');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

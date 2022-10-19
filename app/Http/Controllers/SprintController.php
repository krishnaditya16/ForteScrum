<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Sprint;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class SprintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.sprint.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = Project::all();
        return view('pages.sprint.create', compact('projects'));
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
            'name' => ['required', 'numeric', 'min:1',Rule::unique('sprints')->where(function ($query) use ($request) {
                return $query->where('project_id', $request->project_id);
            })],
            'project_id' => 'required',
        ],[
            'name.unique' => 'Sprint iteration already exist for selected project.',
            'name.required' => 'The sprint iteration field is required.',
            'project_id.required' => 'The project field is required.',
        ]);

        Sprint::create($request->all());

        Alert::success('Success!', 'Data has been succesfully created.');

        return redirect('/sprint');
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
    public function edit(Sprint $sprint)
    {
        $data = Sprint::join('projects', 'sprints.project_id', 'projects.id')->select('team_id')->first();
        $current_team = Auth::user()->currentTeam;
        $projects = Project::all();
        
        if (empty($data) || $current_team->id != $data->team_id) {
            abort(403);
        }
        else {
            return view('pages.sprint.edit', compact('projects', 'sprint'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sprint $sprint)
    {
        $request->validate([
            'name' => ['required', 'numeric', 'min:1', Rule::unique('sprints')->ignore($sprint->id)->where(function ($query) use ($request) {
                return $query->where('project_id', $request->project_id);
            })],
            'project_id' => 'required',
        ],[
            'name.unique' => 'Sprint iteration already exist for selected project.',
            'name.required' => 'The sprint iteration field is required.',
            'project_id.required' => 'The project field is required.',
        ]);

        $desc = $request->description;

        if($desc == "<p><br></p>"){
            $sprint->update([
                'name' => $request['name'],
                'description' => "",
                'project_id' => $request['project_id']
            ]);
        } else {
            $sprint->update($request->all());
        }

        Alert::success('Success!', 'Data has been succesfully updated.');

        return redirect('/sprint');
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

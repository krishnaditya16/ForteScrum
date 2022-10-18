<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;
use Laravel\Jetstream\Jetstream;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.project.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teams = Team::all();
        $clients = Client::all();
        return view('pages.project.create', compact('teams', 'clients'));
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
            'title' => 'required|min:3|max:30',
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'category' => 'required',
            'platform' => 'required',
            'proposal' => 'required|mimes:pdf,docx|max:2048',
            'team_id' => 'required',
            'client_id' => 'required',
        ]);

        $input = $request->all();
  
        if ($proposalFile = $request->file('proposal')) {
            $destinationPath = 'uploads/proposal';
            $proposalName1 = $proposalFile->getClientOriginalName();
            $proposalName2 = explode('.', $proposalName1)[0]; // Filename 'filename'
            $proposalName = $proposalName2 . "_" . date('YmdHis') . "." . $proposalFile->getClientOriginalExtension();
            $proposalFile->move($destinationPath, $proposalName);
            $input['proposal'] = "$proposalName";
        } else {
            unset($input['proposal']);
        } 

        Project::create($input);

        Alert::success('Success!', 'Data has been succesfully updated.');

        return redirect('/project');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        // $team = Team::where('id', $project->team_id)->get();
        // $data = $team->users;
        $team = Jetstream::newTeamModel()->findOrFail($project->team_id);

        $data = [];

        foreach ($team->users as $user) {
            $data[] = $user->id;
        }

        $po = DB::table('team_user')
            ->join('users', 'team_user.user_id', 'users.id')
            ->whereIn('user_id', $data)->where('role', 'product-owner')
            ->get();
        
        $pm = DB::table('team_user')
            ->join('users', 'team_user.user_id', 'users.id')
            ->whereIn('user_id', $data)->where('role', 'project-manager')
            ->get();
        
        $tm = DB::table('team_user')
            ->join('users', 'team_user.user_id', 'users.id')
            ->whereIn('user_id', $data)->where('role', 'team-member')
            ->get();
        
        $client = Client::where('id', $project->client_id)->first();

        return view('pages.project.show', compact('project', 'client', 'po', 'pm', 'tm'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $teams = Team::all();
        $clients = Client::all();
        return view('pages.project.edit', compact('project', 'teams', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|min:3|max:30',
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'progress' => 'required|integer|between:0,100',
            'category' => 'required',
            'platform' => 'required',
            'proposal' => 'mimes:pdf,docx|max:2048',
            'team_id' => 'required',
            'client_id' => 'required'
        ]);

        $input = $request->all();
  
        if ($proposalFile = $request->file('proposal')) {

            if($oldFile = $project->proposal) {
                unlink(public_path('uploads/proposal/') . $oldFile);
            }

            $destinationPath = 'uploads/proposal';
            // $proposalName = date('YmdHis') . "_" . $proposalFile->getClientOriginalName() . "." .$proposalFile->getClientOriginalExtension();
            $proposalName1 = $proposalFile->getClientOriginalName();
            $proposalName2 = explode('.', $proposalName1)[0]; // Filename 'filename'
            $proposalName = $proposalName2 . "_" . date('YmdHis') . "." . $proposalFile->getClientOriginalExtension();
            $proposalFile->move($destinationPath, $proposalName);
            $input['proposal'] = "$proposalName";
        } else {
            unset($input['proposal']);
        } 

        $project->update($input);

        Alert::success('Success!', 'Data has been succesfully updated.');

        return redirect('/project');
    }

    public function downloadProposal(Project $project, $id) {
        $data = $project->where('id', $id)->first();
        $file = public_path("uploads/proposal/".$data->proposal);
        return response()->download($file);
    }

    public function approve($id)
    {
        $project = Project::find($id);
        return view('pages.project.approval', compact('project'));
    }

    public function approveProject(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $user = Project::find($id);
        $user->update([
            'status' => $request->status,
        ]);

        Alert::success('Success!', 'Status has been succesfully updated.');

        return redirect('/project');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $teams = Auth::user()->currentTeam;

        $data = [];
        foreach ($teams->users as $user) {
            $data[] = $user->id;
        }

        $clients = DB::table('team_user')
            ->join('users', 'team_user.user_id', 'users.id')
            ->join('clients', 'users.client_id', 'clients.id')
            ->whereIn('team_user.user_id', $data)->where('role', 'product-owner')
            ->select('clients.id', 'clients.name')
            ->first();

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
            'project_date' => 'required',
            'category' => 'required',
            'platform' => 'required',
            'proposal' => 'required|mimes:pdf,docx|max:2048',
            'team_id' =>  'required',
            'client_id' => 'required'
        ]);

        $dates = explode(' - ', $request->project_date);
        $start_date = Carbon::parse($dates[0]);
        $end_date = Carbon::parse($dates[1]);

        $file = $request->file('proposal');

        if ($proposalFile = $request->file('proposal')) {
            $destinationPath = 'uploads/proposal';
            $proposalName1 = $proposalFile->getClientOriginalName();
            $proposalName2 = explode('.', $proposalName1)[0]; // Filename 'filename'
            $proposalName = $proposalName2 . "_" . date('YmdHis') . "." . $proposalFile->getClientOriginalExtension();
            $proposalFile->move($destinationPath, $proposalName);
            $file = "$proposalName";
        } else {
            unset($file);
        }

        Project::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'title' => $request['title'],
            'description' => $request['description'],
            'start_date' => $start_date,
            'end_date' => $end_date,
            'category' => $request['category'],
            'platform' => $request['platform'],
            'proposal' => $proposalName,
            'team_id' => $request['team_id'],
            'client_id' => $request['client_id'],
        ]);
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

        $users = $team->allUsers();
        $po = [];
        $pm = [];
        $tm = [];
        $data = [];

        foreach ($team->users as $user) {
            $data[] = $user->id;
        }
        
        foreach($users as $user){
            if($user->hasTeamRole($team, 'product-owner') && !$user->ownsTeam($team)){
                $po[] = $user;
            }
        }

        foreach($users as $user){
            if($user->hasTeamRole($team, 'project-manager')){
                $pm[] = $user;
            }
        }

        foreach($users as $user){
            if($user->hasTeamRole($team, 'team-member') && !$user->ownsTeam($team)){
                $tm[] = $user;
            }
        }

        $team_owner = DB::table('teams')
            ->join('users', 'teams.user_id', 'users.id')->first();

        $client = Client::where('id', $project->client_id)->first();

        $data = Project::find($project->id);
        $current_team = Auth::user()->currentTeam;

        $date_now = Carbon::now();
        $due_date = date('Y-m-d', strtotime($project->end_date));
        $date_diff = ($date_now->diffInDays($due_date)) + 1;
        $task = Task::where('project_id', $project->id)->get();
        $team = Team::where('id', $project->team_id)->first();

        if (empty($data) || $current_team->id != $data->team_id) {
            abort(403);
        } else {
            return view('pages.project.show', compact(
                'project', 'client', 'po', 'pm', 'tm', 'team_owner','date_now', 'due_date', 'date_diff', 'task', 'team'
            ));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $data = Project::find($project->id);
        $teams = Team::all();
        $clients = Client::all();
        $current_team = Auth::user()->currentTeam;

        $start_date = $project->start_date;
        $end_date = $project->end_date;
        $arr = array($start_date, $end_date);
        $dates = implode(' - ', $arr);

        if (empty($data) || $current_team->id != $data->team_id) {
            abort(403);
        } else {
            if(Auth::user()->hasTeamPermission($current_team, 'edit:project')){
                return view('pages.project.edit', compact('project', 'teams', 'clients', 'dates'));
            } else {
                abort(403);
            }
            
        }
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
            'project_date' => 'required',
            'category' => 'required',
            'platform' => 'required',
            'proposal' => 'mimes:pdf,docx|max:2048',
            'team_id' => 'required',
            'client_id' => 'required',
        ]);

        $dates = explode(' - ', $request->project_date);
        $start_date = Carbon::parse($dates[0]);
        $end_date = Carbon::parse($dates[1]);

        $file = $request->file('proposal');
        $proposal = $project->proposal;

        if ($proposalFile = $request->file('proposal')) {

            if ($oldFile = $project->proposal) {
                unlink(public_path('uploads/proposal/') . $oldFile);
            }

            $destinationPath = 'uploads/proposal';
            // $proposalName = date('YmdHis') . "_" . $proposalFile->getClientOriginalName() . "." .$proposalFile->getClientOriginalExtension();
            $proposalName1 = $proposalFile->getClientOriginalName();
            $proposalName2 = explode('.', $proposalName1)[0]; // Filename 'filename'
            $proposalName = $proposalName2 . "_" . date('YmdHis') . "." . $proposalFile->getClientOriginalExtension();
            $proposalFile->move($destinationPath, $proposalName);
            $file = "$proposalName";
        } else {
            unset($file);
        }

        if (empty($file)) {
            $project->update([
                'name' => $request['name'],
                'email' => $request['email'],
                'title' => $request['title'],
                'description' => $request['description'],
                'progress' => $request['progress'],
                'start_date' => $start_date,
                'end_date' => $end_date,
                'status' => $request->status,
                'category' => $request->category,
                'platform' => $request->platform,
                'proposal' => $proposal,
                'team_id' => $request['team_id'],
                'client_id' => $request['client_id'],
            ]);
        } else if ($project->status == 0) {
            $project->update([
                'name' => $request['name'],
                'email' => $request['email'],
                'title' => $request['title'],
                'description' => $request['description'],
                'progress' => 0,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'category' => $request['category'],
                'platform' => $request['platform'],
                'proposal' => $proposalName,
                'team_id' => $request['team_id'],
                'client_id' => $request['client_id'],
            ]);
        } else {
            $project->update([
                'name' => $request['name'],
                'email' => $request['email'],
                'title' => $request['title'],
                'description' => $request['description'],
                'progress' => $request['progress'],
                'start_date' => $start_date,
                'end_date' => $end_date,
                'status' => $request->status,
                'category' => $request['category'],
                'platform' => $request['platform'],
                'proposal' => $proposalName,
                'team_id' => $request['team_id'],
                'client_id' => $request['client_id'],
            ]);
        }

        Alert::success('Success!', 'Data has been succesfully updated.');

        return redirect('/project');
    }

    public function downloadProposal(Project $project, $id)
    {
        $data = $project->where('id', $id)->first();
        $file = public_path("uploads/proposal/" . $data->proposal);
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

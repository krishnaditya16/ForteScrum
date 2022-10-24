<?php

namespace App\Http\Controllers;

use App\Models\Backlog;
use App\Models\Board;
use App\Models\Project;
use App\Models\Sprint;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Jetstream\Jetstream;
use RealRashid\SweetAlert\Facades\Alert;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.task.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = Project::all();
        $users = User::all();
        $boards = Board::all();
        return view('pages.task.create', compact('projects', 'users', 'boards'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|min:3|max:30',
            'description' => 'required',
            'project_date' => 'required',
            'category' => 'required',
            'platform' => 'required',
            'proposal' => 'required|mimes:pdf,docx|max:2048',
            'team_id' => 'required',
            'client_id' => 'required',
        ]);
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
    public function edit($id)
    {
        //
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
        //
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

    public function taskList($id)
    {
        $data = Project::find($id);
        $boards = Board::with('tasks')->where('project_id', $data->id)->get();
        $options = Board::where('project_id', $data->id)->get();

        $backlogs = Backlog::where('project_id', $data->id)->get();
        $sprints = Sprint::where('project_id', $data->id)->get();
        $date_now = Carbon::now();

        $team = Jetstream::newTeamModel()->findOrFail($data->team_id);
        $project = [];
        foreach ($team->users as $user) {
            $project[] = $user->id;
        }

        $owner = DB::table('team_user')
            ->join('users', 'team_user.user_id', 'users.id')
            ->whereIn('user_id', $project)->where('role', 'product-owner')
            ->get();
        
        return view('pages.project.task.kanban', compact('data', 'boards', 'options', 'owner', 'backlogs', 'sprints', 'date_now'));
    }

    public function tableView($id) 
    {
        $data = Project::find($id);
        return view('pages.project.task.table', compact('data'));
    }

    public function taskFinished($id)
    {
        $data = Project::find($id);
        $boards = Board::with('tasks')->where('project_id', $data->id)->get();
        $options = Board::where('project_id', $data->id)->get();

        $backlogs = Backlog::where('project_id', $data->id)->get();
        $sprints = Sprint::where('project_id', $data->id)->get();

        $team = Jetstream::newTeamModel()->findOrFail($data->team_id);
        $project = [];
        foreach ($team->users as $user) {
            $project[] = $user->id;
        }

        $owner = DB::table('team_user')
            ->join('users', 'team_user.user_id', 'users.id')
            ->whereIn('user_id', $project)->where('role', 'product-owner')
            ->get();
        
        return view('pages.project.task.finished', compact('data', 'boards', 'options', 'owner', 'backlogs', 'sprints'));
    }

    public function createTask($id)
    {
        $projects = Project::where('id', $id)->first();
        $boards = Board::where('project_id', $id)->get();
        $sprints = Sprint::where('project_id', $id)->get();
        $backlogs = Backlog::where('project_id', $id)->get();

        $team = Jetstream::newTeamModel()->findOrFail($projects->team_id);

        $data = [];

        foreach ($team->users as $user) {
            $data[] = $user->id;
        }

        $users = DB::table('team_user')
            ->join('users', 'team_user.user_id', 'users.id')
            ->whereIn('user_id', $data)->where('role', 'team-member')
            ->get();

        return view('pages.project.task.create-task', compact('projects', 'users', 'boards', 'sprints', 'backlogs'));
    }

    public function storeTask(Request $request)
    {
        // $data = $request->validate([
        //     'title' => 'required',
        //     'description' => 'required',
        //     'task_date' => 'required',
        //     'priority' => 'required',
        //     'board_id' => 'required',
        //     'sprint_id' => 'required',
        //     'project_id' => 'required',
        //     'backlog_id' => 'required',
        //     'assignee' => 'required'

        // ]);

        // $data['assignee'] = implode(',', $request->assignee);

        // $dates = explode(' - ', $request->task_date);
        // $start_date = Carbon::parse($dates[0]);
        // $end_date = Carbon::parse($dates[1]);

        // Task::create([
        //     'title' => $request['title'],
        //     'description' => $request['description'],
        //     'start_date' => $start_date,
        //     'end_date' => $end_date,
        //     'priority' => $request['priority'],
        //     'board_id' => $request['board_id'],
        //     'sprint_id' => $request['sprint_id'],
        //     'project_id' => $request['project_id'],
        //     'backlog_id' => $request['backlog_id'],
        //     'assignee' => $data['assignee'],
        // ]);

        // Alert::success('Success!', 'Task has been succesfully created.');

        // $project_id = $request->project_id;
        // return redirect()->route('project.task', $project_id);
        $user = User::whereIn('id', $request->assignee)->get();
        return dd($user);
    }

    public function moveTask(Request $request, $id) 
    {
        $request->validate([
            'board_id' => 'required',
        ]);

        $task = Task::find($id);
        $task->update([
            'board_id' => $request->board_id,
        ]);

        return back();
    }

    public function taskStatus(Request $request, $id) 
    {
        $request->validate([
            'status' => 'required',
        ]);

        $task = Task::find($id);
        $task->update([
            'status' => $request->status,
        ]);

        if($request->status == "1"){
            Alert::success('Success!', 'Task has been marked as done.');
            return back();
        } else {
            Alert::success('Success!', 'Task has been moved back to in progress kanban.');
            return back();
        }
    }

    public function editTask($id, Task $task)
    {
        $projects = Project::where('id', $id)->first();
        $boards = Board::where('project_id', $id)->get();
        $sprints = Sprint::where('project_id', $id)->get();
        $backlogs = Backlog::where('project_id', $id)->get();

        $team = Jetstream::newTeamModel()->findOrFail($projects->team_id);

        $data = [];

        foreach ($team->users as $user) {
            $data[] = $user->id;
        }

        $start_date = $task->start_date;
        $end_date = $task->end_date;
        $arr = array($start_date, $end_date);
        $dates = implode(' - ', $arr);

        $arr_user = $task->assignee;
        $assignee = explode(",",$arr_user);
        

        $users = DB::table('team_user')
            ->join('users', 'team_user.user_id', 'users.id')
            ->whereIn('user_id', $data)->where('role', 'team-member')
            ->get();

        $current_team = Auth::user()->currentTeam;

        if (empty($projects) || $current_team->id != $projects->team_id) {
            abort(403);
        } else if ($task->project_id != $id){
            abort(404);
        } else {
            return view('pages.project.task.edit-task', compact('task', 'projects', 'users', 'boards', 'sprints', 'backlogs', 'dates', 'assignee'));
        }  
    }

    public function updateTask(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'task_date' => 'required',
            'priority' => 'required',
            'board_id' => 'required',
            'sprint_id' => 'required',
            'project_id' => 'required',
            'backlog_id' => 'required',
            'task_id' => 'required',
            'assignee' => 'required'

        ]);

        $data['assignee'] = implode(',', $request->assignee);

        $dates = explode(' - ', $request->task_date);
        $start_date = Carbon::parse($dates[0]);
        $end_date = Carbon::parse($dates[1]);
        
        $id = $request->task_id;
        $task = Task::where('id', $id);
        $task->update([
            'title' => $request['title'],
            'description' => $request['description'],
            'start_date' => $start_date,
            'end_date' => $end_date,
            'priority' => $request['priority'],
            'board_id' => $request['board_id'],
            'sprint_id' => $request['sprint_id'],
            'project_id' => $request['project_id'],
            'backlog_id' => $request['backlog_id'],
            'assignee' => $data['assignee'],
        ]);

        Alert::success('Success!', 'Task has been succesfully updated.');

        $project_id = $request->project_id;
        return redirect()->route('project.task', $project_id);
    }

    public function destroyTask($id)
    {
        Task::where('id', $id)->delete();

        Alert::success('Success!', 'Task has been succesfully deleted.');

        return back();
    }
}

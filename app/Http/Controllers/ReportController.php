<?php

namespace App\Http\Controllers;

use App\Models\Backlog;
use App\Models\Project;
use App\Models\Sprint;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Jetstream\Jetstream;

class ReportController extends Controller
{
    public function index()
    {
        return view('pages.report.index');
    }

    public function sprintReport($id)
    {
        $project = Project::find($id);
        $backlogs = Backlog::where('project_id', $project->id)->get();
        $sprints = Sprint::where('project_id', $project->id)->get();
        $tasks = Task::where('project_id', $project->id)->get();

        $current_team = Auth::user()->currentTeam;
        $team = Jetstream::newTeamModel()->findOrFail($project->team_id);

        $data = [];

        foreach ($team->users as $user) {
            $data[] = $user->id;
        }

        $users = DB::table('team_user')
            ->join('users', 'team_user.user_id', 'users.id')
            ->whereIn('user_id', $data)->where('role', 'team-member')
            ->get();

        $total_member = count($users);

        if (empty($project) || $current_team->id != $project->team_id) {
            abort(403);
        }
        else {
            return view('pages.report.sprint-report', compact('project', 'backlogs', 'sprints', 'tasks', 'total_member'));
        }
    }

    public function timesheetReport($id)
    {
        $project = Project::find($id);
        $backlogs = Backlog::where('project_id', $project->id)->get();
        $sprints = Sprint::where('project_id', $project->id)->get();
        $tasks = Task::where('project_id', $project->id)->get();

        $current_team = Auth::user()->currentTeam;
        $team = Jetstream::newTeamModel()->findOrFail($project->team_id);

        $data = [];

        foreach ($team->users as $user) {
            $data[] = $user->id;
        }

        $users = DB::table('team_user')
            ->join('users', 'team_user.user_id', 'users.id')
            ->whereIn('user_id', $data)->where('role', 'team-member')
            ->get();

        $total_member = count($users);

        return view('pages.report.timesheet-report', compact('project', 'backlogs', 'sprints', 'tasks', 'total_member'));
    }
}

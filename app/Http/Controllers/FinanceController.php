<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Expense;
use App\Models\Project;
use App\Models\Task;
use App\Models\Timesheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class FinanceController extends Controller
{
    public function index()
    {
        return view('pages.finance.index');
    }
    
    public function manageBudget($id)
    {
        $project = Project::find($id);
        $team = Auth::user()->currentTeam;

        $arr = [];
        foreach ($team->users as $user) {
            $arr[] = $user->id;
        }

        $client = DB::table('team_user')
            ->join('users', 'team_user.user_id', 'users.id')
            ->join('clients', 'users.client_id', 'clients.id')
            ->whereIn('team_user.user_id', $arr)->where('role', 'product-owner')
            ->select('clients.id', 'clients.name')
            ->first();
        
        $spending = Expense::where('project_id', $project->id)->where('expenses_status', 1)->sum('ammount')/100;

        if ($team->id != $project->team_id) {
            abort(403);
        } else {
            return view('pages.finance.budget.manage', compact('project', 'team', 'client', 'spending'));
        }
    }

    public function updateBudget(Request $request, $id)
    {
        $request->validate([
            'budget' => 'required',
        ]);

        $numbers = explode(',', $request->budget);
        $budget = (int)join('', $numbers);

        $project = Project::find($id);
        $project->update([
            'budget' => $budget,
        ]);

        Alert::success('Success!', 'Project budget has been succesfully updated.');

        return redirect()->route('project.show', $project->id);
    }

    public function manageExpenses($id)
    {
        $project = Project::find($id);
        $team = Auth::user()->currentTeam;

        if($project->team_id != $team->id){
            abort(403);
        } else {
            return view('pages.finance.expenses.index', compact('project', 'team'));
        }  
    }

    public function manageInvoice($id)
    {
        $project = Project::find($id);
        $team = Auth::user()->currentTeam;

        if($project->team_id != $team->id){
            abort(403);
        } else {
            return view('pages.finance.invoice.index', compact('project', 'team'));
        }  
    }

    public function createInvoice($id)
    {
        $team = Auth::user()->currentTeam;
        $arr = [];
        foreach ($team->users as $user) {
            $arr[] = $user->id;
        }

        $client = Client::whereIn('user_id', $arr)->first();
        $tasks = Task::where('project_id', $id)->get();
        $timesheets = Timesheet::with('tasks')->where('project_id', $id)->get();
        $expenses = Expense::where('project_id', $id)->get();

        $project = Project::find($id);

        $inv = Task::latest()->first();

        return view('pages.finance.invoice.create', compact('project', 'client', 'tasks', 'timesheets','expenses', 'inv'));
    }

    public function storeInvoice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'total_all' => 'required',
        ]);

        if($validator->fails()){
            if($validator->errors()->has('total_all')){
                Alert::warning('Warning!', 'Please input all the data before submitting the form');
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();

            }
        }

        return dd($request->total_all);
    }

    public function getTaskData($id)
    {
        $task = Task::where('project_id', $id)->get();
        return response()->json($task);
    }

    public function getTimesheetData($id)
    {
        $timesheet = Timesheet::join('tasks', 'timesheets.task_id', 'tasks.id')
                            ->where('timesheets.project_id', $id)
                            ->select('tasks.*' ,'timesheets.id as time_id', 'timesheets.start_time', 'timesheets.end_time')
                            ->get();

        return response()->json($timesheet);
    }
}
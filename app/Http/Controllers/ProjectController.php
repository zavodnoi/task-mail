<?php

namespace App\Http\Controllers;

use App\Event;
use App\Log;
use App\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $year = intval($request->get('year'));
        $month = intval($request->get('month'));
        if(empty($year) || empty($month)){
            $year = Carbon::now()->year;
            $month = Carbon::now()->month;
        }
        $projects = Project::all();
        $weeks = Event::getRoadMap($year, $month);

        return view('project-index', compact('projects', 'weeks', 'year', 'month'));
    }

    public function create()
    {
        return view('project-form');
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $project_id = Project::create($data);
        Log::add($project_id);

        return redirect()->route('project.index');
    }
}

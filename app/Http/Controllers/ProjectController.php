<?php

namespace App\Http\Controllers;

use App\Events;
use App\Projects;
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
        $projects = Projects::all();
        $weeks = Events::getRoadMap($year, $month);

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

        Projects::create($data);

        return redirect()->route('project.index');
    }

    public function delete()
    {

    }
}

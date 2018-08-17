<?php

namespace App\Http\Controllers;

use App\Projects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ProjectController extends Controller
{
    public function index()
    {
        $projects = Projects::all();
        return view('project-index', compact('projects'));
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

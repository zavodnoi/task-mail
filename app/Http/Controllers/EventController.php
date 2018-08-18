<?php

namespace App\Http\Controllers;

use App\DictionaryTypes;
use App\Events;
use App\Projects;
use App\User;
use Carbon\Carbon;
use Validator;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function show(Events $event)
    {
        return view('event-show', compact('event'));
    }
    public function create()
    {
        $projects = Projects::all()->pluck('name', 'id');
        $types = DictionaryTypes::all()->pluck('name', 'id');
        $event = new Events();

        return view('event-form', compact('projects', 'types', 'event'));
    }

    public function store(Request $request)
    {
        $event = new Events();
        $data = $request->except('_token');
        $event->fill($data);
        $validator = Validator::make($data, [
            'started_at' => 'required|date',
            'short_description' => 'required|string|max:255',
            'full_description' => 'required|string|max:5000',
            'project_id' => 'required|exists:projects,id',
            'dictionary_type_id' => 'required|exists:dictionary_types,id',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('event', $event);
        }

        Events::create($data);

        return redirect()->route('project.index');
    }

    public function edit(Events $event)
    {
        $projects = Projects::all()->pluck('name', 'id');
        $types = DictionaryTypes::all()->pluck('name', 'id');

        return view('event-form', compact('projects', 'types', 'event'));
    }

    public function update(Events $event, Request $request)
    {
        $data = array_filter($request->except('_token'), 'trim');

        $rules = [
            'started_at' => 'required|date',
            'short_description' => 'required|string|max:255',
            'full_description' => 'required|string|max:5000',
            'project_id' => 'required|exists:projects,id',
            'dictionary_type_id' => 'required|exists:dictionary_types,id',
        ];
        if($data['started_at'] != $event->started_at->format('Y-m-d')){
            $rules['cause_of_change'] = 'required|string|max:5000';
        }

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('event', $event);
        }

        $event->update($data);

        return redirect()->route('project.index');
    }

    public function destroy(Events $event, Request $request)
    {
        $data = $request->except('_token');
        $data['cause_of_change'] = trim($data['cause_of_change']);
        $validator = Validator::make($data, [
            'cause_of_change' => 'required|string|max:5000',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data['deleted_at'] = Carbon::now();
        $event->update($data);

        return redirect()->route('project.index');

    }

    public function deleteCause(Events $event)
    {
        return view('event-cause-form', compact('event'));
    }

    public function finish(Events $event)
    {
        $event->update(['finished_at' => Carbon::now()]);
        return redirect()->route('event.show', $event->id);
    }

    public function accessEdit(Events $event)
    {
        $users = User::where('id', '<>', $event->user_id)->pluck('name', 'id');
        $access_users = $event->accessUsers()->get()->groupBy('type');
        $read_access = [];
        $edit_access= [];
        if($access_users->get('read')){
            $read_access = $access_users->get('read')->pluck('user_id')->map('intval')->all();
        }
        if($access_users->get('edit')) {
            $edit_access = $access_users->get('edit')->pluck('user_id')->map('intval')->all();
        }

        return view('event-access-form', compact('event', 'users', 'read_access', 'edit_access'));
    }

    public function accessUpdate(Events $event)
    {
        $event->update(['finished_at' => Carbon::now()]);
        return redirect()->route('event.show', $event->id);
    }
}

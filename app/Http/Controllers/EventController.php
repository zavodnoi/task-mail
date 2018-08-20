<?php

namespace App\Http\Controllers;

use App\DictionaryTypes;
use App\Event;
use App\Log;
use App\Project;
use App\User;
use Carbon\Carbon;
use Validator;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function show(Event $event)
    {
        $this->checkAccess('read', $event);

        return view('event-show', compact('event'));
    }

    public function create()
    {
        $projects = Project::all()->pluck('name', 'id');
        $types = DictionaryTypes::all()->pluck('name', 'id');
        $event = new Event();

        return view('event-form', compact('projects', 'types', 'event'));
    }

    public function store(Request $request)
    {
        $event = new Event();
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

        $event_id = Event::create($data);
        Log::add($event_id);

        return redirect()->route('project.index');
    }

    public function edit(Event $event)
    {
        $this->checkAccess('edit', $event);

        $projects = Project::all()->pluck('name', 'id');
        $types = DictionaryTypes::all()->pluck('name', 'id');

        return view('event-form', compact('projects', 'types', 'event'));
    }

    public function update(Event $event, Request $request)
    {
        $this->checkAccess('edit', $event);

        $data = array_filter($request->except('_token'), 'trim');

        $rules = [
            'started_at' => 'required|date',
            'short_description' => 'required|string|max:255',
            'full_description' => 'required|string|max:5000',
            'project_id' => 'required|exists:projects,id',
            'dictionary_type_id' => 'required|exists:dictionary_types,id',
        ];
        if ($data['started_at'] != $event->started_at->format('Y-m-d')) {
            $rules['cause_of_change'] = 'required|string|max:5000';
        }

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('event', $event);
        }

        $event->update($data);
        Log::add($event->id);

        return redirect()->route('project.index');
    }

    public function destroy(Event $event, Request $request)
    {
        $this->checkAccess('access-edit', $event);

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
        Log::add($event->id);

        return redirect()->route('project.index');

    }

    public function deleteCause(Event $event)
    {
        $this->checkAccess('access-edit', $event);

        return view('event-cause-form', compact('event'));
    }

    public function finish(Event $event)
    {
        $this->checkAccess('finish', $event);

        $event->update(['finished_at' => Carbon::now()]);
        Log::add($event->id);

        return redirect()->route('event.show', $event->id);
    }

    public function accessEdit(Event $event)
    {
        $this->checkAccess('access-edit', $event);

        $users = User::where('id', '<>', $event->user_id)->pluck('name', 'id');
        $access_users = $event->accessUsers()->get()->groupBy('pivot.type');

        $read_access = [];
        $edit_access = [];
        if ($access_users->get('read')) {
            $read_access = $access_users->get('read')->pluck('id')->map('intval')->all();
        }
        if ($access_users->get('edit')) {
            $edit_access = $access_users->get('edit')->pluck('id')->map('intval')->all();
        }

        return view('event-access-form', compact('event', 'users', 'read_access', 'edit_access'));
    }

    public function accessUpdate(Event $event, Request $request)
    {
        $this->checkAccess('access-edit', $event);

        $validator = Validator::make($request->all(), [
            'read' => 'exists:users,id',
            'edit' => 'exists:users,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $edit = $request->get('edit', []);
        $read = array_diff($request->get('read', []), $edit);

        $sync = [];
        foreach ($read as $user_id) {
            $sync[$user_id] = ['type' => 'read'];
        }
        foreach ($edit as $user_id) {
            $sync[$user_id] = ['type' => 'edit'];
        }

        $event->accessUsers()->sync($sync);
        Log::add($event->id);

        return redirect()->route('event.show', $event->id);
    }
}

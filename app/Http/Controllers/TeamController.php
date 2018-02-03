<?php

namespace App\Http\Controllers;

use App\Source;
use App\Team;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // if (!\Entrust::can('view-destination')) return view('errors.403');
        $page_title = "Teams | Helios";
        $page_css = array('selectize.default.css');
        $no_main_header = FALSE;
        $active = 'mktmanager-teams';
        $breadcrumbs = "<i class=\"fa-fw fa fa-bullhorn\"></i>Ad Mananger <span>> Teams </span>";
        //DB::connection( 'mongodb' )->enableQueryLog();

        $teams = Team::all();

        $allSources = Source::all();
        $sources = '';

        //DB::connection('mongodb')->getQueryLog();
        //where('destination_id', $id)->orderBy('order', 'asc')->with('user', 'destination')->get();

        // TODO: only show users that haven't belonged to a team yet
        $allMembers = User::get(['username', 'id']);
        $members = '';

        return view('pages.teams', compact(
            'no_main_header',
            'page_title',
            'page_css',
            'active',
            'breadcrumbs',
            'allSources',
            'sources',
            'teams',
            'id',
            'allMembers',
            'members'
        ));
    }

    public function store()
    {
        /*if (!\Entrust::can('edit-review')) return view('errors.403');*/
        $this->validate(request(), [
            'name' => 'required|alpha_dash',
            'description' => 'required'
        ]);

        $user = auth()->user();

        $team = request('team_id') ? Team::find(request('team_id')) : new Team();

        $old_members = [];
        if(\request('team_id')) $old_members = $team->getMemberIdsArrayAttribute();

        // debug($old_members);

        /*$source = Source::find(request('source'));
        if(!$source)
        {
            return response()->json(['type' => 'error', 'message' => 'Source not found!']);
        }*/

        //$team->source_id = $source->_id;
        //$team->source_name = $source->name;

        $team->name = request('name');
        $team->description = request('description');
        $team->creator_id = $user->id;
        $team->creator_name = $user->username;

        // Add team members
        $array_members = [];

        $members = \request('members') ? explode(',', request('members')) : [];

        foreach($members as $item){
            $m = User::find($item);
            if(!$m)
            {
                return response()->json(['type' => 'error', 'message' => 'Member not found!']);
            }

            $array_members[$m->id] = array('user_id' => $m->_id, 'username' => $m->username);
        }
        $team->members = $array_members;

        // Add team sources
        $array_sources = [];

        $sources = \request('sources') ? explode(',', request('sources')) : [];

        foreach($sources as $item){
            $s = Source::find($item);
            if(!$s)
            {
                return response()->json(['type' => 'error', 'message' => 'Source not found!']);
            }

            $array_sources[$s->id] = array('source_id' => $s->id, 'source_name' => $s->name);
        }
        $team->sources = $array_sources;

        $team->save();

        if(\request('team_id')){
            $removed = array_diff($old_members, $members);
            foreach($removed as $item){
                $m = User::find($item);
                unset($m->team_id);
                unset($m->team_name);
                $m->save();
            }
        }

        foreach($members as $item){
            $m = User::find($item);
            $m->team_id = $team->id;
            $m->team_name = $team->name;
            $m->save();
        }

        if (!request('id'))
            session()->flash('message', 'Team has been created successfully');
        else
            session()->flash('message', 'Team has been updated successfully');

        return response()->json(['type' => 'success', 'url' => route('team', 'all'), 'message' => 'Team has been created!']);
    }

    public function get($id)
    {
        $team = Team::find($id);
        $member_ids_array = $team->member_ids_array;
        $team->member_ids_array = $member_ids_array;

        $source_ids_array = $team->source_ids_array;
        $team->source_ids_array = $source_ids_array;
        if ($team) {
            return response()->json(['type' => 'success', 'team' => $team]);
        } else {
            return response()->json(['type' => 'error', 'message' => "Team not found"]);
        }
    }

}

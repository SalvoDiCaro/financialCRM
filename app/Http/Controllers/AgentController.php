<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Agent;
use App\Models\Lead;
use DB;
use Auth;
use Hash;
use App\Events\UserRegistered;

class AgentController extends Controller
{
    public function index()
    {
        $agents = User::all()->reject(function ($user) {
            return $user->agent_code == '00000000';
        });

        return view('agents.index', compact('agents'));
    }

    public function create()
    {
        return view('agents.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()) {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|same:confirm-password',
                'code' => 'required|unique:agents,code',
            ]);

            $input = $request->all();

            //Hash Password
            $input['password'] = Hash::make($input['password']);

            //Create a new user and assign to a group
            $user = User::create($input);

            $agent = new Agent;

            $agent->user_id = $user->id;
            $agent->code = $input['code'];
            $agent->save();
        }

        return redirect()->route('agents.index')
            ->with('success', 'User created successfully');
    }


    public function show($id)
    {
        $user = User::find($id);

        return view('agents.show', compact('user'));
    }


    public function edit($id)
    {
        $user = User::find($id);

        return view('agents.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {

        if (Auth::user()->agent_code == '00000000') {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $id,
            ]);

            $input = $request->all();
            if (!empty($input['password'])) {
                $input['password'] = Hash::make($input['password']);
            } else {
                $input = array_except($input, array('password'));
            }

            $user = User::find($id);

            if (!empty($input['code'])) {
                $user->agent()->update(array('code' => $input['code']));
            }

            $user->update($input);
        } else {
            return redirect()->route('agents.index')
                ->with('error', 'Non sei autorizzato');
        }
        return redirect()->route('agents.index')
            ->with('success', 'Agente aggiornato correttamente');
    }


    public function destroy($id)
    {
        //Destroy user
        $user = User::find($id);

        if ($user->agent()->pluck('code')->first()) {
            $leads = DB::table('leads')
                ->join('assignments', function ($join) {
                    $join->on('leads.id', '=', 'assignments.lead_id');
                })
                ->where(function ($query) use ($user) {
                    $query->where('assignments.agent_id', $user->agent()->pluck('id')->first());
                })
                ->select('leads.id', 'name', 'surname', 'email', 'phone', 'channel', 'current_state', 'notes')
                ->get();
        }

        foreach ($leads as $lead) {
            $lead = Lead::find($lead->id);
            $lead->delete();
        }

        $user->delete();

        return redirect()->route('agents.index')
            ->with('success', $leads);
    }
}

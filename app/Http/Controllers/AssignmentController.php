<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Assignment;
use App\Models\Lead;
use Auth;
use DB;
use Illuminate\Support\Facades\Mail;

class AssignmentController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        if ($user->agent_code == '00000000') {
            $assignments = DB::table('assignments')
                ->join('leads', function ($join) {
                    $join->on('leads.id', '=', 'assignments.lead_id');
                })
                ->join('users', function ($join) {
                    $join->on('assignments.user_id', '=', 'users.id');
                })
                ->select('assignments.id', 'leads.name', 'leads.surname', 'leads.email', 'leads.phone', 'leads.channel', 'leads.current_state', 'assignments.user_id', 'assignments.created_at', 'assignments.is_direct', 'users.agent_code', 'users.name as agent_name')
                ->where('assignments.deleted_at', NULL)->get();

            foreach ($assignments as $assignment) {
                $assignment->created_at = date('d-m-Y - H:i', strtotime($assignment->created_at));
            }

            return view('assignments.index', compact('assignments'));
        }
        else {
            return redirect()->route('home')
            ->with('error', 'Non autorizzato.');
        }
    }

    public function create()
    {
        $user = Auth::user();

        if ($user->agent_code == '00000000') {


            $agent = User::where('name','GIUSEPPE RAPISARDA')->pluck('name', 'id');
            $agents = User::where('agent_code','<>','00000000')->where('agent_code','<>','99999999')->pluck('name', 'id')->union($agent);

            $leads_assigned = DB::table('leads')
                ->join('assignments', function ($join) {
                    $join->on('assignments.lead_id', '=', 'leads.id');
                })

                ->join('users', function ($join) {
                    $join->on('assignments.user_id', '=', 'users.id');
                })

                ->select('leads.id')
                ->where('assignments.deleted_at', NULL)
                ->get()->pluck('id');

            $leads = DB::table('leads')
                ->select('id', DB::raw("concat(name, ' ',surname) as name"))
                ->where('leads.deleted_at', NULL)
                ->whereNotIn('id', $leads_assigned)
                ->pluck('name', 'id');

            return view('assignments.create', compact('agents', 'leads'));

        }else{
            return redirect()->route('home')
            ->with('error', 'Non autorizzato.');
        }

    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->agent_code == '00000000') {
            request()->validate([
                'lead_id' => 'required',
                'user_id' => 'required',
                'is_direct' => 'required',
            ]);

            $assignment = assignment::create($request->all());
            $assignment->save();

            if (!($request->is_direct)) {
                $user = User::find($request->user_id);
                $to_name = $user->name;
                $to_email = $user->email;

                $lead = Lead::find($request->lead_id);

                Mail::send('mails.assignment', ["lead" => $lead], function ($message) use ($to_name, $to_email) {
                    $message->to($to_email, $to_name)
                        ->subject('Assegnazione lead');
                    $message->from('postmaster@creditodigital.it', 'Avvera');
                });
            }

            return redirect()->route('assignments.index')
                ->with('success', 'assignment created successfully.');
        }else{
            return redirect()->route('home')
            ->with('error', 'Non autorizzato.');
        }
    }


    public function show($id)
    {
        return redirect()->route('assignments.index')
            ->with('error', 'Funzione non implementata.');

            //$assignment = assignment::find($id);
        //return view('assignments.show', compact('assignment'));
    }

    public function edit(assignment $assignment)
    {

        $user = Auth::user();

        if ($user->agent_code == '00000000') {
            $assignment = assignment::find($assignment->id);

            $lead = Lead::where('id', $assignment->lead_id)->first();

            $agent = User::where('id', $assignment->user_id)->first();

            $user = User::where('name','GIUSEPPE RAPISARDA')->pluck('name', 'id');
            $users = User::where('agent_code','<>','00000000')->where('agent_code','<>','99999999')->pluck('name', 'id')->union($user);

            return view('assignments.edit', compact('assignment', 'lead', 'agent', 'users'));

        }else {
            return redirect()->route('home')
            ->with('error', 'Non autorizzato.');
        }
    }

    public function update(Request $request, assignment $assignment)
    {
        $user = Auth::user();

        if ($user->agent_code == '00000000') {
            request()->validate([
                'user_id' => 'required',
            ]);

            $assignment = assignment::find($assignment->id);
            $assignment->update($request->all());

            $user = User::find($request->user_id);
            $lead = Lead::find($assignment->lead_id);

            $to_name = $user->name;
            $to_email = $user->email;

            Mail::send('mails.assignment', ["lead" => $lead], function ($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)
                    ->subject('Assegnazione lead');
                $message->from('postmaster@creditodigital.it', 'Avvera');
            });

            return redirect()->route('assignments.index')
                ->with('success', 'assignment updated successfully');
        }else{
            return redirect()->route('home')
            ->with('error', 'Non autorizzato.');
        }
    }

    public function destroy(assignment $assignment)
    {
        $user = Auth::user();

        if ($user->agent_code == '00000000') {
        $assignment->delete();

        return redirect()->route('assignments.index')
            ->with('success', 'assignment deleted successfully');
        }else {
            return redirect()->route('home')
            ->with('error', 'Non autorizzato.');
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Commitment;
use App\Models\Annotation;
use App\Models\Lead;
use Auth;
use DB;
use Illuminate\Support\Facades\Mail;

class CommitmentController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        if ($user->agent_code == '00000000') {
            $commitments = DB::table('commitments')
                ->join('users as dealers', function ($join) {
                    $join->on('commitments.dealer_id', '=', 'dealers.id');
                })
                ->join('users as agents', function ($join) {
                    $join->on('commitments.agent_id', '=', 'agents.id');
                })
                ->where('deleted_at', null)
                ->select('commitments.id', 'agents.name as agent_name', 'dealers.name as dealer_name','dealers.phone','dealers.email', 'commitments.created_at', 'agents.name', 'commitments.current_state',)

                ->get();
        } else {
            $commitments = Commitment::where('agent_id',$user->id)
            ->join('users as dealers', function ($join) {
                $join->on('commitments.dealer_id', '=', 'dealers.id');
            })
            ->where('deleted_at', null)
            ->select('commitments.id', 'dealers.name as dealer_name', 'commitments.created_at','dealers.email', 'commitments.current_state','dealers.phone')
            ->get();
        }

        /*foreach ($commitments as $commitment) {
            $commitment->updated_at = date('d-m-Y - H:i', strtotime($commitment->updated_at));
        }*/

        return view('commitments.index', compact('commitments'));
    }

    public function create()
    {
        $agents = User::where('agent_code','<>','00000000')->where('agent_code','<>','99999999')->pluck('name', 'id');
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
    }

    public function store(Request $request)
    {
        $commitment = Commitment::create([
            'agent_id' => Auth::user()->id,
            'dealer_id' => $request->dealer_id,
            'current_state' => 'creato'
        ]);
        $commitment->save();

        return redirect()->route('dealers.index')
            ->with('success', 'Assegnazione dealer avvenuta con successo.');
    }


    public function show($id)
    {
        $commitment = Commitment::withTrashed()->where('id', $id)->get()->first();
        $dealer_id = $commitment->dealer_id;

        $annotations = Annotation::where('dealer_id',$dealer_id)
            ->join('users', function ($join) {
                $join->on('annotations.user_id', '=', 'users.id');
            })
            ->select('annotations.note','annotations.id','annotations.created_at','users.name', 'users.id as user_id')
            ->get();


        return view('commitments.show', compact('annotations','dealer_id'));

    }

    public function edit(Commitment $commitment)
    {
        $commitment = Commitment::find($commitment->id);

        return view('commitments.edit', compact('commitment'));
    }

    public function update(Request $request, Commitment $commitment)
    {
        request()->validate([
            'current_state' => 'required',
        ]);

        $commitment = Commitment::find($commitment->id);
        $commitment->update($request->all());

        return redirect()->route('commitments.index')
            ->with('success', 'commitment updated successfully');
    }

    public function destroy(Commitment $commitment)
    {
        $commitment->delete();

        return redirect()->route('commitments.index')
            ->with('success', 'commitment deleted successfully');
    }
}

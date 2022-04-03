<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\Instance;
use App\Models\Product;
use App\Models\Lead;
use App\Models\Complead;
use Auth;
use App\Models\User;
use App\Models\Partecipation;
use DB;
use Illuminate\Support\Facades\Mail;

class NoteController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        if ($user->agent_code != '00000000') {
            $instances = DB::table('instances')

                ->join('users', function ($join) {
                    $join->on('users.id', '=', 'instances.user_id')
                        ->where('instances.user_id', '=', Auth::user()->id);
                })

                ->join('products', function ($join) {
                    $join->on('instances.product_id', '=', 'products.id');
                })

                ->join('partecipations', function ($join) {
                    $join->on('partecipations.instance_id', '=', 'instances.id');
                })

                ->join('leads', function ($join) {
                    $join->on('leads.id', '=', 'partecipations.lead_id');
                })
                ->select('instances.id', 'users.name as agent_name', 'users.surname as agent_surname', 'branch', 'products.name as product_name', 'instances.created_at', 'leads.name as lead_name', 'leads.surname as lead_surname')
                ->get();
        } else {
            $instances = DB::table('instances')

                ->join('users', function ($join) {
                    $join->on('users.id', '=', 'instances.user_id');
                })

                ->join('products', function ($join) {
                    $join->on('instances.product_id', '=', 'products.id');
                })

                ->join('partecipations', function ($join) {
                    $join->on('partecipations.instance_id', '=', 'instances.id');
                })

                ->join('leads', function ($join) {
                    $join->on('leads.id', '=', 'partecipations.lead_id');
                })

                ->join('leads', function ($join) {
                    $join->on('leads.lead_id', '=', 'leads.id');
                })

                ->select('instances.id', 'users.name as agent_name', 'users.surname as agent_surname', 'branch', 'products.name as product_name', 'instances.created_at', 'leads.name as lead_name', 'leads.surname as lead_surname')
                ->get();
        }

        return view('instances.index', compact('instances'));
    }

    public function create()
    {
        $products = Product::all()->pluck('name', 'id');

        $user = Auth::user();

        if ($user->agent_code != '00000000') {
            $leads = DB::table('leads')
                ->join('assignments', function ($join) {
                    $join->on('leads.id', '=', 'assignments.lead_id')
                        ->where('assignments.user_id', '=', Auth::user()->id);
                })->select('leads.id', 'name', 'surname', 'email', 'phone', 'channel', 'current_state', 'notes')
                ->get();
        } else {
            $leads = Lead::all();
        }

        return view('instances.create', compact('products', 'user', 'leads'));
    }

    public function store(Request $request)
    {
        request()->validate([
            'notes' => 'required',
            'lead' => 'required',
        ]);

        $user = Auth::user();

        $note = Note::create(['note' => $request->notes, 'user_id' => $user->id, 'lead_id' => $request->lead]);
        $note->save();

        return redirect()->back();
    }

    public function show($id)
    {
        $user = Auth::user();
        $instance = $id;
        $partecipations = DB::table('instances')
            ->where('instances.id', $id)
            ->join('partecipations', function ($join) {
                $join->on('partecipations.instance_id', '=', 'instances.id');
            })
            ->join('leads', function ($join) {
                $join->on('partecipations.lead_id', '=', 'leads.id');
            })
            ->select('leads.name', 'leads.surname')
            ->get();

        $notes = DB::table('notes')
            ->where('instance_id', $id)->join('users', function ($join) {
                $join->on('notes.user_id', '=', 'users.id');
            })->select('users.id as user_id', 'name', 'surname', 'note', 'notes.created_at')->orderBy('notes.created_at', 'asc')
            ->get();

        return view('notes.show', compact('partecipations', 'notes', 'user', 'instance'));
    }

    public function edit(Instance $instance)
    {
        $instance = Instance::find($instance->id);
        return view('instances.edit', compact('instance'));
    }

    public function update(Request $request, Instance $instance)
    {
        request()->validate([
            'agent_id' => 'required',
        ]);

        $instances = Instance::find($instance->id);
        $instances->update($request->all());

        return redirect()->route('instances.index')
            ->with('success', 'instance updated successfully');
    }

    public function destroy(Note $note)
    {
        $note->delete();

        return redirect()->back()
            ->with('success', 'note deleted successfully');
    }
}

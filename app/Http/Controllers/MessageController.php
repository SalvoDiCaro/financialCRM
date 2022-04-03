<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Instance;
use App\Models\Product;
use App\Models\Lead;
use App\Models\Complead;
use Auth;
use App\Models\User;
use App\Models\Partecipation;
use DB;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
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
            'message' => 'required',
        ]);

        $user = Auth::user();

        $message = Message::create(['message' => $request->message, 'user_id' => $user->id, 'instance_id' => $request->instance]);
        $message->save();
        $mail_from = $user->email;
        $name_from = $user->name;
        $instances = Instance::find($request->instance);

        if ($user->agent_code == '00000000') {

            $instances->current_state = "attesa agente";
            $instances->save();

            $user = User::find($instances->user_id);
            $to_name = $user->name;
            $to_email = $user->email;
        } else {
            $instances->current_state = "attesa revisione";
            $instances->save();

            $to_name = "Segreteria";
            $to_email = 'SSTELLA@AVVERAMUTUISICILIA.IT';
        }

        $user_cc = User::find(1);
        $cc_email = $user_cc->email;

        $partecipation = Partecipation::where('instance_id', $request->instance)->get()->first();
        $lead = Lead::withTrashed()->find($partecipation->lead_id);
        $text = $request->message;
        $subject = "Messaggio per pratica di: ".$lead['name']." ".$lead['surname'];

        Mail::send('mails.new_message', ["text" => $text, "lead" => $lead, "subject" => $subject], function ($message) use ($subject, $cc_email, $to_name, $to_email, $mail_from, $name_from) {
            $message
            ->cc([$cc_email])
            ->to($to_email, $to_name)
                ->subject($subject);
            $message->from($mail_from, $name_from);
        });

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

        $messages = DB::table('messages')
            ->where('instance_id', $id)->join('users', function ($join) {
                $join->on('messages.user_id', '=', 'users.id');
            })->select('users.id as user_id', 'name', 'message', 'messages.created_at')->orderBy('messages.created_at', 'asc')
            ->get();

        return view('messages.show', compact('partecipations', 'messages', 'user', 'instance'));
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

    public function destroy(Instance $instance)
    {
        $instance->delete();

        return redirect()->route('instances.index')
            ->with('success', 'instance deleted successfully');
    }
}

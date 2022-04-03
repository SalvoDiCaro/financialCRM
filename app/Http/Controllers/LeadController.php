<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Lead;
use App\Models\Assignment;
use App\Models\Instance;
use App\Models\Company;
use App\Models\Partecipation;
use App\Models\Note;
use App\Models\Debt;
use Illuminate\Support\Facades\Mail;

class LeadController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->agent_code != '00000000') {
            $leads = DB::table('leads')
                ->join('assignments', function ($join) {
                    $join->on('leads.id', '=', 'assignments.lead_id')
                        ->where('assignments.user_id', '=', Auth::user()->id)
                        ->where('leads.deleted_at', NULL);
                })
                ->select('leads.id', 'name', 'surname', 'email', 'phone', 'channel', 'current_state')
                ->get();
        } else {
            $leads = Lead::where('leads.deleted_at', NULL)
                ->join('assignments', function ($join) {
                    $join->on('leads.id', '=', 'assignments.lead_id');
                })
                ->join('users', function ($join) {
                    $join->on('users.id', '=', 'assignments.user_id');
                })
                ->select('leads.id', 'leads.name', 'leads.surname', 'leads.email', 'leads.phone', 'channel', 'current_state', 'users.name as agent', 'assignments.is_direct')
                ->get();
        }

        foreach ($leads as $lead) {

            $lead->date_last_note  =
                Note::where('lead_id', $lead->id)->count() > 0 ? (Note::where('lead_id', $lead->id)->get()->last()->created_at) : null;
        }

        return view('leads.index', compact('leads'));
    }

    public function index_archived()
    {
        $user = Auth::user();

        if ($user->agent_code != '00000000') {
            $leads = DB::table('leads')
                ->join('assignments', function ($join) {
                    $join->on('leads.id', '=', 'assignments.lead_id')
                        ->where('assignments.user_id', '=', Auth::user()->id);
                })
                ->select('leads.id', 'name', 'surname', 'email', 'phone', 'channel', 'current_state')
                ->get();
        } else {
            $leads = DB::table('leads')
                ->select('leads.id', 'leads.name', 'leads.surname', 'leads.email', 'leads.phone', 'channel', 'current_state')
                ->get();
        }

        foreach ($leads as $lead) {

            $lead->date_last_note  =
                Note::where('lead_id', $lead->id)->count() > 0 ? (Note::where('lead_id', $lead->id)->get()->last()->created_at) : null;
        }

        return view('archived_leads.index', compact('leads'));
    }

    public function index_clients()
    {

        $user = Auth::user();
        if ($user->agent_code != '00000000') {

            $partecipations = DB::table('practices')
                ->join('instances', function ($join) {
                    $join->on('practices.instance_id', '=', 'instances.id')
                    ->where('instances.user_id', '=', Auth::user()->id);
                })

                ->join('partecipations', function ($join) {
                    $join->on('partecipations.instance_id', '=', 'instances.id');
                })

                ->join('leads', function ($join) {
                    $join->on('partecipations.lead_id', '=', 'leads.id');
                })

                ->select('practices.id as practice_id', 'practices.practice_number', 'practices.stipulation_date', 'leads.name', 'leads.surname', 'leads.phone', 'leads.email', 'leads.id as lead_id')
                ->get();

        } else {

            $partecipations = DB::table('practices')

                ->join('instances', function ($join) {
                    $join->on('practices.instance_id', '=', 'instances.id');
                })

                ->join('partecipations', function ($join) {
                    $join->on('partecipations.instance_id', '=', 'instances.id');
                })

                ->join('leads', function ($join) {
                    $join->on('partecipations.lead_id', '=', 'leads.id');
                })

                ->select('practices.id as practice_id', 'practices.practice_number', 'practices.stipulation_date', 'leads.name', 'leads.surname', 'leads.phone', 'leads.email', 'leads.id as lead_id')
                ->get();

        }

        foreach ($partecipations as $partecipation) {
            $partecipation->stipulation_date = date('d-m-Y', strtotime($partecipation->stipulation_date));
        }

        return view('clients.index', compact('partecipations'));
    }

    public function create(Request $request)
    {
        $user = Auth::user();

        if ($user->agent_code == '00000000') {
            $agent = User::where('name', 'GIUSEPPE RAPISARDA')->pluck('name', 'id');
            $agents = User::where('agent_code', '<>', '00000000')->where('agent_code', '<>', '99999999')->pluck('name', 'id')->union($agent);
        } else {
            $agents = [];
        }

        //verificare se la richiesta è assegnata all'agente che vuole aggiungerci un partecipante
        $instance = $request->id ? $request->id : null;

        $companies = Company::all()->pluck('name', 'id');

        return view('leads.create', compact('agents', 'instance', 'companies'));
    }

    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        if ($request->instance_id) {

            // se sto creando un lead da aggiungere come partecipante ad una richiesta
            // aggiungo manualmente lo stato e il canale perchè sono noti

            $date = $request->except(['notes', 'typology']);
            $date['channel'] = 'Richiesta_' . $request->instance_id;
            $date['current_state'] = 'IN ATTESA';
            $lead = Lead::create($date);

            $lead->delete();
        } else {

            if ($request->channel == 'Credem') {
                if ($request->branch) {
                    $request->channel = $request->channel . "-" . $request->branch;
                    $lead = Lead::create(array_merge($request->except(['notes', 'typology', 'channel']), ['channel' => $request->channel]));
                } else {
                    $lead = Lead::create($request->except(['notes', 'typology']));
                }
            } else {
                $lead = Lead::create($request->except(['notes', 'typology']));
            }
        }

        $user = Auth::user();

        if ($request->instance_id) {
            $partecipation = Partecipation::create(['instance_id' => $request->instance_id, 'lead_id' => $lead->id, 'typology' => $request->typology]);
            $partecipation->save();
        }

        $assignment = new Assignment;
        $assignment->lead_id = $lead->id;
        if ($request->notes) {
            Note::create(['note' => $request->notes, 'user_id' => Auth::user()->id, 'lead_id' => $lead->id]);
        }

        if (isset($request->flat)) {
            foreach ($request->flat as $key => $value) {
                if ($value || $request->society[$key] || $request->expiration[$key] || $request->residual_debt[$key] || $request->early_termination[$key]) {
                    Debt::create([
                        'lead_id' => $lead->id,
                        'flat' => $value,
                        'society' => $request->society[$key],
                        'expiration' => $request->expiration[$key],
                        'residual_debt' => $request->residual_debt[$key],
                        'early_termination' => $request->early_termination[$key]
                    ]);
                }
            }
        }


        if (!$request->company_id) {
            if ($request->company_name && $request->vat_number) {
                $company = Company::create([
                    'name' => $request->company_name,
                    'vat_number' => $request->vat_number,
                    'address' => $request->company_address,
                    'city' => $request->company_city,
                    'fis_cod' => $request->company_fis_cod,
                    'postal_code' => $request->company_postal_code,
                    'typology' => $request->company_typology,
                    'phone' => $request->company_phone,
                    'email' => $request->company_email,
                ]);
                $lead->update(['company_id' => $company->id]);
            }
        }

        if ($user->agent_code != '00000000') {

            $assignment->user_id = $user->id;
            $assignment->is_direct = true;
            $assignment->save();
            $to_name = $user->name . $user->surname;
            $to_email = $user->email;
        } else {
            if (!$request->random) {

                if (!$request->instance_id) {
                    $assignment->user_id = $request->user_id;
                    $assignment->is_direct = true;
                    $assignment->save();

                    $user = User::find($request->user_id);
                } else {
                    $user_id = Instance::find($request->instance_id)->get()->first()->user_id;
                    $assignment->user_id = $user_id;
                    $assignment->is_direct = true;
                    $assignment->save();

                    $user = User::find($user_id);
                }
                $to_name = $user->name . $user->surname;
                $to_email = $user->email;
            } else {

                $last_assignment = DB::table('assignments')->where('is_direct', false)->latest()->get()->first();

                if ((isset($last_assignment->id))) {
                    foreach (User::all()->whereNotIn('agent_code', '00000000')->whereNotIn('agent_code', '99999999') as $user) {
                        if ($user->assignable && ($user->id > $last_assignment->user_id)) {
                            $assignment->user_id = $user->id;
                            $assignment->is_direct = false;
                            $assignment->save();

                            /*
                            $to_name = $user->name.$user->surname;
                            $to_email = $user->email;

                            Mail::send('mails.assignment', ["lead" => $lead], function ($message) use ($to_name, $to_email) {
                                $message->to($to_email, $to_name)
                                    ->subject('Assegnazione lead');
                                $message->from('postmaster@creditodigital.it', 'Avvera');
                            });
                            */

                            return redirect()->route('leads.index')
                                ->with('success', 'Lead creato con successo.');
                        }
                    }
                }

                $user = User::all()->whereNotIn('agent_code', '00000000')->whereNotIn('agent_code', '99999999')->first();
                $assignment->user_id = $user->id;
                $assignment->is_direct = false;
                $assignment->save();
                $to_name = $user->name . $user->surname;
                $to_email = $user->email;
            }
        }

        /*
            Mail::send('mails.assignment', ["lead" => $lead], function ($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)
                    ->subject('Assegnazione lead');
                $message->from('postmaster@creditodigital.it', 'Avvera');
            });
        */

        if ($request->instance_id) {
            return redirect()->route('instances.index')
                ->with('success', 'Partecipante aggiunto con successo.');
        } else {
            return redirect()->route('leads.index')
                ->with('success', 'Lead creato con successo.');
        }
    }

    public function show($id)
    {
        $user = Auth::user();

        if ($user->agent_code != '00000000') {
            $leads = DB::table('leads')
                ->join('assignments', function ($join) {
                    $join->on('leads.id', '=', 'assignments.lead_id')
                        ->where('assignments.user_id', '=', Auth::user()->id);
                })->select('leads.id')
                ->get()->pluck('id')->toArray();

            $leads2 = DB::table('assignments')
                ->join('leads', function ($join) {
                    $join->on('leads.id', '=', 'assignments.lead_id')
                        ->where('assignments.user_id', '=', Auth::user()->id)
                        ->where('leads.deleted_at', NULL);
                })->select('leads.id')
                ->get()->pluck('id')->toArray();

            if (in_array($id, $leads)) {
                $debts = Debt::where('lead_id', $id)->get();
                $lead = Lead::withTrashed()->where('id', $id)->get()->first();

                $notes = Note::where('lead_id', $id)
                    ->join('leads', function ($join) {
                        $join->on('leads.id', '=', 'notes.lead_id');
                    })
                    ->join('users', function ($join) {
                        $join->on('notes.user_id', '=', 'users.id');
                    })
                    ->select('notes.note', 'notes.id', 'notes.user_id', 'notes.created_at', 'users.name')
                    ->get();


                if ($lead->company_id) {
                    $company = Company::where('id', $lead->company_id)->get()->first()->name;
                } else {
                    $company = "";
                }

                return view('leads.show', compact('lead', 'debts', 'notes', 'company'));
            } else {
                return redirect()->route('home')
                    ->with('error', 'Non sei autorizzato');
            }
        } else {
            $debts = Debt::where('lead_id', $id)->get();
            $lead = Lead::withTrashed()->where('id', $id)->get()->first();

            $notes = Note::where('lead_id', $id)
                ->join('leads', function ($join) {
                    $join->on('leads.id', '=', 'notes.lead_id');
                })
                ->join('users', function ($join) {
                    $join->on('notes.user_id', '=', 'users.id');
                })
                ->select('notes.note', 'notes.id', 'notes.user_id', 'notes.created_at', 'users.name')
                ->get();

            if ($lead->company_id) {
                $company = Company::where('id', $lead->company_id)->get()->first()->name;
            } else {
                $company = "";
            }

            return view('leads.show', compact('lead', 'debts', 'notes', 'company'));
        }
    }

    public function edit($id)
    {
        $user = Auth::user();

        if ($user->agent_code != '00000000') {
            $leads = DB::table('leads')
                ->join('assignments', function ($join) {
                    $join->on('leads.id', '=', 'assignments.lead_id')
                        ->where('assignments.user_id', '=', Auth::user()->id)
                        ->where('leads.deleted_at', NULL);
                })->select('leads.id')
                ->get()->pluck('id')->toArray();

            if (in_array($id, $leads)) {
                $agents = [];

                $debts = Debt::where('lead_id', $id)->get();

                $lead = Lead::withTrashed()->where('id', $id)->get()->first();
            } else {
                return redirect()->route('home')
                    ->with('error', 'Non sei autorizzato');
            }
        } else {

            $agents = User::where('agent_code', '<>', '00000000')->where('agent_code', '<>', '99999999')->pluck('name', 'id');
            $debts = Debt::where('lead_id', $id)->get();

            $lead = Lead::withTrashed()->where('id', $id)->get()->first();
        }

        $companies = Company::all()->pluck('name', 'id');

        return view('leads.edit', compact('lead', 'agents', 'debts', 'companies'));
    }

    public function update(Request $request, Lead $lead)
    {
        request()->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'channel' => 'required',
            'current_state' => 'required',
        ]);

        Debt::where('lead_id', $lead->id)->delete();

        foreach ($request->flat as $key => $value) {
            if ($value || $request->society[$key] || $request->expiration[$key] || $request->residual_debt[$key] || $request->early_termination[$key]) {
                Debt::create([
                    'lead_id' => $lead->id,
                    'flat' => $value,
                    'society' => $request->society[$key],
                    'expiration' => $request->expiration[$key],
                    'residual_debt' => $request->residual_debt[$key],
                    'early_termination' => $request->early_termination[$key]
                ]);
            }
        }

        $lead->update($request->except(['notes']));
        if ($request->notes) {
            Note::create(['note' => $request->notes, 'user_id' => Auth::user()->id, 'lead_id' => $lead->id]);
        }


        return redirect()->route('leads.index')
            ->with('success', 'Lead created successfully');
    }

    public function destroy(Lead $lead)
    {
        $user = Auth::user();

        if ($user->agent_code != '00000000') {
            $leads = DB::table('leads')
                ->join('assignments', function ($join) {
                    $join->on('leads.id', '=', 'assignments.lead_id')
                        ->where('assignments.user_id', '=', Auth::user()->id)
                        ->where('leads.deleted_at', NULL);
                })->select('leads.id')
                ->get()->pluck('id')->toArray();

            if (!in_array($lead->id, $leads)) {

                return redirect()->route('home')
                    ->with('error', 'Non sei autorizzato');
            }
        }

        $lead->delete();
        DB::table('assignments')->where('lead_id', $lead->id)->delete();

        return redirect()->route('leads.index')
            ->with('success', 'Lead deleted successfully');
    }
}

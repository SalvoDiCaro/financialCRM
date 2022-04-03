<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Debt;
use App\Models\Instance;
use App\Models\Product;
use App\Models\Lead;
use App\Models\Message;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use App\Models\Partecipation;
use Illuminate\Support\Facades\DB;
use PDF;

class InstanceController extends Controller
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
                ->where('instances.deleted_at', NULL)
                ->select('instances.id', 'instances.current_state', 'instances.product_type', 'users.name as agent_name', 'branch', 'products.name as product_name', 'instances.created_at')
                ->orderBy('instances.updated_at', 'DESC')
                ->get();

            $partecipations = DB::table('instances')

                ->join('partecipations', function ($join) {
                    $join->on('partecipations.instance_id', '=', 'instances.id');
                })

                ->join('leads', function ($join) {
                    $join->on('leads.id', '=', 'partecipations.lead_id');
                })

                ->select('instances.id as instance_id', 'instances.current_state', 'leads.name', 'leads.surname', 'leads.id as lead_id', 'typology')
                ->get();
        } else {

            $instances = DB::table('instances')
                ->join('users', function ($join) {
                    $join->on('users.id', '=', 'instances.user_id');
                })

                ->join('products', function ($join) {
                    $join->on('instances.product_id', '=', 'products.id');
                })
                ->where('instances.deleted_at', NULL)
                ->select('instances.id', 'instances.current_state', 'instances.product_type',  'users.name as agent_name', 'branch', 'products.name as product_name', 'instances.created_at')
                ->orderBy('instances.updated_at', 'DESC')
                ->get();

            $partecipations = DB::table('instances')

                ->join('partecipations', function ($join) {
                    $join->on('partecipations.instance_id', '=', 'instances.id');
                })

                ->join('leads', function ($join) {
                    $join->on('leads.id', '=', 'partecipations.lead_id');
                })

                ->select('instances.id as instance_id', 'instances.current_state', 'leads.name', 'leads.surname', 'leads.id as lead_id', 'typology')
                ->get();
        }

        foreach ($instances as $instance) {
            $instance->created_at = date('d-m-Y - H:i', strtotime($instance->created_at));
        }

        return view('instances.index', compact('instances', 'partecipations'));
    }

    public function create(Request $request)
    {

        $products = Product::all()->pluck('name', 'id');

        $user = Auth::user();

        if ($user->agent_code != '00000000') {
            $leads = DB::table('leads')
                ->join('assignments', function ($join) {
                    $join->on('leads.id', '=', 'assignments.lead_id')
                        ->where('assignments.user_id', '=', Auth::user()->id);
                })->select('leads.id', 'leads.name', 'leads.surname', 'leads.email')
                ->where('assignments.deleted_at', NULL)
                ->get();

            foreach ($leads as $lead) {
                $lead->agent_name = Auth::user()->name;
            }
        } else {
            $leads = DB::table('leads')
                ->join('assignments', function ($join) {
                    $join->on('leads.id', '=', 'assignments.lead_id');
                })
                ->join('users', function ($join) {
                    $join->on('users.id', '=', 'assignments.user_id');
                })->select('leads.id', 'leads.name', 'leads.surname', 'leads.email', 'users.name as agent_name')
                ->where('assignments.deleted_at', NULL)
                ->get();
        }
        if ($request->id) {
            $lead = Lead::withTrashed()->where('id', $request->id)->get()->first();
            $debts = Debt::where('lead_id', $lead->id)->get();
        } else {
            $lead = "";
            $debts = [];
        }

        $companies = Company::all()->pluck('name', 'id');

        return view('instances.create', compact('products', 'leads', 'lead', 'debts', 'companies'));
    }

    public function store(Request $request)
    {

        request()->validate([
            'product' => 'required',
            'branch' => 'required',
            'name.*' => 'required',
            'surname.*' => 'required',
            'phone.*' => 'required',
            'email.*' => 'required',
        ]);

        $agent = Assignment::where('lead_id', $request->lead)->pluck('user_id')->first();

        $instance = Instance::create([
            'product_id' => $request->product,
            'product_type' => $request->product_type,
            'user_id' => $agent,
            'branch' => $request->branch,
            'current_state' => 'IN ATTESA',
            'finality' => $request->finality,
            'duration' => $request->duration + 60,
            'amount' => $request->amount,
            'rating' => $request->rating,
            'property_cost' => $request->property_cost,
            'property_value' => $request->property_value,
            'spread' => $request->spread,
            'inquest' => $request->inquest,
            'first_erogation' => $request->first_erogation,
            'property_address' => $request->property_address,
            'property_city' => $request->property_city,
            'property_postal_code' => $request->property_postal_code,
            'property_extension_address' => $request->property_extension_address,
            'property_extension_city' => $request->property_extension_city,
            'property_extension_postal_code' => $request->property_extension_postal_code,
            'family_members' => $request->family_members,
            'housing_situation' => $request->housing_situation,
            'consap' => $request->consap,

        ]);
        $instance->save();

        Lead::where('id', $request->lead)->update([
            'current_state' => 'IN ATTESA',
            'fis_cod' => $request->fis_cod ,
            'date_of_birth' => $request->date_of_birth ,
            'birth_place' => $request->birth_place ,
            'postal_code' => $request->postal_code ,
            'city_of_residence' => $request->city_of_residence ,
            'address' => $request->address ,
            'marital_status' => $request->marital_status ,
            'job' => $request->job,
            'contract_type' => $request->contract_type,
            'sector' => $request->sector,
            'work_since' => $request->work_since,
            'company_id' => $request->company_id,
            'annual_income' => $request->annual_income,
            'work_notes' => $request->work_notes,
            'loan_notes' => $request->loan_notes ,
        ]);
        $lead = Lead::where('id', $request->lead)->get()->first();

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

        Assignment::where('lead_id', $request->lead)->delete();
        Debt::where('lead_id', $request->lead)->forceDelete();

            $count = 0;
            foreach ($request->flat as $flat) {

                if ($request->flat[$count] || $request->society[$count] || $request->expiration[$count] || $request->residual_debt[$count] || $request->early_termination[$count]) {
                    Debt::create([
                        'lead_id' => $lead->id,
                        'flat' => $request->flat[$count],
                        'society' => $request->society[$count],
                        'expiration' => $request->expiration[$count],
                        'residual_debt' => $request->residual_debt[$count],
                        'early_termination' => $request->early_termination[$count]
                    ]);
                }
                $count++;
            }

        $partecipation = Partecipation::create(['instance_id' => $instance->id, 'lead_id' => $lead->id, 'typology' => "Richiedente" ]);
        $partecipation->save();

        $lead->delete();

        if ($request->seller_name && $request->seller_surname && $request->seller_email && $request->seller_phone){
            $seller = Lead::create([
                'name' => $request->seller_name,
                'surname' => $request->seller_surname,
                'email' => $request->seller_email,
                'phone' => $request->seller_phone,
                'channel' => 'VENDITORE',
                'current_state' => 'DA CONTATTARE',
            ]);
            $seller->delete();
        }
        return redirect()->route('instances.index')
            ->with('success', 'instance created successfully.');
    }

    public function show($id)
    {
        $instance = Instance::find($id);

        $messages = Message::where('instance_id', $id);

        $product = Product::find($instance->product_id);

        $partecipations = DB::table('instances')

        ->join('partecipations', function ($join) {
            $join->on('partecipations.instance_id', '=', 'instances.id');
        })

        ->join('leads', function ($join) {
            $join->on('leads.id', '=', 'partecipations.lead_id');
        })
        ->select('instances.id as instance_id', 'instances.current_state', 'leads.name', 'leads.surname', 'partecipations.typology','leads.phone', 'leads.channel', 'leads.id as lead_id', 'typology')
        ->where('instance_id', $id)
        ->get();

        $channel = $partecipations->first()->channel;

        $data = [
            'title' => 'Riepilogo richiesta',
            'partecipations' => $partecipations,
            'instance' => $instance,
            'messages' => $messages,
            'product' => $product,
            'channel' => $channel,
        ];

        $pdf = PDF::loadView('pdf', $data);

        return $pdf->download('richiesta.pdf');

        //return view('instances.show', compact('instance', 'messages', 'partecipations'));
    }

    public function edit(Instance $instance)
    {
        $agents = User::where('agent_code', '<>', '00000000')->where('agent_code', '<>', '99999999')->pluck('name', 'id');
        $products = Product::all()->pluck('name', 'id');

        $partecipations = Partecipation::where('partecipations.instance_id', $instance->id)

            ->join('leads', function ($join) {
                $join->on('leads.id', '=', 'partecipations.lead_id');
            })

            ->select('partecipations.id', 'partecipations.typology', 'leads.id as lead_id', 'leads.name', 'leads.surname')
            ->get();

        //$instance->current_state = Lead::withTrashed()->find($partecipations->first()->lead_id)->current_state;

        return view('instances.edit', compact('instance', 'agents', 'products', 'partecipations'));
    }

    public function update(Request $request, Instance $instance)
    {
        request()->validate([
            'user_id' => 'required',
            'branch' => 'required',
        ]);

        $instance->update($request->all());

        $partecipations = Partecipation::where('partecipations.instance_id', $instance->id);

        //Lead::withTrashed()->find($partecipations->first()->lead_id)->update(['current_state' => $request->current_state]);

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

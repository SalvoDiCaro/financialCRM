<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instance;
use App\Models\Practice;
use App\Models\Product;
use App\Models\Lead;
use App\Models\Complead;
use App\Models\User;
use Auth;
use App\Models\Partecipation;
use DB;

class PracticeController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        if ($user->agent_code != '00000000') {
            $practices = DB::table('practices')
                ->join('instances', function ($join) {
                    $join->on('practices.instance_id', '=', 'instances.id');
                })

                ->join('users', function ($join) {
                    $join->on('users.id', '=', 'instances.user_id')
                        ->where('instances.user_id', '=', Auth::user()->id);
                })

                ->join('products', function ($join) {
                    $join->on('instances.product_id', '=', 'products.id');
                })
                ->where('practices.deleted_at', NULL)
                ->select('practices.id', 'practices.practice_number', 'users.name as agent_name', 'amount', 'products.name as product_name', 'inquest', 'stipulation_date')
                ->get();

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

                ->select('practices.id as practice_id', 'leads.name', 'leads.surname', 'leads.id as lead_id', 'typology')
                ->get();
        } else {

            $practices = DB::table('practices')

                ->join('instances', function ($join) {
                    $join->on('practices.instance_id', '=', 'instances.id');
                })

                ->join('users', function ($join) {
                    $join->on('users.id', '=', 'instances.user_id');
                })

                ->join('products', function ($join) {
                    $join->on('instances.product_id', '=', 'products.id');
                })
                ->where('practices.deleted_at', NULL)
                ->select('practices.id', 'practices.practice_number', 'users.name as agent_name', 'amount', 'products.name as product_name', 'inquest', 'stipulation_date')
                ->get();

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

                ->select('practices.id as practice_id', 'leads.id as lead_id', 'leads.name', 'leads.surname', 'typology')
                ->get();
        }

        foreach ($practices as $practice) {
            $practice->stipulation_date = date('d-m-Y', strtotime($practice->stipulation_date));
        }

        return view('practices.index', compact('practices', 'partecipations'));
    }

    public function create(Request $request)
    {

        if (Auth::user()->agent_code == '00000000') {

            $products = Product::all()->pluck('name', 'id');

            $instances = DB::table('instances')
                ->where('instances.deleted_at', NULL)
                ->select('instances.id', 'instances.product_id', 'instances.branch', 'instances.created_at')
                ->get();

            if ($request->id) {
                $instance = Instance::where('id', $request->id)->get()->first();
                $instance->property_cost = (float)(substr(preg_replace("/[^\d]/", "", $instance->property_cost), 0, -2) . "," . substr(preg_replace("/[^\d]/", "", $instance->property_cost), -2));
                $instance->amount = (float)(substr(preg_replace("/[^\d]/", "", $instance->amount), 0, -2) . "," . substr(preg_replace("/[^\d]/", "", $instance->amount), -2));
            } else {
                $instance = "";
            }

            foreach ($instances as $value) {
                $partecipations = Partecipation::where('partecipations.instance_id', $value->id);
                $lead = Lead::withTrashed()->find($partecipations->first()->lead_id);
                $value->lead_name = $lead->name;
                $value->lead_surname = $lead->surname;
            }

            $dealers =
                User::where('agent_code', '99999999')
                ->pluck('name','id');

            return view('practices.create', compact('instances', 'instance', 'dealers'));
        } else {
            return redirect()->route('home')
                ->with('error', 'Non sei autorizzato');
        }
    }

    public function store(Request $request)
    {

        if (Auth::user()->agent_code == '00000000') {

            request()->validate([
                'practice_number' => 'required',
                'amount' => 'required',
                'finality' => 'required',
                'duration' => 'required',
                'fire' => 'required',
                'complete_fire' => 'required',
                'ppl' => 'required',
                'life' => 'required',
                'spread_band' => 'required',
                'spread' => 'required',
                'cpi_number' => 'required',
                'inquest' => 'required',
                'rating' => 'required',
                'ltv_band' => 'required',
                'paper_digital' => 'required',
                'stipulation_date' => 'required',
                'instance' => 'required',
                'notary' => 'required'
            ]);

            $instance = Instance::find($request->instance);
            $instance->update([
                'amount' => $request->amount,
                'finality' => $request->finality,
                'duration' => $request->duration,
                'spread' => $request->spread,
                'inquest' => $request->inquest,
                'rating' => $request->rating,
                'current_state' => "Completata",
                'property_value' => $request->property_value,
                'property_cost' => $request->property_cost,
            ]);
            $practice = Practice::create([
                'instance_id' => $request->instance,
                'practice_number' => $request->practice_number,
                'cpi_awards' => $request->cpi_awards,
                'ltv_fin' => $request->ltv_fin,
                'fire' => $request->fire,
                'complete_fire' => $request->complete_fire,
                'injuries' => $request->injuries,
                'ppl' => $request->ppl,
                'life' => $request->life,
                'spread_band' => $request->spread_band,
                'cpi_number' => $request->cpi_number,
                'ltv_bank' => $request->ltv_bank,
                'fire_amount' => $request->fire_amount,
                'complete_fire_amount' => $request->complete_fire_amount,
                'injuries_amount' => $request->injuries_amount,
                'ppl_amount' => $request->ppl_amount,
                'life_amount' => $request->life_amount,
                'ltv_band' => $request->ltv_band,
                'paper_digital' => $request->paper_digital,
                'stipulation_date' => $request->stipulation_date,
                'notary' => $request->notary,
                'dealer_id' => $request->dealer_id,
            ]);
            $practice->save();

            $instance->delete();

            $leads = DB::table('practices')

                ->join('instances', function ($join) {
                    $join->on('practices.instance_id', '=', 'instances.id');
                })

                ->join('partecipations', function ($join) {
                    $join->on('partecipations.instance_id', '=', 'instances.id');
                })

                ->join('leads', function ($join) {
                    $join->on('partecipations.lead_id', '=', 'leads.id');
                })

                ->select('leads.id')
                ->get();

            foreach ($leads as $lead) {
                $lead = Lead::withTrashed()->find($lead->id);
                $lead->current_state = "completato";
                $lead->save();
            }

            return redirect()->route('practices.index')
                ->with('success', 'practice created successfully.');
        } else {
            return redirect()->route('home')
                ->with('error', 'Non sei autorizzato');
        }
    }

    public function show($id)
    {
        $practice = Practice::find($id);

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

            ->where('practices.id', $id)

            ->select('practices.id as practice_id', 'leads.name', 'leads.surname', 'typology')
            ->get();
        $instance = Instance::withTrashed()->find($practice->instance_id);

        return view('practices.show', compact('practice', 'partecipations', 'instance'));
    }

    public function edit(Practice $practice)
    {
        if (Auth::user()->agent_code == '00000000') {

            $practice = Practice::find($practice->id);
            $instance = Instance::withTrashed()->find($practice->instance_id);
            $product = Product::find($instance->product_id);
            $agent = User::find($instance->user_id);
            $agents = User::where('agent_code', '<>', '00000000')->where('agent_code', '<>', '99999999')->pluck('name', 'id');
            $products = Product::all()->pluck('name', 'id');
            $partecipations = Partecipation::where('partecipations.instance_id', $instance->id)

                ->join('leads', function ($join) {
                    $join->on('partecipations.lead_id', '=', 'leads.id');
                })

                ->select('partecipations.id', 'leads.name', 'leads.surname')
                ->get();

            /*foreach ($partecipations as $partecipation) {
            $partecipation['name'] = $partecipation['lead_name'] . " " . $partecipation['lead_surname'];
            unset($partecipation['lead_name']);
            unset($partecipation['lead_surname']);
        }*/

            return view('practices.edit', compact('practice', 'instance', 'product', 'agent', 'agents', 'products', 'partecipations'));
        } else {
            return redirect()->route('home')
                ->with('error', 'Non sei autorizzato');
        }
    }

    public function update(Request $request, Practice $practice)
    {
        if (Auth::user()->agent_code == '00000000') {
            request()->validate([
                'practice_number' => 'required',
                'amount' => 'required',
                'finality' => 'required',
                'duration' => 'required',
                'fire' => 'required',
                'complete_fire' => 'required',
                'injuries' => 'required',
                'ppl' => 'required',
                'life' => 'required',
                'spread_band' => 'required',
                'spread' => 'required',
                'cpi_number' => 'required',
                'inquest' => 'required',
                'rating' => 'required',
                'ltv_band' => 'required',
                'paper_digital' => 'required',
                'stipulation_date' => 'required',
            ]);

            $instance = Instance::withTrashed()->find($practice->instance_id);
            $instance->update([
                'property_cost' => $request->property_cost,
                'property_value' => $request->property_value,
                'amount' => $request->amount,
                'finality' => $request->finality,
                'duration' => $request->duration,
                'spread' => $request->spread,
                'inquest' => $request->inquest,
                'rating' => $request->rating,
            ]);

            $practices = Practice::find($practice->id);
            $practices->update([
                'practice_number' => $request->practice_number,
                'fire' => $request->fire,
                'complete_fire' => $request->complete_fire,
                'injuries' => $request->injuries,
                'ppl' => $request->ppl,
                'life' => $request->life,
                'spread_band' => $request->spread_band,
                'cpi_number' => $request->cpi_number,
                'ltv_band' => $request->ltv_band,
                'paper_digital' => $request->paper_digital,
                'stipulation_date' => $request->stipulation_date,
            ]);

            return redirect()->route('practices.index')
                ->with('success', 'practice updated successfully');
        } else {
            return redirect()->route('home')
                ->with('error', 'Non sei autorizzato');
        }
    }

    public function destroy(Practice $practice)
    {
        if (Auth::user()->agent_code == '00000000') {
            $practice->delete();

            return redirect()->route('practices.index')
                ->with('success', 'practice deleted successfully');
        } else {
            return redirect()->route('home')
                ->with('error', 'Non sei autorizzato');
        }
    }
}

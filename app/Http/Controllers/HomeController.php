<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Lead;
use App\Models\Instance;
use App\Models\Practice;
use App\Models\Commitment;
use App\Models\User;
use App\Models\Note;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $period = $request->period ? $request->period : 'Anno in corso';

        $state = $request->state ? $request->state : 'Pratiche';

        $agent = $request->agent ? $request->agent : 'Tutti';

        if ($period == 'Anno in corso') {
            $filter = 'year';
            $year = Carbon::now()->year;
        } elseif ($period == 'Anno precedente') {
            $filter = 'year';
            $year = (Carbon::now()->year) - 1;
        } else {
            $filter = 'month';
            $year = Carbon::now()->year;
            $month = $period;
        }

        if ($user->agent_code != '00000000') {

            $agents = [];

            $leads = DB::table('leads')
                ->join('assignments', function ($join) {
                    $join->on('leads.id', '=', 'assignments.lead_id')
                        ->where('assignments.user_id', '=', Auth::user()->id)
                        ->where('leads.deleted_at', NULL);
                })->select('leads.id', 'name', 'surname', 'email', 'phone', 'channel', 'current_state', 'leads.created_at')
                ->get();

            foreach ($leads as $lead) {
                $lead->created_at = Carbon::parse($lead->created_at);
                isset($lead->updated_at) ? Carbon::parse($lead->updated_at) : '-';
                $lead->date_last_note  =
                Note::where('lead_id', $lead->id)->count() > 0 ? (Note::where('lead_id', $lead->id)->get()->last()->created_at) : null;
            }

            $weekly_leads = DB::table('leads')
                ->join('assignments', function ($join) {
                    $join->on('leads.id', '=', 'assignments.lead_id')
                        ->where('assignments.user_id', '=', Auth::user()->id);
                })
                ->where('leads.created_at', '>', Carbon::now()->subMinutes(10080))
                ->get()->count();

            $previous_weekly_leads = DB::table('leads')
                ->join('assignments', function ($join) {
                    $join->on('leads.id', '=', 'assignments.lead_id')
                        ->where('assignments.user_id', '=', Auth::user()->id);
                })
                ->where([
                    ['leads.created_at', '<', Carbon::now()->subMinutes(10080)],
                    ['leads.created_at', '>', Carbon::now()->subMinutes(20160)],
                ])->get()->count();

            $weekly_instances = Instance::where('created_at', '>', Carbon::now()->subMinutes(10080))
                ->where('user_id', Auth::user()->id)
                ->get()->count();

            $instances_to_work = Instance::where('current_state', "attesa agente")
                ->where('user_id', Auth::user()->id)
                ->get()->count();
        } else {

            $agent_to_add = User::where('name','GIUSEPPE RAPISARDA')->pluck('name', 'id');
            $agents = User::where('agent_code','<>','00000000')->where('agent_code','<>','99999999')->pluck('name', 'id')->union($agent_to_add);

            $leads = Lead::all()->where('deleted_at', NULL);

            foreach ($leads as $lead) {
                $lead->date_last_note  =
                Note::where('lead_id', $lead->id)->count() > 0 ? (Note::where('lead_id', $lead->id)->get()->last()->created_at) : null;
            }

            $weekly_leads = Lead::where('created_at', '>', Carbon::now()->subMinutes(10080))->get()->count();
            $previous_weekly_leads = Lead::where([
                ['created_at', '<', Carbon::now()->subMinutes(10080)],
                ['created_at', '>', Carbon::now()->subMinutes(20160)],
            ])->get()->count();
            $weekly_instances = Instance::where('created_at', '>', Carbon::now()->subMinutes(10080))->get()->count();
            $weekly_practices = Practice::where('created_at', '>', Carbon::now()->subMinutes(10080))->get()->count();
            $instances_to_work = Instance::where('current_state', "attesa revisione")->get()->count();
        }

        $dealers =
            User::whereNotIn('id', (DB::table('users')
                ->join('commitments', function ($join) {
                    $join->on('users.id', '=', 'commitments.dealer_id');
                })
                ->where('commitments.deleted_at', null)
                ->pluck('users.id')))->where('agent_code', '99999999')
                ->where('assignable', 1)
            ->get();

        $dealers_available = $dealers->count();

        if ($user->agent_code == '00000000') {
            $dealers_assigned = DB::table('commitments')
                ->join('users as dealers', function ($join) {
                    $join->on('commitments.dealer_id', '=', 'dealers.id');
                })
                ->join('users as agents', function ($join) {
                    $join->on('commitments.agent_id', '=', 'agents.id');
                })
                ->where('deleted_at', null)
                ->get()->count();
        } else {
            $dealers_assigned = Commitment::where('agent_id', $user->id)
                ->join('users as dealers', function ($join) {
                    $join->on('commitments.dealer_id', '=', 'dealers.id');
                })
                ->where('deleted_at', null)
                ->select('commitments.id', 'dealers.name as dealer_name', 'commitments.created_at', 'dealers.email', 'commitments.current_state', 'dealers.phone')
                ->get()->count();
        }

        if ($filter == 'year') {
            if ($user->agent_code != '00000000') {
                $practices = Practice::where('practices.deleted_at',null)->whereYear('practices.created_at', '=', $year)
                    ->join('instances', function ($join) {
                        $join->on('instances.id', '=', 'practices.instance_id')
                            ->where('instances.user_id', '=', Auth::user()->id);
                    });
            } else {
                if($agent == 'Tutti'){
                    $practices = Practice::where('practices.deleted_at',null)->whereYear('practices.created_at', '=', $year)
                    ->join('instances', function ($join) {
                        $join->on('instances.id', '=', 'practices.instance_id');
                    });
                }else{
                    $practices = Practice::where('practices.deleted_at',null)->whereYear('practices.created_at', '=', $year)
                    ->join('instances', function ($join) use($agent) {
                        $join->on('instances.id', '=', 'practices.instance_id')
                        ->where('instances.user_id', '=', $agent);
                    });
                }

            }
        } elseif ($filter == 'month') {
            if ($user->agent_code != '00000000') {
                $practices = Practice::where('practices.deleted_at',null)->whereYear('practices.created_at', '=', $year)->whereMonth('practices.created_at', '=', $month-1)
                    ->join('instances', function ($join) {
                        $join->on('instances.id', '=', 'practices.instance_id')
                            ->where('instances.user_id', '=', Auth::user()->id);
                    });
            } else {
                if($agent == 'Tutti'){
                    $practices = Practice::where('practices.deleted_at',null)->whereYear('practices.created_at', '=', $year)->whereMonth('practices.created_at', '=', $month-1)
                    ->join('instances', function ($join) {
                        $join->on('instances.id', '=', 'practices.instance_id');
                    });
                }else{
                    $practices = Practice::where('practices.deleted_at',null)->whereYear('practices.created_at', '=', $year)->whereMonth('practices.created_at', '=', $month-1)
                    ->join('instances', function ($join) use($agent) {
                        $join->on('instances.id', '=', 'practices.instance_id')
                        ->where('instances.user_id', '=', $agent);
                    });
                }

            }
        }

        $annual_amount = $practices
            ->sum('instances.amount');

        $annual_practices = $practices
            ->get()->count();

        $avg_mutual = $practices
            ->avg('instances.duration') ? round($practices
            ->avg('instances.duration'),2) : 0;

        $digital_count = $practices->where('paper_digital', 'Digitale')
            ->get()->count();

        $percent_digital = $annual_practices ? round(($digital_count / $annual_practices * 100),2) : 0;

        $avg_amount = round($practices
            ->avg('instances.amount'),2);

        $avg_inquest = round($practices
            ->avg('instances.inquest'),2);

        $avg_ltv = round($practices
            ->avg('instances.property_value'),2);

        $avg_ltv_fin = round($practices
            ->avg('instances.property_cost'),2);

        $annual_cpi_number = $practices->sum('practices.cpi_number');

        $annual_cpi_amount = $practices->sum('practices.cpi_awards');

        $avg_cpi = round($practices->avg('practices.cpi_awards'),2);

        $months_list = ['Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno','Luglio','Agosto','Settembre','Ottobre','Novembre','dicembre'];

        $periods = ['Anno in corso' =>'Anno in corso','Anno precedente' => 'Anno precedente'];

        for($i=1; $i<=Carbon::now()->month; $i++){
            $periods[$i] = $months_list[$i-1]." ".Carbon::now()->year;
        }

        $life_number = $practices->sum('practices.life');
        $fire_number = $practices->sum('practices.fire');
        $complete_fire_number = $practices->sum('practices.complete_fire');
        $injuries_number = $practices->sum('practices.injuries');
        $ppl_number = $practices->sum('practices.ppl');

        $avg_policies = $annual_practices ? round(($life_number + $fire_number + $complete_fire_number + $injuries_number + $ppl_number + $annual_cpi_number)/$annual_practices,2) : 0;

        return view('home', compact('agent','agents','state', 'avg_policies', 'periods','dealers_available', 'period', 'avg_cpi', 'annual_cpi_number', 'annual_cpi_amount', 'avg_ltv_fin', 'avg_ltv', 'avg_inquest', 'avg_amount', 'percent_digital', 'avg_mutual', 'annual_practices', 'annual_amount', 'dealers_assigned', 'dealers', 'leads', 'weekly_leads', 'previous_weekly_leads', 'weekly_instances', 'instances_to_work'));
    }

    public function calendar()
    {
        return view('calendar');
    }

    public function welcome()
    {
        $user = Auth::user();

        if ($user) {

            if ($user->agent_code != '00000000') {
                $leads = DB::table('leads')
                    ->join('assignments', function ($join) {
                        $join->on('leads.id', '=', 'assignments.lead_id')
                            ->where('assignments.user_id', '=', Auth::user()->id)
                            ->where('leads.deleted_at', NULL);
                    })->select('leads.id', 'name', 'surname', 'email', 'phone', 'channel', 'current_state', 'leads.created_at')
                    ->get();

                foreach ($leads as $lead) {
                    $lead->created_at = Carbon::parse($lead->created_at);
                }

                $weekly_leads = DB::table('leads')
                    ->join('assignments', function ($join) {
                        $join->on('leads.id', '=', 'assignments.lead_id')
                            ->where('assignments.user_id', '=', Auth::user()->id);
                    })
                    ->where('leads.created_at', '>', Carbon::now()->subMinutes(10080))
                    ->get()->count();

                $weekly_instances = Instance::where('created_at', '>', Carbon::now()->subMinutes(10080))
                    ->where('user_id', Auth::user()->id)
                    ->get()->count();

                $weekly_practices = Practice::where('created_at', '>', Carbon::now()->subMinutes(10080))
                    ->where('user_id', Auth::user()->id)
                    ->get()->count();

                $instances_to_work = Instance::where('current_state', "attesa agente")
                    ->where('user_id', Auth::user()->id)
                    ->get()->count();
            } else {
                $leads = Lead::all()->where('deleted_at', NULL);
                $weekly_leads = Lead::withTrashed()->where('created_at', '>', Carbon::now()->subMinutes(10080))->get()->count();
                $weekly_instances = Instance::where('created_at', '>', Carbon::now()->subMinutes(10080))->get()->count();
                $weekly_practices = Practice::where('created_at', '>', Carbon::now()->subMinutes(10080))->get()->count();
                $instances_to_work = Instance::where('current_state', "attesa revisione")->get()->count();
            }

            $agents_number = User::all()->count() - 1;

            return view('home', compact('leads', 'weekly_leads', 'weekly_instances', 'agents_number', 'weekly_practices', 'instances_to_work'));
        } else {
            return view('auth.login');
        }
    }
}

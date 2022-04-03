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

class ModuleController extends Controller
{

    public function create(Request $request)
    {

        $product = "mutuo";

        return view('modules.create', compact('product'));
    }

    public function download(Request $request)
    {

        $id = 2;
        $instance = Instance::find($id);

        $messages = Message::where('instance_id', $id);

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

        $data = [
            'title' => 'Riepilogo richiesta',
            'partecipations' => $partecipations,
            'instance' => $instance,
            'messages' => $messages,
            'product' => $request->product,
            'channel' => 'pdf',
        ];

        $pdf = PDF::loadView('pdf-modulo', $data);

        return $pdf->download('richiesta.pdf');

        //return view('instances.show', compact('instance', 'messages', 'partecipations'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prenotation;
use App\Models\Spot;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Support\Facades\Mail;


class PrenotationController extends Controller
{

    public function index(Request $request)
    {
        $hours = ['08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
        '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00',
        '16:30', '17:00', '17:30', '18:00'];

        $prenotations = Prenotation::where('spot_id', $request->id)
        ->join('users', function ($join) {
            $join->on('users.id', '=', 'prenotations.user_id');
        })
        //->where('prenotations.deleted_at', null)
        ->select('prenotations.id', 'users.name', 'prenotations.date_from', 'prenotations.spot_id', 'prenotations.user_id')
        ->get();

        $room = Spot::where('id', $request->id)->get()->first();

        $days = [];

        // date( "Y-m-d", strtotime( "2009-01-31 +1 month" )

        for($i = 0; $i < 14; $i++){
            if(date('w', strtotime("+$i day")) != 0 && date('w', strtotime("+$i day")) != 6){
                $days[] = strtotime("+$i day");
            }
        }

        return view('prenotations.index', compact('prenotations', 'days', 'room', 'hours'));
    }

    public function create(Request $request)
    {


        return view('prenotations.create', compact('products', 'leads', 'lead', 'debts', 'companies'));
    }

    public function store(Request $request)
    {
        $prenotation = Prenotation::create([
            'user_id' => Auth::user()->id,
            'date_from' => date("Y-m-d", $request->day)." ".$request->hour,
            'spot_id' => $request->spot_id
        ]);
        $prenotation->save();

        $user_cc = User::find(1);
        $cc_email = $user_cc->email;

        $user_to = Auth::user();
        $to_name = $user_to->name." ".$user_to->surname;
        $to_email = $user_to->email;
        //$to_email = "salvatoredicaro93@gmail.com";

        $mail_from = 'backoffice@avverafinanziamenti.it';
        $name_from = "Segreteria";

        $room = Spot::where('id', $request->spot_id)->get()->first();

        $text="Prenotazione della postazione per la stanza ".$room->name." in data ".date("d/m/Y", $request->day)." alle ore ".$request->hour." effettuata con successo da ".$to_name;

        Mail::send('mails.new_prenotation', ["text" => $text], function ($message) use ($cc_email, $to_name, $to_email, $mail_from, $name_from) {
            $message
            ->cc([$cc_email])
            ->to($to_email, $to_name)
                ->subject('Prenotazione confermata');
            $message->from($mail_from, $name_from);
        });

        return redirect()->route('prenotations.index', [ 'id' => $request->spot_id ])
            ->with('success', 'prenotation created successfully.');
    }

    public function show($id)
    {


        return view('prenotations.show', compact('prenotation', 'messages', 'partecipations'));
    }

    public function edit(Prenotation $prenotation)
    {


        return view('prenotations.edit', compact('prenotation', 'agents', 'products', 'partecipations'));
    }

    public function update(Request $request, Prenotation $prenotation)
    {

        return redirect()->route('prenotations.index')
            ->with('success', 'prenotation updated successfully');
    }

    public function destroy($id)
    {

        $prenotation = Prenotation::find($id);
        $spot = $prenotation->spot_id;
        $prenotation->delete();

        return redirect()->route('prenotations.index', [ 'id' => $spot ])
            ->with('success', 'prenotation deleted successfully');
    }
}

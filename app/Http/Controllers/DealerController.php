<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Commitment;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use DB;
use Auth;
use Hash;

class DealerController extends Controller
{
    public function index()
    {
        if (Auth::user()->agent_code == '00000000') {
            $dealers =
                User::whereNotIn('id',(
                    DB::table('users')
                ->join('commitments', function ($join) {
                    $join->on('users.id', '=', 'commitments.dealer_id');
                })
                ->where('commitments.deleted_at', null)
                ->pluck('users.id')))->where('agent_code','99999999')
                ->get();
        }else{
            $dealers =
                User::where('assignable', true)->whereNotIn('id',(
                    DB::table('users')
                ->join('commitments', function ($join) {
                    $join->on('users.id', '=', 'commitments.dealer_id');
                })
                ->where('commitments.deleted_at', null)
                ->where('users.assignable', true)
                ->pluck('users.id')))->where('agent_code','99999999')
                ->get();
        }

        return view('dealers.index', compact('dealers'));

    }

    public function create()
    {
        if (Auth::user()->agent_code == '00000000') {
            return view('dealers.create');
        }else{
            return redirect()->route('dealers.index')
            ->with('error', 'Non sei autorizzato');
        }
    }

    public function store(Request $request)
    {
        if (Auth::user()->agent_code == '00000000') {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'same:confirm-password',
            ]);

            $input = $request->all();

            //Hash Password
            $input['password'] = Hash::make($input['password']);

            if(isset($request->assignable)){
                $input['assignable'] = true;
            }else{
                $input['assignable'] = false;
            }

            $user = User::create($input);

            if($input['assignable']){

                $dealer = $user;

                $agents = User::where('agent_code','<>','00000000')->where('agent_code','<>','99999999')->get();

                foreach($agents as $agent){

                    $to_name = $agent->name;
                    $to_email = $agent->email;

                    Mail::send('mails.dealers', ["dealer" => $dealer], function ($message) use ($to_name, $to_email) {
                        $message->to($to_email, $to_name)
                            ->subject('Nuovo dealer');
                        $message->from('postmaster@creditodigital.it', 'Avvera');
                    });
                }
            }

            return redirect()->route('dealers.index')
            ->with('success', 'User created successfully');
        }else{
            return redirect()->route('dealers.index')
            ->with('error', 'Non sei autorizzato');
        }

    }

    public function show($id)
    {
        if (Auth::user()->agent_code == '00000000') {

            $user = User::find($id);
            return view('dealers.show', compact('user'));

        }else{
            return redirect()->route('dealers.index')
            ->with('error', 'Non sei autorizzato');
        }

    }


    public function edit($id)
    {
        if (Auth::user()->agent_code == '00000000') {

            $user = User::find($id);
            return view('dealers.edit', compact('user'));

        }else{
            return redirect()->route('dealers.index')
            ->with('error', 'Non sei autorizzato');
        }

    }


    public function update(Request $request, $id)
    {
        if (Auth::user()->agent_code == '00000000') {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $id,
            ]);

            $input = $request->all();
            if (!empty($input['password'])) {
                $input['password'] = Hash::make($input['password']);
            } else {
                $input = array_except($input, array('password'));
            }

            $user = User::find($id);

            $old_assignable = $user->assignable;
            $user->update($input);

            if(!$old_assignable && $input['assignable']){

                $dealer = $user;

                $agents = User::where('agent_code','<>','00000000')->where('agent_code','<>','99999999')->get();

                foreach($agents as $agent){

                    $to_name = $agent->name;
                    $to_email = $agent->email;

                    Mail::send('mails.dealers', ["dealer" => $dealer], function ($message) use ($to_name, $to_email) {
                        $message->to($to_email, $to_name)
                            ->subject('Nuovo dealer');
                        $message->from('postmaster@creditodigital.it', 'Avvera');
                    });
                }
            }

            return redirect()->route('dealers.index')
            ->with('success', 'Dealer aggiornato correttamente');

        } else {
            return redirect()->route('dealers.index')
            ->with('error', 'Non sei autorizzato');
        }

    }


    public function destroy($id)
    {
        if (Auth::user()->agent_code == '00000000') {

            $user = User::find($id);
            $user->delete();
            return redirect()->route('dealers.index')
            ->with('success', 'Utente eliminato correttamente');

        }else{
            return redirect()->route('dealers.index')
            ->with('error', 'Non sei autorizzato');
        }
    }
}

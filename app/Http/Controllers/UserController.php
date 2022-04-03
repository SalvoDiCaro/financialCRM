<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use DB;
use Auth;
use Hash;

class UserController extends Controller
{
    public function index()
    {
        if (Auth::user()->agent_code == '00000000') {
            $users = User::all();

            return view('users.index', compact('users'));
        }else{
            return redirect()->route('home')
            ->with('error', 'Non sei autorizzato');
        }
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->agent_code == '00000000') {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'same:confirm-password',
                'agent_code' => 'required',
            ]);

            $input = $request->all();

            //Hash Password
            $input['password'] = Hash::make($input['password']);

            if(isset($request->assignable)){
                $input['assignable'] = true;
            }else{
                $input['assignable'] = false;
            }

            User::create($input);

            return redirect()->route('users.index')
            ->with('success', 'User created successfully');

        }else{
            return redirect()->route('home')
            ->with('error', 'Non sei autorizzato');
        }


    }

    public function show($id)
    {
        if (Auth::user()->agent_code == '00000000') {
            $user = User::find($id);

            return view('users.show', compact('user'));
        }else{
            return redirect()->route('home')
            ->with('error', 'Non sei autorizzato');
        }
    }


    public function edit($id)
    {
        if (Auth::user()->agent_code == '00000000') {
            $user = User::find($id);

            return view('users.edit', compact('user'));
        }else{
            return redirect()->route('home')
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

            if (!empty($input['code'])) {
                $user->agent()->update(array('code' => $input['code']));
            }

            if(isset($request->assignable)){
                $input['assignable'] = true;
            }else{
                $input['assignable'] = false;
            }

            $user->update($input);

            return redirect()->route('users.index')
                ->with('success', 'Utente aggiornato correttamente');

        } else {
            return redirect()->route('users.index')
            ->with('error', 'Non sei autorizzato');
        }
    }


    public function destroy($id)
    {
        //Destroy user
        if (Auth::user()->agent_code == '00000000') {
            $user = User::find($id);
            $user->delete();
            return redirect()->route('users.index')
                ->with('success', 'Utente eliminato correttamente');
        }else{
            return redirect()->route('users.index')
            ->with('error', 'Non sei autorizzato');
        }
    }
}

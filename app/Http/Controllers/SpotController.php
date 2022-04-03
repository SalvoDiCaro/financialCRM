<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spot;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class SpotController extends Controller
{

    public function index()
    {
        $spots = Spot::all();


        return view('spots.index', compact('spots'));
    }

    public function create(Request $request)
    {


        return view('spots.create', compact('products', 'leads', 'lead', 'debts', 'companies'));
    }

    public function store(Request $request)
    {

        return redirect()->route('spots.index')
            ->with('success', 'Spot created successfully.');
    }

    public function show($id)
    {


        return view('spots.show', compact('Spot', 'messages', 'partecipations'));
    }

    public function edit(Spot $Spot)
    {


        return view('spots.edit', compact('Spot', 'agents', 'products', 'partecipations'));
    }

    public function update(Request $request, Spot $Spot)
    {

        return redirect()->route('spots.index')
            ->with('success', 'Spot updated successfully');
    }

    public function destroy(Spot $Spot)
    {
        $Spot->delete();

        return redirect()->route('spots.index')
            ->with('success', 'Spot deleted successfully');
    }
}

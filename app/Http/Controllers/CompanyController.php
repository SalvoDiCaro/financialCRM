<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Company;
use App\Models\Assignment;
use App\Models\Instance;
use App\Models\Partecipation;
use App\Models\Note;
use App\Models\Debt;

class CompanyController extends Controller
{
    public function index()
    {

        $companies = Company::all();


        return view('companies.index', compact('companies'));
    }

    public function create(Request $request)
    {

        return view('companies.create');
    }

    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'vat_number' => 'required',
        ]);

        Company::create($request->all());

        return redirect()->route('companies.index')
            ->with('success', 'Azienda creata con successo.');
    }

    public function show($id)
    {
        return view('companies.show');
    }

    public function edit($id)
    {

        $company = Company::where('id',$id)->get()->first();

        return view('companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        request()->validate([
            'name' => 'required',
            'vat_number' => 'required',
        ]);

        $company->update($request->all());

        return redirect()->route('companies.index')
            ->with('success', 'Azienda creata con successo');
    }

    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->route('companies.index')
            ->with('success', 'Azienda eliminata con successo');
    }
}

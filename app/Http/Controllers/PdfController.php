<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class PdfController extends Controller
{
    public function create()
    {
    	$data = ['title' => 'Riepilogo richiesta'];
        $pdf = PDF::loadView('pdf', $data);

        return $pdf->download('richiesta.pdf');
    }
}

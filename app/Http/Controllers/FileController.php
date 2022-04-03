<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use Illuminate\Support\Facades\Response;


class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fileUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,xlx,csv,png,jpg|max:2048',
        ]);

        $fileName = time() . '.' . $request->file->extension();

        $request->file->move(public_path('uploads'), $fileName);

        $lead = Lead::find($request->lead);

        $lead->document = $fileName;

        $lead->save();

        return back()
            ->with('success', 'File caricato con successo.')
            ->with('file', $fileName);
    }

    public function fileDownload(Request $request)
    {
        $filename = $request->document;

        $path = public_path('uploads') . '/' . $filename;

        if (file_exists($path)) {
            return Response::download($path);
        }
    }
}

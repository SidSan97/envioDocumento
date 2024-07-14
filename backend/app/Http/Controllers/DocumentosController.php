<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class DocumentosController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {

            $file = $request->file('file');
            $extensoesPermitidas = ['pdf'];
            $extensao = $file->getClientOriginalExtension();

            if(!in_array($extensao, $extensoesPermitidas)) {
                return response()->json(['error' => 'Formato não permitido'], 415);
            }
            
            $path = $file->store('uploads', 'public');

            return response()->json(['path' => $path], 200);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
}

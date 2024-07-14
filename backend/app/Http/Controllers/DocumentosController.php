<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;

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
            $var = $this->lerCnpjPDF($path);

            return response()->json(['path' => $path, 'cnpj'=>$var], 200);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

    public function lerCnpjPDF($path)
    {
        $caminho = "http://localhost//envioDocumento/backend//public/storage//";

        $parser = new Parser();
        $pdf = $parser->parseFile($caminho . $path);

        $data = $pdf->getText();
        $string_sem_espacos = str_replace(' ', '', $data);

        preg_match('/(\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}|\d{3}\.\d{3}\.\d{3}-\d{2})/', $string_sem_espacos, $matches);

        if (isset($matches[1])) {
            $razaoSocial = trim($matches[1]);
            return $razaoSocial;
        } else {
            return '';
        }
    }
}

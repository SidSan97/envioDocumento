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
            $dados = $this->lerDadosPDF($path);

            if(!$dados) {
                return response()->json(['error' => 'Não foi possível ler PDF.'], 404);
            }

            $cliente      = new ClienteController();
            $dadosCliente = $cliente->pegarDadosClientePorDocumento($dados, $request->id);

            return response()->json(['path' => $path, 'dados'=>$dadosCliente], 200);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

    public function lerDadosPDF(string $path)
    {
        $caminho = str_replace('\\', '/', __DIR__);
        $caminho = preg_replace('/(backend).*/', '$1', $caminho);

        $parser = new Parser();
        $pdf = $parser->parseFile($caminho .'/public/storage/'. $path);

        $data = $pdf->getText();
        $string_sem_espacos = str_replace(' ', '', $data);

        preg_match('/(\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}|\d{3}\.\d{3}\.\d{3}-\d{2})/', $string_sem_espacos, $matches);

        if (isset($matches[1])) {
            $cpf_cnpj = trim($matches[1]);
            return $cpf_cnpj;
        } else {
            return false;
        }
    }
}

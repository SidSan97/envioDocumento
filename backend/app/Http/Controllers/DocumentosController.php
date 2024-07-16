<?php

namespace App\Http\Controllers;

use App\Models\DocumentoModel;
use Smalot\PdfParser\Parser;

class DocumentosController extends Controller
{
    public function upload($file)
    {
        $extensoesPermitidas = ['pdf'];
        $extensao = $file->getClientOriginalExtension();

        if(!in_array($extensao, $extensoesPermitidas)) {
            return ['error' => "Formato de arquivo não permitido.", 'status' => 415];
        }

        $nomeArquivo = 'Documento_Arrecadacao_' . date('Y') . '_' .time() . '.' . $extensao;
        $path = $file->storeAs('uploads', $nomeArquivo ,'public');

        return ['diretorio' => $path];
    }

    public function lerDadosPDF(string $path)
    {
        $caminho = str_replace('\\', '/', __DIR__);
        $caminho = preg_replace('/(backend).*/', '$1', $caminho);
        $caminho = $caminho .'/public/storage/'. $path;

        $parser = new Parser();
        $pdf = $parser->parseFile($caminho);

        $data = $pdf->getText();
        $string_sem_espacos = str_replace(' ', '', $data);

        preg_match('/(\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}|\d{3}\.\d{3}\.\d{3}-\d{2})/', $string_sem_espacos, $matches);

        if (isset($matches[1])) {
            $cpf_cnpj = trim($matches[1]);
            return [
                "documento" => $cpf_cnpj,
                "diretorio" => $caminho
            ];
        } else {
            return false;
        }
    }

    public function cadastrarPDF(string $caminho, int $id_cliente, int $id_user)
    {
        $doc = new DocumentoModel();

        $doc->nome_doc = $caminho;
        $doc->id_td = 1;
        $doc->data_upload = date('Y-m-d H:i:s');
        $doc->id_user = $id_user;
        $doc->id_cliente = $id_cliente;

        if(!$doc->save()){
            return false;
        }
    }
}

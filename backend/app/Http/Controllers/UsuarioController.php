<?php

namespace App\Http\Controllers;

use App\Models\DocumentoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class UsuarioController extends Controller
{
    public function envioDocumento(Request $request)
    {
        if ($request->hasFile('file')) {

            $doc = new DocumentosController();

            $file = $request->file('file');
            $upload = $doc->upload($file);

            if(isset($upload['error'])) {
                return response()->json(['error' => $upload['error']], $upload['status']);
            }

            $dadosPDF = $doc->lerDadosPDF($upload['diretorio']);

            if(!$dadosPDF) {
                return response()->json(['error' => 'Não foi possível ler PDF.'], 400);
            }

            $cliente      = new ClienteController();
            $dadosCliente = $cliente->pegarDadosClientePorDocumento($dadosPDF['documento'], $request->id);

            if(!$dadosCliente) {
                return response()->json(['error' => 'Você não possui clientes com esse CNPJ/CPF cadastrado no sistema.'], 404);
            }

            $dados = [
                'fromName' => 'Contabilizei',
                'fromEmail' => 'contatosidsan@sidneidev.com.br',
                'subject' => 'IMPOSTO DE RENDA',
                'message' => 'Olá, ' . $dadosCliente['nome'] .'. Seu documento já se encontra disponível em anexo.',
                'recipientEmail' => $dadosCliente['email'],
                'recipientName' => $dadosCliente['nome'],
            ];

            $pathToFile = Storage::path('public\\' . $upload['diretorio']);

            Mail::raw($dados['message'], function ($message) use ($dados, $pathToFile) {
                $message->from($dados['fromEmail'], $dados['fromName']);
                $message->to($dados['recipientEmail'], $dados['recipientName'])
                        ->subject($dados['subject'])
                        ->attach($pathToFile);
            });

            $doc->cadastrarPDF($upload['diretorio'], $dadosCliente['id_cliente'], $request->id);

            return response()->json(['message' => 'Documento enviado com sucesso', 'path' => $upload['diretorio']], 200);
        }

        return response()->json(['error' => 'Não há arquivos para upload.'], 400);
    }

    public function obterDocumentos(int $id)
    {
        $documentos = DocumentoModel::select('data_upload', 'nome_doc')->with('cliente')->where('id_user', $id)->get();

        return $documentos;
    }
}

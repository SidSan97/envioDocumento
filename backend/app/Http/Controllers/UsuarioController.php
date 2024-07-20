<?php

namespace App\Http\Controllers;

use App\Models\ClienteModel;
use App\Models\DocumentoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class UsuarioController extends Controller
{
    public function envioDocumento(Request $request)
    {
        $erros = ['erro' => []];
        $error = false;
        $teste = '';

        if (request()->hasFile('files')) {

            foreach(request()->file('files') as $arquivo) {

                $doc = new DocumentosController();

                $upload = $doc->upload($arquivo);
                $teste = $arquivo->getClientOriginalName();

                if(isset($upload['error'])) {
                    //return response()->json(['error' => $upload['error']], $upload['status']);
                    $erros['erro'][] = $upload['error'].": " . $arquivo->getClientOriginalName();
                    $error = true;
                    continue;
                }

                //*********************************** */
                $dadosPDF = $doc->lerDadosPDF($upload['diretorio']);

                if(!$dadosPDF) {
                    $erros['erro'][] = "Não foi possível ler o seguinte PDF: " . $arquivo->getClientOriginalName();
                    $error = true;
                    continue;
                }

                $cliente      = new ClienteController();
                $dadosCliente = $cliente->pegarDadosClientePorDocumento($dadosPDF['documento'], $request->id);

                if(!$dadosCliente) {
                    //return response()->json(['error' => 'Você não possui clientes com esse CNPJ/CPF cadastrado no sistema.'], 404);
                    $erros['erro'][] = "Você não possui clientes com esse CNPJ/CPF cadastrado no sistema para o CPF/CNPJ: " . $dadosPDF['documento'];
                    $error = true;
                    continue;
                }

                $dados = [
                    'fromName'  => 'Automatiza Contabil',
                    'fromEmail' => 'contatosidsan@sidneidev.com.br',
                    'subject' => 'DOCUMENTO DE ARRECADAÇÃO',
                    'message' => 'Olá, ' . $dadosCliente['nome'] .'. Seu documento já se encontra disponível em anexo.',
                    'recipientEmail' => $dadosCliente['email'],
                    'recipientName'  => $dadosCliente['nome'],
                ];

                $pathToFile = Storage::path('public\\' . $upload['diretorio']);


                Mail::raw($dados['message'], function ($message) use ($dados, $pathToFile) {
                    $message->from($dados['fromEmail'], $dados['fromName']);
                    $message->to($dados['recipientEmail'], $dados['recipientName'])
                            ->subject($dados['subject'])
                            ->attach($pathToFile);
                });

                $doc->cadastrarPDF($upload['diretorio'], $dadosCliente['id_cliente'], $request->id);
            }

            if($error){
                return response()->json(['message' => 'Não foi possível enviar alguns arquivos', 'erros'=> $erros], 207);
            }

            return response()->json(['message' => 'Documento(s) enviado com sucesso', 'dado' => $teste], 200);
        }

        return response()->json(['error' => 'Não há arquivos para upload.'], 400);
    }

    public function obterDocumentos(int $id)
    {
        $documentos = DocumentoModel::select('data_upload', 'nome_doc', 'id_cliente')->where('id_user', $id)->get();

        $documentos->transform(function ($item) {
            $dadosCliente = ClienteModel::where('id_cliente', $item['id_cliente'])->get()->first();
            $item['cliente'] = $dadosCliente;

            return $item;
        });

        return $documentos;
    }
}

<?php

namespace App\Http\Controllers;

use App\Mail\EnvioEmailDocumentos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

            $dados = $doc->lerDadosPDF($upload['diretorio']);

            if(!$dados) {
                return response()->json(['error' => 'Não foi possível ler PDF.'], 400);
            }

            $cliente      = new ClienteController();
            $dadosCliente = $cliente->pegarDadosClientePorDocumento($dados, $request->id);

            if(!$dadosCliente) {
                return response()->json(['error' => 'Você não possui clientes com esse CNPJ/CPF cadastrado no sistema.'], 404);
            }

            $data = [
                'fromName' => 'grupo dbf',
                'fromEmail' => 'diretoria@email.com',
                'subject' => 'Envio do seu imposto de renda',
                'message' => 'Teste de email'
            ];
            //dd($data);

            Mail::to('sidnei1.8santiago@hotmail.com', 'Contabilizei')
            ->send(new EnvioEmailDocumentos($data['fromName'], $data['fromEmail'], $data['subject'], $data['message']));

            //var_dump('enviado', $send);

            return response()->json(['Documento enviado com sucesso' => $upload['diretorio']/*, 'dados'=>$send*/], 200);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
}

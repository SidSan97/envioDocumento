<?php

namespace App\Http\Controllers;

use App\Models\ClienteModel;
use App\Models\DocumentoModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class UsuarioController extends Controller
{
    public function envioDocumento(Request $request)
    {
        $erros = ['erro' => []];
        $error = false;

        if ($request->hasFile('files')) {
            foreach($request->file('files') as $arquivo) {
                $doc = new DocumentosController();
                $upload = $doc->upload($arquivo);

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

            return response()->json(['message' => 'Documento(s) enviado com sucesso'], 200);
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

    public function cadastrarLoginCliente($dados)
    {
        $user = new User();

        $user->name = $dados->nome;
        $user->email = $dados->email;
        $user->password = Hash::make('1234');
        $user->id_cargo = 4;
        $user->first_login = 1;

        if(!$user->save()) {
            return false;
        }

        return true;
    }

    public function alterarSenha(Request $request)
    {
        if($request->senha !== $request->senha2) {
            return response()->json(['error' => "A senhas são diferentes."], 400);
        }

        $user = User::where('id_user', $request->id)->first();
        $user->password = Hash::make($request->senha);
        $user->first_login = 0;

        if(!$user->save()) {
            return response()->json(['error' => "Não foi possível alterar senha. Tente novamente."], 500);
        }

        return response()->json(['message' => "Senha alterada com sucesso!"], 200);
    }

    public function listarColaboradores()
    {
        $colaborador = User::select('id_user', 'name', 'email')
                            ->where('id_cargo', 3)
                            ->get();

        $colaborador->transform(function ($item) {
            $dadosCliente = ClienteModel::where('id_user', $item['id_user'])->get()->first();
            $qtdClientes = ClienteModel::where('id_user', $item['id_user'])->count();
            $qtdDocEnviados = DocumentoModel::where('id_user', $item['id_user'])->count();

            $item['cliente'] = $dadosCliente;
            $item['qtdClientes'] = $qtdClientes;
            $item['qtdDocEnviados'] = $qtdDocEnviados;

            return $item;
        });

        return $colaborador;
    }

    public function listarClientes(int $id)
    {
        $cliente = ClienteModel::where('id_user', $id)->get();

        return response()->json(['clients'=>$cliente], 200);
    }

    public function editarCliente(Request $request)
    {
        $cliente = ClienteModel::where('id_cliente', $request->id)->first();

        $cliente->nome = $request->nome;
        $cliente->email = $request->email;
        $cliente->cpf_cnpj = $request->cpf_cnpj;
        $cliente->telefone = $request->telefone;
        $cliente->cliente_ativo = $request->cliente_ativo;

        if(!$cliente->save()) {
            return response()->json(['error'=>"Erro ao alterar dados do cliente. Tente novamente."], 500);
        }

        return response()->json(['message'=>"Cliente atualizado com sucesso!"], 200);
    }
}

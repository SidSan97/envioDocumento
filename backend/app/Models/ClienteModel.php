<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteModel extends Model
{
    protected $table = 'dados_clientes';
    protected $primaryKey = 'id_cliente';
    use HasFactory;

    public function documentos()
    {
        return $this->hasMany(DocumentoModel::class, 'id_cliente', 'id_cliente');
    }
}

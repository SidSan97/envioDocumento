<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoModel extends Model
{
    protected $table = 'documentos';
    protected $primaryKey = 'id_doc';
    use HasFactory;

    public function cliente()
    {
        return $this->belongsTo(ClienteModel::class, 'id_cliente', 'id_cliente');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->id('id_doc');
            $table->string('nome_doc');
            $table->unsignedBigInteger('id_td')->nullable();
            $table->dateTime('data_upload');
            $table->unsignedBigInteger('id_user')->nullable();
            $table->unsignedBigInteger('id_cliente')->nullable();
            $table->timestamps();

            // Definir a chave estrangeira
             $table->foreign('id_user')
             ->references('id_user')
             ->on('users')
             ->onDelete('set null');

             $table->foreign('id_cliente')
             ->references('id_cliente')
             ->on('dados_clientes')
             ->onDelete('set null');

             $table->foreign('id_td')
             ->references('id_td')
             ->on('tipo_documento')
             ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

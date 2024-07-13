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
            $table->string('cpf_cnpj');
            $table->dateTime('data_upload');
            $table->unsignedBigInteger('id_user')->nullable();
            $table->timestamps();

            // Definir a chave estrangeira
             $table->foreign('id_user')
             ->references('id_user')
             ->on('users')
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

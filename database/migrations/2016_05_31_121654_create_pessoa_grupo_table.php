<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePessoaGrupoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pessoa_grupo', function (Blueprint $table) {
            $table->integer('pessoa_id')->unsigned()->index();
            $table->integer('grupo_id')->unsigned()->index();
        });
        // Cria ligações entre tabelas
        Schema::table('pessoa_grupo', function (Blueprint $table)
        {
            $table->foreign('pessoa_id')->references('id')->on('pessoas');
            $table->foreign('grupo_id')->references('id')->on('grupos');
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Deletar ligações entre tabelas
        Schema::table('pessoa_grupo', function (Blueprint $table)
        {
            $table->dropForeign('pessoa_grupo_pessoa_id_foreign');
            $table->dropForeign('pessoa_grupo_grupo_id_foreign');
        });        
        Schema::drop('pessoa_grupo');
    }
}

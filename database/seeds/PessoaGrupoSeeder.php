<?php

use Illuminate\Database\Seeder;

class PessoaGrupoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pessoas = \App\Pessoa::all();

        // Adiciona um grupo para cada pessoa
        foreach ($pessoas as $pessoa) {
	        DB::table('pessoa_grupo')->insert([
        		'pessoa_id'	=> $pessoa->id,
        		'grupo_id'	=> rand(1,10),
        	]);
        }

        // Adiciona outro grupo para cada pessoa
        foreach ($pessoas as $pessoa) {
	        DB::table('pessoa_grupo')->insert([
        		'pessoa_id'	=> $pessoa->id,
        		'grupo_id'	=> rand(1,10),
        	]);
        }
    }
}

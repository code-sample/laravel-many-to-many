<?php

use Illuminate\Database\Seeder;

class PessoasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// Quantidade de registros
    	$qtd = 50;
    	
        factory(App\Pessoa::class, $qtd)->create();
    }
}

<?php

use Illuminate\Database\Seeder;

class GruposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// Quantidade de registros
    	$qtd = 10;
    	
        factory(App\Grupo::class, $qtd)->create();
    }
}

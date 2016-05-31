# laravel-many-to-many

Exemplo simples de código para utilizar uma relação many to many com Eloquent

# Passo a passo

1. Criar banco de dados e configurar o arquivo _.env_

2. Criar modelos (_models_) e tabelas (_migrations_)

    php artisan make:model Pessoa -m
    php artisan make:model Grupo -m
    php artisan make:migration create_pessoa_grupo_table --create=pessoa_grupo

	
2.1 **Pessoa**

    Schema::create('pessoas', function (Blueprint $table) {
        $table->increments('id');
        $table->string('nome');
        $table->timestamps();
    });

2.2. **Grupo**

    Schema::create('grupos', function (Blueprint $table) {
        $table->increments('id');
        $table->string('descricao');
        $table->timestamps();
    });

2.3 **Pessoa_Grupo**

    Schema::create('pessoa_grupo', function (Blueprint $table) {
        $table->bigInteger('pessoa_id')->unsigned()->index();
        $table->bigInteger('grupo_id')->unsigned()->index();
    });
    
    // Cria ligações entre tabelas
    Schema::table('pessoa_grupo', function (Blueprint $table)
    {
        $table->foreign('pessoa_id')->references('id')->on('pessoas');
        $table->foreign('grupo_id')->references('id')->on('grupos');
    });

    // Na função _down_
    Schema::table('pessoa_grupo', function (Blueprint $table)
    {
        $table->dropForeign('pessoa_grupo_pessoa_id_foreign');
        $table->dropForeign('pessoa_grupo_grupo_id_foreign');
    });


3. Configura os modelos (_model_)

3.1 **Pessoa**
	class Pessoa extends Model
	{
	    protected $table = 'pessoas';

	    protected $fillable = ['nome'];

	    public function grupos()
	    {
	    	return $this->belongsToMany('App\Grupo', 'pessoa_grupo');
	    }
	}

3.2 **Grupo**

	class Grupo extends Model
	{
	    protected $table = 'grupos';

	    protected $fillable = ['descricao'];

	    public function pessoas()
	    {
	    	return $this->belongsToMany('App\Pessoa', 'pessoa_grupo');
	    }
	}


4. Cria dados fictícios

4.1 Factory

	$factory->define(App\Pessoa::class, function (Faker\Generator $faker) {
	    return [
	        'nome'		=> $faker->name,
	    ];
	});

	$factory->define(App\Grupo::class, function (Faker\Generator $faker) {
	    return [
	        'descricao'		=> $faker->word,
	    ];
	});

4.2 Seeder

    php artisan make:seeder PessoasSeeder
    php artisan make:seeder GruposSeeder
    php artisan make:seeder PessoaGrupoSeeder

4.2.1 PessoasSeeder

	// Quantidade de registros
	$qtd = 50;
	
    factory(App\Pessoa::class, $qtd)->create();

4.2.2 GruposSeeder

	// Quantidade de registros
	$qtd = 10;
	
    factory(App\Grupo::class, $qtd)->create();

4.2.3 PessoaGrupoSeeder

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

4.3 Ativa a criação dos dados

    //DatabaseSeeder.php
    $this->call(PessoasSeeder::class);
    $this->call(GruposSeeder::class);
    $this->call(PessoaGrupoSeeder::class);    

4.4 Roda o Seeder

	php artisan db:seed



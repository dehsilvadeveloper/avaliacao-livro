<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Database\Seeders\PaisTableSeeder;

class CreatePaisTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        if (!Schema::hasTable('pais')) {

            Schema::create('pais', function (Blueprint $table) {

                $table->engine = 'MyISAM';
                $table->charset = 'utf8';
                $table->collation = 'utf8_unicode_ci';

                $table->increments('cod_pais');
                $table->string('nome', 100);
                $table->string('codigo', 3);

            });

            // Alimentando tabela com dados padrão
            $seeder = new PaisTableSeeder();
            $seeder->run();

        }

    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {

        Schema::dropIfExists('pais');
        
    }



}

<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenerosLivrosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        if (!Schema::hasTable('generos_livros')) {

            Schema::create('generos_livros', function (Blueprint $table) {
                
                $table->engine = 'MyISAM';
                $table->charset = 'utf8';
                $table->collation = 'utf8_unicode_ci';

                $table->increments('cod_genero_livro');
                $table->integer('cod_genero')->unsigned();
                $table->integer('cod_livro')->unsigned();

                $table->foreign('cod_genero', 'fk_generos_livros_genero')->references('cod_genero')->on('genero');
                $table->foreign('cod_livro', 'fk_generos_livros_livro')->references('cod_livro')->on('livro');
                
            });

        }

    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {

        Schema::dropIfExists('generos_livros');
        
    }



}

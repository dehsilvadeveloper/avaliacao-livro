<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutoresLivrosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        if (!Schema::hasTable('autores_livros')) {

            Schema::create('autores_livros', function (Blueprint $table) {

                $table->engine = 'MyISAM';
                $table->charset = 'utf8';
                $table->collation = 'utf8_unicode_ci';

                $table->increments('cod_autor_livro');
                $table->integer('cod_autor')->unsigned();
                $table->integer('cod_livro')->unsigned();

                $table->foreign('cod_autor', 'fk_autores_livros_autor')->references('cod_autor')->on('autor');
                $table->foreign('cod_livro', 'fk_autores_livros_livro')->references('cod_livro')->on('livro');

            });

        }

    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {

        Schema::dropIfExists('autor_livro');
        
    }



}

<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeriesLivrosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        if (!Schema::hasTable('series_livros')) {

            Schema::create('series_livros', function (Blueprint $table) {

                $table->engine = 'MyISAM';
                $table->charset = 'utf8';
                $table->collation = 'utf8_unicode_ci';

                $table->increments('cod_serie_livro');
                $table->integer('cod_serie')->unsigned();
                $table->integer('cod_livro')->unsigned();
                $table->integer('numero_na_serie')->unsigned()->default(0);

                $table->foreign('cod_serie', 'fk_series_livros_serie')->references('cod_serie')->on('serie');
                $table->foreign('cod_livro', 'fk_series_livros_livro')->references('cod_livro')->on('livro');

            });

        }

    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {

        Schema::dropIfExists('series_livros');
        
    }



}

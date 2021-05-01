<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLivroTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        if (!Schema::hasTable('livro')) {

            Schema::create('livro', function (Blueprint $table) {

                $table->engine = 'MyISAM';
                $table->charset = 'utf8';
                $table->collation = 'utf8_unicode_ci';

                $table->increments('cod_livro');
                $table->integer('cod_editora')->nullable()->unsigned();
                $table->string('titulo', 100);
                $table->string('titulo_original', 100);
                $table->string('idioma', 30);
                $table->string('isbn_10', 60);
                $table->string('isbn_13', 60);
                $table->date('data_publicacao')->nullable()->comment('data da primeira publicação');
                $table->text('sinopse');
                $table->integer('total_paginas')->unsigned()->default(0);
                $table->tinyInteger('tipo_capa')->default(1)->comment('1 = capa comum; 2 = capa dura;');
                $table->string('foto_capa', 100)->nullable()->comment('nome da imagem da capa');
                $table->datetime('created_at')->useCurrent();
                $table->datetime('updated_at')->nullable();
                $table->tinyInteger('status')->default(1)->comment('1 = ativo; 0 = inativo;');

                $table->foreign('cod_editora', 'fk_livro_editora')->references('cod_editora')->on('editora');

            });

        }

    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {

        Schema::dropIfExists('livro');
        
    }



}

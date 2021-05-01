<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvaliacaoTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        if (!Schema::hasTable('avaliacao')) {

            Schema::create('avaliacao', function (Blueprint $table) {

                $table->engine = 'MyISAM';
                $table->charset = 'utf8';
                $table->collation = 'utf8_unicode_ci';

                $table->increments('cod_avaliacao');
                $table->integer('cod_usuario')->unsigned();
                $table->integer('cod_livro')->unsigned();
                $table->integer('nota');
                $table->text('review');
                $table->datetime('created_at')->useCurrent();
                $table->datetime('updated_at')->nullable();
    
                $table->foreign('cod_usuario', 'fk_avaliacao_usuario')->references('cod_usuario')->on('usuario');
                $table->foreign('cod_livro', 'fk_avaliacao_livro')->references('cod_livro')->on('livro');

            });

        }

    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {

        Schema::dropIfExists('avaliacao');
        
    }



}

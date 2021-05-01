<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutorTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        if (!Schema::hasTable('autor')) {

            Schema::create('autor', function (Blueprint $table) {

                $table->engine = 'MyISAM';
                $table->charset = 'utf8';
                $table->collation = 'utf8_unicode_ci';

                $table->increments('cod_autor');
                $table->integer('cod_pais')->nullable()->unsigned();
                $table->string('nome', 100);
                $table->date('data_nascimento')->nullable();
                $table->string('website', 100)->nullable();
                $table->string('twitter', 100)->nullable();
                $table->datetime('created_at')->useCurrent();
                $table->datetime('updated_at')->nullable();

                $table->foreign('cod_pais', 'fk_autor_pais')->references('cod_pais')->on('pais');

            });

        }

    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {

        Schema::dropIfExists('autor');
        
    }



}

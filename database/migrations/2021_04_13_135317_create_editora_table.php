<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEditoraTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        if (!Schema::hasTable('editora')) {

            Schema::create('editora', function (Blueprint $table) {

                $table->engine = 'MyISAM';
                $table->charset = 'utf8';
                $table->collation = 'utf8_unicode_ci';

                $table->increments('cod_editora');
                $table->string('nome_fantasia', 100);
                $table->string('website', 100)->nullable();
                $table->datetime('created_at')->useCurrent();
                $table->datetime('updated_at')->nullable();

            });

        }

    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {

        Schema::dropIfExists('editora');
        
    }



}

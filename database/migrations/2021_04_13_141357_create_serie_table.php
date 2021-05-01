<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSerieTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        if (!Schema::hasTable('serie')) {

            Schema::create('serie', function (Blueprint $table) {

                $table->engine = 'MyISAM';
                $table->charset = 'utf8';
                $table->collation = 'utf8_unicode_ci';

                $table->increments('cod_serie');
                $table->string('titulo', 100);
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

        Schema::dropIfExists('serie');
        
    }



}

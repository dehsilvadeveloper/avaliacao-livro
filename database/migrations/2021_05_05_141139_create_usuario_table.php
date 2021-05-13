<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuarioTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        if (!Schema::hasTable('usuario')) {

            Schema::create('usuario', function (Blueprint $table) {
                
                $table->engine = 'MyISAM';
                $table->charset = 'utf8';
                $table->collation = 'utf8_unicode_ci';

                $table->increments('cod_usuario');
                $table->string('usuario', 100)->unique();
                $table->text('password');
                $table->string('email', 100);
                $table->datetime('email_verified_at')->nullable();
                $table->rememberToken();
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

        Schema::dropIfExists('usuario');
        
    }



}

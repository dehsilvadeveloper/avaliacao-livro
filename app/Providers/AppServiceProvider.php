<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider {

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }



    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        
        // Controlando nível de exibição de erros (não travar o app por causa de php notices)
        error_reporting(E_ERROR | E_WARNING | E_PARSE);

        // Comprimento da string padrão gerado pelas migrações (migrations) para que o MySQL crie índices para elas
        Schema::defaultStringLength(191);

    }



}

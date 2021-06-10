<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {

        // Inserimos dados padrão do sistema
        $this->call(PaisTableSeeder::class);
        $this->call(UsuarioTableSeeder::class);
        
        $this->call(Testes\PrimeiroTeste\RegistrosEspecificosParaTabelasSeeder::class);

    }



}

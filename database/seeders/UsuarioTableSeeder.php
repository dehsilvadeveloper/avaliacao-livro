<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

// Importo models
use App\Models\Usuario;

class UsuarioTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        Usuario::truncate();

        Usuario::create([
            'usuario' => 'postman',
            'password' => bcrypt('qWe*7895'),
            'email' => 'teste@teste.com.br'
        ]);

    }


}

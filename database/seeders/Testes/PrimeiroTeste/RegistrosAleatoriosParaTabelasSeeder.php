<?php
namespace Database\Seeders\Testes\PrimeiroTeste;

use Illuminate\Database\Seeder;
use DB;

// Importo models
use App\Models\Pais;
use App\Models\Autor;
use App\Models\Editora;
use App\Models\Genero;
use App\Models\Serie;
use App\Models\Livro;
use App\Models\Usuario;

class RegistrosAleatoriosParaTabelasSeeder extends Seeder {

    // Cria registros aleatórios para testes da aplicação

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        // Procuramos o último país criado
        $pais = Pais::orderBy('cod_pais', 'DESC')->first();

        if (!$pais) {

            // Criamos 1 país
            $pais = Pais::factory()->create();

        }

        // Criamos 5 autores para este pais
        $autores_de_pais = Autor::factory()
                                ->count(5)
                                ->for($pais, 'nacionalidade')
                                ->create();

        // Criamos 6 gêneros
        $generos = Genero::factory()->count(6)->create();

        // Criamos 1 editora
        $editora = Editora::factory()->create();

        // Criamos 1 série
        $serie = Serie::factory()->create();

        // Criamos collection vazia
        $livros = collect(); 

        // Definimos o total de livros que será criado
        $total_livros = 3;

        // Criamos um loop e dentro dele executamos o comando create() várias vezes para criar os livros
        // Este procedimento permite randomizar a escolha de autores e gêneros para os livros criados
        for ($i = 1; $i <= $total_livros; $i++) { 
            
            $livro = Livro::factory()
                          ->for($editora, 'editora')
                          ->hasAttached($autores_de_pais->random(1), [], 'autores')
                          ->hasAttached($generos->random(2), [], 'generos')
                          ->hasAttached($serie, ['numero_na_serie' => $i], 'series') // pode ser omitido se desejar que os livros não façam parte de uma série
                          ->create();

            // Adicionamos item criado a collection
            $livros->add($livro);

        }

        /* ::: PROCEDIMENTOS ALTERNATIVOS ::: */

        // Criamos 3 livros com apenas 1 comando
        // Este procedimento cria os livros adequadamente, mas repete os mesmos autores e gêneros para todos eles
        /*$livros = Livro::factory()
                       ->count(3)
                       ->for($editora, 'editora')
                       ->hasAttached($autores_de_pais->random(1), [], 'autores')
                       ->hasAttached($generos->random(2), [], 'generos')
                       ->create();*/

        // Criamos uma série e atribuímos a ela aleatoriamente 2 dos livros criados anteriormente
        // Este procedimento não permite gerar um valor para a coluna "numero_na_serie" para cada livro utilizado na relação (por isso foi deixado o valor padrão zero)
        // Para utilizar este procedimento, é necessário que os livros tenham sido criados previamente SEM relação com nenhuma série.
        /*$serie = Serie::factory()
                      ->hasAttached($livros->random(2), ['numero_na_serie' => 0], 'livros')
                      ->state([
                          'numero_de_livros' => 2
                      ])
                      ->create();*/

    }



}
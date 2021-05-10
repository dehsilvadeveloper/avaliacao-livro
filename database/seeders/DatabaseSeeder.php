<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

// Importo models
use App\Models\Pais;
use App\Models\Autor;
use App\Models\Editora;
use App\Models\Genero;
use App\Models\Serie;
use App\Models\Livro;
use App\Models\Usuario;

class DatabaseSeeder extends Seeder {

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {

        // Executamos método que cria registros aleatórios para testes da aplicação
        //$this->criarRegistrosAleatoriosParaTeste();

        // Executamos método que cria registros especificos para testes da aplicação
        $this->criarRegistrosEspecificosParaTeste();

    }



    /**
     * Cria registros ALEATORIOS nas tabelas, permitindo testar o correto funcionamento dos models e suas relações.
     *
     * @return void
     */
    private function criarRegistrosAleatoriosParaTeste() {

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



    /**
     * Cria registros ESPECIFICOS nas tabelas, permitindo testar o correto funcionamento dos models e suas relações.
     *
     * @return void
     */
    private function criarRegistrosEspecificosParaTeste() {

        // Pegamos informações do país ESTADOS UNIDOS
        $pais = Pais::where('nome', '=', 'United States')->first();

        // Criamos autores
        $autor_1 = Autor::create([
            'cod_pais' => $pais->cod_pais,
            'nome' => 'Rick Riordan',
            'data_nascimento' => '1964-06-05',
            'website' => 'https://rickriordan.com',
            'twitter' => 'https://twitter.com/rickriordan'
        ]);

        /*$autor_2 = Autor::create([
            'cod_pais' => $pais->cod_pais,
            'nome' => 'Timothy Zahn'
        ]);*/

        // Criamos gêneros
        $genero_1 = Genero::create(['nome' => 'Fantasia']);

        $genero_2 = Genero::create(['nome' => 'Aventura']);

        $genero_3 = Genero::create(['nome' => 'Mitologia Grega']);

        $genero_4 = Genero::create(['nome' => 'Ficção Científica']);

        $genero_5 = Genero::create(['nome' => 'Ação']);

        // Criamos editoras
        $editora_1 = Editora::create([
            'nome_fantasia' => 'Intrínseca',
            'website' => 'https://www.intrinseca.com.br'
        ]);

        /*$editora_2 = Editora::create([
            'nome_fantasia' => 'Aleph',
            'website' => 'https://www.aleph.com.br'
        ]);*/

        // Criamos série
        $serie_1 = Serie::create([
            'titulo' => 'Percy Jackson e os Olimpianos'
        ]);

        // Criamos livro 1
        $livro_1 = Livro::create([
            'cod_editora' => $editora_1->cod_editora,
            'titulo' => 'O Ladrão de Raios',
            'titulo_original' => 'The Lightning Thief',
            'idioma' => 'Português',
            'isbn_10' => '8580575397',
            'isbn_13' => '9788580575392',
            'data_publicacao' => '2014-08-18',
            'sinopse' => 'Os deuses do Olimpo continuam vivos, em pleno século XXI! Eles ainda se apaixonam por mortais e têm filhos que podem se tornar grandes heróis, mas que acabam, na maioria das vezes, encontrando destinos terríveis nas garras de monstros sem coração. Apenas alguns descobrem sua identidade e conseguem chegar ao Acampamento Meio-Sangue, um acampamento de verão em Long Island dedicado ao treinamento de jovens semideuses. Essa é a revelação que leva Percy Jackson a uma incrível busca para ajudar seu verdadeiro pai - o deus dos mares! - a evitar uma guerra no Olimpo. Com a ajuda do sátiro Grover Underwood e de Annabeth Chase, uma filha de Atena, Percy é encarregado de cruzar os Estados Unidos para capturar o ladrão que roubou a mais poderosa arma de destruição já concebida: o raio mestre de Zeus. No caminho, eles enfrentam uma horda de inimigos mitológicos determinados a detê-los. Em meio aos perigos dessa jornada, Percy precisa confrontar um pai que ele não conhece e se precaver de uma cruel traição.',
            'total_paginas' => 377,
            'tipo_capa' => 1,
            'foto_capa' => rand(1, 9) . date('YmdHis') . '.jpg',
            'status' => 1
        ]);

        $livro_1->generos()->attach([
            $genero_1->cod_genero, 
            $genero_2->cod_genero, 
            $genero_3->cod_genero
        ]);
        $livro_1->autores()->attach([
            $autor_1->cod_autor
        ]);
        $livro_1->series()->attach([
            $serie_1->cod_serie => ['numero_na_serie' => 1]
        ]);

        
        // Criamos livro 2
        $livro_2 = Livro::create([
            'cod_editora' => $editora_1->cod_editora,
            'titulo' => 'O Mar de Monstros',
            'titulo_original' => 'The Sea of Monsters',
            'idioma' => 'Português',
            'isbn_10' => '0786856866',
            'isbn_13' => '9780786856862',
            'data_publicacao' => '2006-04-01',
            'sinopse' => 'Segundo volume da saga Percy Jackson e os Olimpianos, O Mar de Monstros narra as novas aventuras de Percy e seus amigos na busca do Velocino de ouro, o único artefato mágico capaz de proteger o Acampamento Meio-Sangue da destruição.',
            'total_paginas' => 279,
            'tipo_capa' => 1,
            'foto_capa' => date('YmdHis') . '.jpg',
            'status' => 1
        ]);

        $livro_2->generos()->attach([
            $genero_1->cod_genero, 
            $genero_2->cod_genero, 
            $genero_3->cod_genero
        ]);
        $livro_2->autores()->attach([
            $autor_1->cod_autor
        ]);
        $livro_2->series()->attach([
            $serie_1->cod_serie => ['numero_na_serie' => 2]
        ]);

        // Criamos livro 3
        $livro_3 = Livro::create([
            'cod_editora' => $editora_1->cod_editora,
            'titulo' => 'A Maldição do Titã',
            'titulo_original' => 'The Titan\'s Curse',
            'idioma' => 'Português',
            'isbn_10' => '0141382899',
            'isbn_13' => '9780141382890',
            'data_publicacao' => '2007-05-05',
            'sinopse' => 'Nesse terceiro livro da série, um chamado do amigo Grover deixa Percy a postos para mais uma missão: dois novos meios-sangues foram encontrados, e sua ascendência ainda é desconhecida. Como sempre, Percy sabe que precisará contar com o poder de seus aliados heróis, com sua leal espada Contracorrente... e com uma caroninha da mãe. O que eles ainda não sabem é que os jovens descobertos não são os únicos em perigo: Cronos, o Senhor dos Titãs, arquitetou um de seus planos mais traiçoeiros, e os meios-sangues estarão frente a frente com o maior desafio de suas vidas: A Maldição do Titã.',
            'total_paginas' => 320,
            'tipo_capa' => 2,
            'foto_capa' => date('YmdHis') . '.jpg',
            'status' => 1
        ]);

        $livro_3->generos()->attach([
            $genero_1->cod_genero, 
            $genero_2->cod_genero, 
            $genero_3->cod_genero
        ]);
        $livro_3->autores()->attach([
            $autor_1->cod_autor
        ]);
        $livro_3->series()->attach([
            $serie_1->cod_serie => ['numero_na_serie' => 3]
        ]);

    }



}

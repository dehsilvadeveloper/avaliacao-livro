<?php
namespace App\BusinessLayer\Actions\SeriesLivros;

use App\BusinessLayer\ResponseHttpCode;

// Importando models
use App\Models\Livro;

class VincularSeriesDeLivroAction {

    // Defino variaveis
    private $definition = 'Responsável por executar uma única tarefa';

    /**
     * 
     * Método construtor
     *
     * @access public
     * @return void
     * 
     */
    public function __construct() {

        //

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @param int $codLivro
     * @param array $series - contém IDs dos livros e dados extras de pivot
     * @return bool
     * 
     */
    public function execute(int $codLivro, array $series) : bool {

        // Busco livro
        $livro = Livro::find($codLivro);

        if (!$livro) {

            throw new \Exception('Livro não localizado', ResponseHttpCode::NOT_FOUND);

        }

        // Vinculo series ao livro
        $vinculo = $livro->series()->attach($series);

        // Retorno
        return true;

    }



}

<?php
namespace App\BusinessLayer\Actions\SeriesLivros;

use App\BusinessLayer\ResponseHttpCode;

// Importando models
use App\Models\Livro;

class SincronizarSeriesDeLivroAction {

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
     * @param array $series - contém IDs e dados extras de pivot
     * @return array
     * 
     */
    public function execute(int $codLivro, array $series) : array {

        // Busco livro
        $livro = Livro::find($codLivro);

        if (!$livro) {

            throw new \Exception('Livro não localizado', ResponseHttpCode::NOT_FOUND);

        }

        // Sincronizo series do livro
        $sincronizacao = $livro->series()->sync($series);

        // Retorno
        return $sincronizacao;

    }



}

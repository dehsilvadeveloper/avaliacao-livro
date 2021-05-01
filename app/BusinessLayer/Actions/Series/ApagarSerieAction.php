<?php
namespace App\BusinessLayer\Actions\Series;

use App\BusinessLayer\ResponseHttpCode;

// Importando models
use App\Models\Serie;

class ApagarSerieAction {

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
     * @param int $codSerie
     * @return void
     * 
     */
    public function execute(int $codSerie) : void {

        $serie = Serie::find($codSerie);

        if (!$serie) {

            throw new \Exception('Série não localizada', ResponseHttpCode::NOT_FOUND);

        }

        // Removemos relações
        $serie->livros()->detach();

        // Removemos registro
        $serie->delete();

    }



}

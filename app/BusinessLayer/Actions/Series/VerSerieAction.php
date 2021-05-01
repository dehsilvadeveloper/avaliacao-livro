<?php
namespace App\BusinessLayer\Actions\Series;

use App\BusinessLayer\ResponseHttpCode;

// Importando models
use App\Models\Serie;

class VerSerieAction {

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
     * @return object
     * 
     */
    public function execute(int $codSerie) : object {

        $serie = Serie::find($codSerie);

        if (!$serie) {

            throw new \Exception('Série não localizada', ResponseHttpCode::NOT_FOUND);

        }

        return $serie;

    }



}

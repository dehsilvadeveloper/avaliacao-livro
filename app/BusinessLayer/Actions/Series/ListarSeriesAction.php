<?php
namespace App\BusinessLayer\Actions\Series;

use App\BusinessLayer\ResponseHttpCode;

// Importando models
use App\Models\Serie;

class ListarSeriesAction {

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
     * @return object
     * 
     */
    public function execute() : object {

        $series = Serie::all();

        return $series;

    }



}

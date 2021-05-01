<?php
namespace App\BusinessLayer\Features\Series;

use App\BusinessLayer\ResponseHttpCode;

// Importo actions
use App\BusinessLayer\Actions\Series\ApagarSerieAction;

class ApagarSerieFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $apagarSerieAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param ApagarSerieAction $apagarSerieAction
     * @return void
     * 
     */
    public function __construct(ApagarSerieAction $apagarSerieAction) {

        // Instancio actions
        $this->apagarSerieAction = $apagarSerieAction;

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

        // Apago série específica
        $apagar = $this->apagarSerieAction->execute($codSerie);

    }



}

<?php
namespace App\BusinessLayer\Features\Avaliacoes;

use App\BusinessLayer\ResponseHttpCode;

// Importo actions
use App\BusinessLayer\Actions\Avaliacoes\ApagarAvaliacaoAction;

class ApagarAvaliacaoFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $apagarAvaliacaoAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param ApagarAvaliacaoAction $apagarAvaliacaoAction
     * @return void
     * 
     */
    public function __construct(ApagarAvaliacaoAction $apagarAvaliacaoAction) {

        // Instancio actions
        $this->apagarAvaliacaoAction = $apagarAvaliacaoAction;

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @param int $codAvaliacao
     * @return void
     * 
     */
    public function execute(int $codAvaliacao) : void {

        // Apago avaliação específica
        $apagar = $this->apagarAvaliacaoAction->execute($codAvaliacao);

    }



}

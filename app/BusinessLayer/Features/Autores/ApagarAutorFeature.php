<?php
namespace App\BusinessLayer\Features\Autores;

use App\BusinessLayer\ResponseHttpCode;

// Importo actions
use App\BusinessLayer\Actions\Autores\ApagarAutorAction;

class ApagarAutorFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $apagarAutorAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param ApagarAutorAction $apagarAutorAction
     * @return void
     * 
     */
    public function __construct(ApagarAutorAction $apagarAutorAction) {

        // Instancio actions
        $this->apagarAutorAction = $apagarAutorAction;

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @param int $codAutor
     * @return void
     * 
     */
    public function execute(int $codAutor) : void {

        // Apago autor específico
        $apagar = $this->apagarAutorAction->execute($codAutor);

    }



}

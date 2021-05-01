<?php
namespace App\BusinessLayer\Features\Editoras;

use App\BusinessLayer\ResponseHttpCode;

// Importo actions
use App\BusinessLayer\Actions\Editoras\ApagarEditoraAction;

class ApagarEditoraFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $apagarEditoraAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param ApagarEditoraAction $apagarEditoraAction
     * @return void
     * 
     */
    public function __construct(ApagarEditoraAction $apagarEditoraAction) {

        // Instancio actions
        $this->apagarEditoraAction = $apagarEditoraAction;

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @param int $codEditora
     * @return void
     * 
     */
    public function execute(int $codEditora) : void {

        // Apago editora específica
        $apagar = $this->apagarEditoraAction->execute($codEditora);

    }



}

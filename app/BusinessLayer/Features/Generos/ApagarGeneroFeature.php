<?php
namespace App\BusinessLayer\Features\Generos;

use App\BusinessLayer\ResponseHttpCode;

// Importo actions
use App\BusinessLayer\Actions\Generos\ApagarGeneroAction;

class ApagarGeneroFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $apagarGeneroAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param ApagarGeneroAction $apagarGeneroAction
     * @return void
     * 
     */
    public function __construct(ApagarGeneroAction $apagarGeneroAction) {

        // Instancio actions
        $this->apagarGeneroAction = $apagarGeneroAction;

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @param int $codGenero
     * @return void
     * 
     */
    public function execute(int $codGenero) : void {

        // Apago gênero específico
        $apagar = $this->apagarGeneroAction->execute($codGenero);

    }



}

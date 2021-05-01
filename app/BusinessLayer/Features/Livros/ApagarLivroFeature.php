<?php
namespace App\BusinessLayer\Features\Livros;

use App\BusinessLayer\ResponseHttpCode;

// Importo actions
use App\BusinessLayer\Actions\Livros\ApagarLivroAction;

class ApagarLivroFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $apagarLivroAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param ApagarLivroAction $apagarLivroAction
     * @return void
     * 
     */
    public function __construct(ApagarLivroAction $apagarLivroAction) {

        // Instancio actions
        $this->apagarLivroAction = $apagarLivroAction;

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @param int $codLivro
     * @return void
     * 
     */
    public function execute(int $codLivro) : void {

        // Apago livro específico
        $apagar = $this->apagarLivroAction->execute($codLivro);

    }



}

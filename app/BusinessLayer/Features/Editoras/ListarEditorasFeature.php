<?php
namespace App\BusinessLayer\Features\Editoras;

// Importo actions
use App\BusinessLayer\Actions\Editoras\ListarEditorasAction;

// Importo resources
use App\Http\Resources\EditoraCollection;

class ListarEditorasFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $listarEditorasAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param ListarEditorasAction $listarEditorasAction
     * @return void
     * 
     */
    public function __construct(ListarEditorasAction $listarEditorasAction) {

        // Instancio actions
        $this->listarEditorasAction = $listarEditorasAction;

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @return EditoraCollection
     * 
     */
    public function execute() : EditoraCollection {

        // Obtenho lista de editoras
        $editoras = $this->listarEditorasAction->execute();

        // Retorno
        return new EditoraCollection($editoras);

    }



}

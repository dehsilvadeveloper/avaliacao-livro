<?php
namespace App\BusinessLayer\Features\Editoras;

// Importo actions
use App\BusinessLayer\Actions\Editoras\VerEditoraAction;

// Importo resources
use App\Http\Resources\EditoraResource;

class VerEditoraFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $verEditoraAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param VerEditoraAction $verEditoraAction
     * @return void
     * 
     */
    public function __construct(VerEditoraAction $verEditoraAction) {

        // Instancio actions
        $this->verEditoraAction = $verEditoraAction;

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @param int $codEditora
     * @return EditoraResource
     * 
     */
    public function execute(int $codEditora) : EditoraResource {

        // Obtenho dados de editora especifica
        $editora = $this->verEditoraAction->execute($codEditora);

        // Retorno
        return new EditoraResource($editora);

    }



}

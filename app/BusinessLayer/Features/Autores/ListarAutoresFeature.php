<?php
namespace App\BusinessLayer\Features\Autores;

// Importo actions
use App\BusinessLayer\Actions\Autores\ListarAutoresAction;

// Importo resources
use App\Http\Resources\AutorCollection;

class ListarAutoresFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $listarAutoresAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param ListarAutoresAction $listarAutoresAction
     * @return void
     * 
     */
    public function __construct(ListarAutoresAction $listarAutoresAction) {

        // Instancio actions
        $this->listarAutoresAction = $listarAutoresAction;

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @return AutorCollection
     * 
     */
    public function execute() : AutorCollection {

        // Obtenho lista de autores
        $autores = $this->listarAutoresAction->execute();

        // Retorno
        return new AutorCollection($autores);

    }



}

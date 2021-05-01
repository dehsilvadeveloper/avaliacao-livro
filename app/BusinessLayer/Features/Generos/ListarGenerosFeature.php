<?php
namespace App\BusinessLayer\Features\Generos;

// Importo actions
use App\BusinessLayer\Actions\Generos\ListarGenerosAction;

// Importo resources
use App\Http\Resources\GeneroCollection;

class ListarGenerosFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $listarGenerosAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param ListarGenerosAction $listarGenerosAction
     * @return void
     * 
     */
    public function __construct(ListarGenerosAction $listarGenerosAction) {

        // Instancio actions
        $this->listarGenerosAction = $listarGenerosAction;

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @return GeneroCollection
     * 
     */
    public function execute() : GeneroCollection {

        // Obtenho lista de gêneros
        $generos = $this->listarGenerosAction->execute();

        // Retorno
        return new GeneroCollection($generos);

    }



}

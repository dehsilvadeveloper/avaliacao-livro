<?php
namespace App\BusinessLayer\Features\Autores;

// Importo actions
use App\BusinessLayer\Actions\Autores\VerAutorAction;

// Importo resources
use App\Http\Resources\AutorResource;

class VerAutorFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $verAutorAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param VerAutorAction $verAutorAction
     * @return void
     * 
     */
    public function __construct(VerAutorAction $verAutorAction) {

        // Instancio actions
        $this->verAutorAction = $verAutorAction;

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @param int $codAutor
     * @return AutorResource
     * 
     */
    public function execute(int $codAutor) : AutorResource {

        // Obtenho dados de autor especifico
        $autor = $this->verAutorAction->execute($codAutor);

        // Retorno
        return new AutorResource($autor);

    }



}

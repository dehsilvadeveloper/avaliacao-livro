<?php
namespace App\BusinessLayer\Features\Generos;

// Importo actions
use App\BusinessLayer\Actions\Generos\VerGeneroAction;

// Importo resources
use App\Http\Resources\GeneroResource;

class VerGeneroFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $verGeneroAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param VerGeneroAction $verGeneroAction
     * @return void
     * 
     */
    public function __construct(VerGeneroAction $verGeneroAction) {

        // Instancio actions
        $this->verGeneroAction = $verGeneroAction;

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @param int $codGenero
     * @return GeneroResource
     * 
     */
    public function execute(int $codGenero) : GeneroResource {

        // Obtenho dados de gênero especifico
        $genero = $this->verGeneroAction->execute($codGenero);

        // Retorno
        return new GeneroResource($genero);

    }



}

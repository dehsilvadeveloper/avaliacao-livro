<?php
namespace App\BusinessLayer\Features\Avaliacoes;

// Importo actions
use App\BusinessLayer\Actions\Avaliacoes\VerAvaliacaoAction;

// Importo resources
use App\Http\Resources\AvaliacaoResource;

class VerAvaliacaoFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $verAvaliacaoAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param VerAvaliacaoAction $verAvaliacaoAction
     * @return void
     * 
     */
    public function __construct(VerAvaliacaoAction $verAvaliacaoAction) {

        // Instancio actions
        $this->verAvaliacaoAction = $verAvaliacaoAction;

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @param int $codAvaliacao
     * @return AvaliacaoResource
     * 
     */
    public function execute(int $codAvaliacao) : AvaliacaoResource {

        // Obtenho dados de avaliação especifica
        $avaliacao = $this->verAvaliacaoAction->execute($codAvaliacao);

        // Retorno
        return new AvaliacaoResource($avaliacao);

    }



}

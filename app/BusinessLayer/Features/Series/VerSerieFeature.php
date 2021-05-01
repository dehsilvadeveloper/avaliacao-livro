<?php
namespace App\BusinessLayer\Features\Series;

// Importo actions
use App\BusinessLayer\Actions\Series\VerSerieAction;

// Importo resources
use App\Http\Resources\SerieResource;

class VerSerieFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $verSerieAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param VerSerieAction $verSerieAction
     * @return void
     * 
     */
    public function __construct(VerSerieAction $verSerieAction) {

        // Instancio actions
        $this->verSerieAction = $verSerieAction;

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @param int $codSerie
     * @return SerieResource
     * 
     */
    public function execute(int $codSerie) : SerieResource {

        // Obtenho dados de série especifica
        $serie = $this->verSerieAction->execute($codSerie);

        // Retorno
        return new SerieResource($serie);

    }



}

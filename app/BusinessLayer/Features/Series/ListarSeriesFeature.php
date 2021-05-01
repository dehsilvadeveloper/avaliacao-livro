<?php
namespace App\BusinessLayer\Features\Series;

// Importo actions
use App\BusinessLayer\Actions\Series\ListarSeriesAction;

// Importo resources
use App\Http\Resources\SerieCollection;

class ListarSeriesFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $listarSeriesAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param ListarSeriesAction $listarSeriesAction
     * @return void
     * 
     */
    public function __construct(ListarSeriesAction $listarSeriesAction) {

        // Instancio actions
        $this->ListarSeriesAction = $listarSeriesAction;

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @return SerieCollection
     * 
     */
    public function execute() : SerieCollection {

        // Obtenho lista de séries
        $series = $this->ListarSeriesAction->execute();

        // Retorno
        return new SerieCollection($series);

    }



}

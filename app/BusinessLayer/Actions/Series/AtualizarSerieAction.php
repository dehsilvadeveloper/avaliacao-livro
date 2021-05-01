<?php
namespace App\BusinessLayer\Actions\Series;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\AtualizarSerieDTO;

// Importando models
use App\Models\Serie;

class AtualizarSerieAction {

    // Defino variaveis
    private $definition = 'Responsável por executar uma única tarefa';

    /**
     * 
     * Método construtor
     *
     * @access public
     * @return void
     * 
     */
    public function __construct() {

        //

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @param int $codSerie
     * @param AtualizarSerieDTO $atualizarSerieDTO
     * @return object
     * 
     */
    public function execute(int $codSerie, AtualizarSerieDTO $atualizarSerieDTO) : object {

        // Converto objeto para array
        $dados = $atualizarSerieDTO->toArray();

        // Localizo série
        $serie = Serie::find($codSerie);

        if (!$serie) {

            throw new \Exception('Série não localizada', ResponseHttpCode::NOT_FOUND);

        }

        // Atualizo dados
        $serie->update($dados);

        // Recarrego model antes de retornarmos o mesmo para que possamos notar as atualizações
        $serie->refresh();

        return $serie;

    }



}

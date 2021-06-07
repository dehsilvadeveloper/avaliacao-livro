<?php
namespace App\BusinessLayer\Actions\Series;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\AtualizarSerieDto;

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
     * @param AtualizarSerieDto $atualizarSerieDto
     * @return object
     * 
     */
    public function execute(AtualizarSerieDto $atualizarSerieDto) : object {

        // Converto objeto para array
        $dados = $atualizarSerieDto->toArray();

        // Localizo série
        $serie = Serie::find($dados['cod_serie']);

        if (!$serie) {

            throw new \Exception('Série não localizada', ResponseHttpCode::NOT_FOUND);

        }

        // Não precisamos mais do código, então o removemos
        unset($dados['cod_serie']);

        // Atualizo dados
        $serie->update($dados);

        // Recarrego model antes de retornarmos o mesmo para que possamos notar as atualizações
        $serie->refresh();

        return $serie;

    }



}

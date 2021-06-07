<?php
namespace App\BusinessLayer\Actions\Avaliacoes;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\AtualizarAvaliacaoDto;

// Importando models
use App\Models\Avaliacao;

class AtualizarAvaliacaoAction {

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
     * @param AtualizarAvaliacaoDto $atualizarAvaliacaoDto
     * @return object
     * 
     */
    public function execute(AtualizarAvaliacaoDto $atualizarAvaliacaoDto) : object {

        // Converto objeto para array
        $dados = $atualizarAvaliacaoDto->toArray();

        // Localizo avaliação
        $avaliacao = Avaliacao::find($dados['cod_avaliacao']);

        if (!$avaliacao) {

            throw new \Exception('Avaliação não localizada', ResponseHttpCode::NOT_FOUND);

        }

        // Não precisamos mais do código, então o removemos
        unset($dados['cod_avaliacao']);

        // Atualizo dados
        $avaliacao->update($dados);

        // Recarrego model antes de retornarmos o mesmo para que possamos notar as atualizações
        $avaliacao->refresh();

        return $avaliacao;

    }



}

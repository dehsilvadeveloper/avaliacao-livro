<?php
namespace App\BusinessLayer\Actions\Avaliacoes;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\AtualizarAvaliacaoDTO;

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
     * @param int $codAvaliacao
     * @param AtualizarAvaliacaoDTO $atualizarAvaliacaoDTO
     * @return object
     * 
     */
    public function execute(int $codAvaliacao, AtualizarAvaliacaoDTO $atualizarAvaliacaoDTO) : object {

        // Converto objeto para array
        $dados = $atualizarAvaliacaoDTO->toArray();

        // Localizo avaliação
        $avaliacao = Avaliacao::find($codAvaliacao);

        if (!$avaliacao) {

            throw new \Exception('Avaliação não localizada', ResponseHttpCode::NOT_FOUND);

        }

        // Atualizo dados
        $avaliacao->update($dados);

        // Recarrego model antes de retornarmos o mesmo para que possamos notar as atualizações
        $avaliacao->refresh();

        return $avaliacao;

    }



}

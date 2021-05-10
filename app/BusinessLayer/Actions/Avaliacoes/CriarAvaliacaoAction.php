<?php
namespace App\BusinessLayer\Actions\Avaliacoes;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\CriarAvaliacaoDTO;

// Importando models
use App\Models\Avaliacao;

class CriarAvaliacaoAction {

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
     * @param CriarAvaliacaoDTO $criarAvaliacaoDTO
     * @return object
     * 
     */
    public function execute(CriarAvaliacaoDTO $criarAvaliacaoDTO) : object {

        // Converto objeto para array
        $dados = $criarAvaliacaoDTO->toArray();

        // Inserção do registro
        $avaliacao = Avaliacao::create($dados);

        return $avaliacao;

    }



}

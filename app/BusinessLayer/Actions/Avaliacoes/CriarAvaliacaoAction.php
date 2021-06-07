<?php
namespace App\BusinessLayer\Actions\Avaliacoes;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\CriarAvaliacaoDto;

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
     * @param CriarAvaliacaoDto $criarAvaliacaoDto
     * @return object
     * 
     */
    public function execute(CriarAvaliacaoDto $criarAvaliacaoDto) : object {

        // Converto objeto para array
        $dados = $criarAvaliacaoDto->toArray();

        // Inserção do registro
        $avaliacao = Avaliacao::create($dados);

        return $avaliacao;

    }



}

<?php
namespace App\BusinessLayer\Actions\Avaliacoes;

use App\BusinessLayer\ResponseHttpCode;

// Importando models
use App\Models\Avaliacao;

class ApagarAvaliacaoAction {

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
     * @return void
     * 
     */
    public function execute(int $codAvaliacao) : void {

        $avaliacao = Avaliacao::find($codAvaliacao);

        if (!$avaliacao) {

            throw new \Exception('Avaliação não localizada', ResponseHttpCode::NOT_FOUND);

        }

        // Removemos registro
        $avaliacao->delete();

    }



}

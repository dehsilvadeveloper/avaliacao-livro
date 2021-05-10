<?php
namespace App\BusinessLayer\Actions\Avaliacoes;

use App\BusinessLayer\ResponseHttpCode;

// Importando models
use App\Models\Avaliacao;

class ListarAvaliacoesDeLivroAction {

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
     * @param int $codLivro
     * @return object
     * 
     */
    public function execute(int $codLivro) : object {

        $avaliacoes = Avaliacao::where('cod_livro', '=', $codLivro)->get();

        return $avaliacoes;

    }



}

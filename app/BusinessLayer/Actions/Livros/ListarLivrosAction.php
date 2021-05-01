<?php
namespace App\BusinessLayer\Actions\Livros;

use App\BusinessLayer\ResponseHttpCode;

// Importando models
use App\Models\Livro;

class ListarLivrosAction {

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
     * @return object
     * 
     */
    public function execute() : object {

        $livros = Livro::with(['autores', 'generos', 'series'])
                       //->withCount('avaliacoes')
                       ->get();

        return $livros;

    }



}

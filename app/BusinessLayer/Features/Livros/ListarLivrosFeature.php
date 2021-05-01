<?php
namespace App\BusinessLayer\Features\Livros;

// Importo actions
use App\BusinessLayer\Actions\Livros\ListarLivrosAction;

// Importo resources
use App\Http\Resources\LivroCollection;

class ListarLivrosFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $listarLivrosAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param ListarLivrosAction $listarLivrosAction
     * @return void
     * 
     */
    public function __construct(ListarLivrosAction $listarLivrosAction) {

        // Instancio actions
        $this->ListarLivrosAction = $listarLivrosAction;

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @return LivroCollection
     * 
     */
    public function execute() : LivroCollection {

        // Obtenho lista de livros
        $livros = $this->ListarLivrosAction->execute();

        // Retorno
        return new LivroCollection($livros);

    }



}

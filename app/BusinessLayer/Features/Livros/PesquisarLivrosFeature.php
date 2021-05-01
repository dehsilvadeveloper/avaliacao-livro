<?php
namespace App\BusinessLayer\Features\Livros;

// Importo actions
use App\BusinessLayer\Actions\Livros\PesquisarLivrosAction;

class PesquisarLivrosFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $pesquisarLivrosAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param PesquisarLivrosAction $pesquisarLivrosAction
     * @return void
     * 
     */
    public function __construct(
        PesquisarLivrosAction $pesquisarLivrosAction
    ) {

        // Instancio actions
        $this->PesquisarLivrosAction = $pesquisarLivrosAction;

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @param array $dadosParaCriterio
     * @return object
     * 
     */
    public function execute(array $dadosParaCriterio) : object {

        /* Usar $dadosParaCriterio ao montar array criterio */

        // Monto critérios da pesquisa
        $criterio[] = array('titulo', '=', 'Harry Potter');
        $criterio[] = array('total_paginas', '>', 2000);

        // Pesquisa por livros utilizando critério informado
        $livros = $this->PesquisarLivrosAction->execute($criterio);

        // Retorno
        return $livros;

    }



}

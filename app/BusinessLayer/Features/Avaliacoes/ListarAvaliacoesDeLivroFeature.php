<?php
namespace App\BusinessLayer\Features\Avaliacoes;

// Importo actions
use App\BusinessLayer\Actions\Avaliacoes\ListarAvaliacoesDeLivroAction;

// Importo resources
use App\Http\Resources\AvaliacaoCollection;

class ListarAvaliacoesDeLivroFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $listarAvaliacoesDeLivroAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param ListarAvaliacoesDeLivroAction $listarAvaliacoesDeLivroAction
     * @return void
     * 
     */
    public function __construct(ListarAvaliacoesDeLivroAction $listarAvaliacoesDeLivroAction) {

        // Instancio actions
        $this->listarAvaliacoesDeLivroAction = $listarAvaliacoesDeLivroAction;

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @param int $codLivro
     * @return AvaliacaoCollection
     * 
     */
    public function execute(int $codLivro) : AvaliacaoCollection {

        // Obtenho lista de avaliações de um determinado livro
        $avaliacoes = $this->listarAvaliacoesDeLivroAction->execute($codLivro);

        // Retorno
        return new AvaliacaoCollection($avaliacoes);

    }



}

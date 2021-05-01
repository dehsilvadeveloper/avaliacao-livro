<?php
namespace App\BusinessLayer\Features\Livros;

// Importo actions
use App\BusinessLayer\Actions\Livros\VerLivroAction;

// Importo resources
use App\Http\Resources\LivroResource;

class VerLivroFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $verLivroAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param VerLivroAction $verLivroAction
     * @return void
     * 
     */
    public function __construct(
        VerLivroAction $verLivroAction
    ) {

        // Instancio actions
        $this->verLivroAction = $verLivroAction;

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @param int $codLivro
     * @return LivroResource
     * 
     */
    public function execute(int $codLivro) : LivroResource {

        // Obtenho dados de livro especifico
        $livro = $this->verLivroAction->execute($codLivro);

        // Retorno
        return new LivroResource($livro);

    }



}

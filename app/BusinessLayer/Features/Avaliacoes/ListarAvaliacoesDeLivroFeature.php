<?php
namespace App\BusinessLayer\Features\Avaliacoes;

use App\BusinessLayer\ResponseHttpCode;
use App\Exceptions\CamposObrigatoriosInvalidosException;

// Importo DTOs
use App\DataLayer\DTOs\ListarAvaliacoesDeLivroDto;

// Importo validators
use App\BusinessLayer\Validators\Avaliacoes\ListarAvaliacoesDeLivroValidator;

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
     * @param ListarAvaliacoesDeLivroDto $listarAvaliacoesDeLivroDto
     * @return array
     * 
     */
    public function execute(ListarAvaliacoesDeLivroDto $listarAvaliacoesDeLivroDto) : array {

        // Converto objeto para array
        $dados = $listarAvaliacoesDeLivroDto->toArray();

        // Validação de dados obrigatórios
        $validador = new ListarAvaliacoesDeLivroValidator;
        $validador->execute($dados);

        // Caso os dados NÃO SEJAM válidos
        if (!$validador->estaLiberado()) {

            // Erro de validação
            throw new CamposObrigatoriosInvalidosException(
                'Dados informados são inválidos', 
                $validador->pegarErros()
            );

        }
        
        // Obtenho lista de avaliações de um determinado livro
        $avaliacoes = $this->listarAvaliacoesDeLivroAction->execute($listarAvaliacoesDeLivroDto);

        // Retorno
        // Em caso de necessidade de paginação, caso esteja usando apenas collection, os dados são retornados sem informações de paginação (total de paginas, página atual, etc). 
        // Para incluir informações da paginação na resposta usamos getData() junto da collection.
        return (new AvaliacaoCollection($avaliacoes))->response()->getData(true);

    }



}

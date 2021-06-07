<?php
namespace App\BusinessLayer\Features\Livros;

use App\BusinessLayer\ResponseHttpCode;
use App\Exceptions\CamposObrigatoriosInvalidosException;

// Importo DTOs
use App\DataLayer\DTOs\ListarLivrosDto;

// Importo validators
use App\BusinessLayer\Validators\Livros\ListarLivrosValidator;

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
     * @param ListarLivrosDto $listarLivrosDto
     * @return array
     * 
     */
    public function execute(ListarLivrosDto $listarLivrosDto) : array {

        // Converto objeto para array
        $dados = $listarLivrosDto->toArray();

        // Validação de dados obrigatórios
        $validador = new ListarLivrosValidator;
        $validador->execute($dados);

        // Caso os dados NÃO SEJAM válidos
        if (!$validador->estaLiberado()) {

            // Erro de validação
            throw new CamposObrigatoriosInvalidosException(
                'Dados informados são inválidos', 
                $validador->pegarErros()
            );

        }

        // Obtenho lista de livros
        $livros = $this->ListarLivrosAction->execute($listarLivrosDto);

        // Retorno
        // Em caso de necessidade de paginação, caso esteja usando apenas collection, os dados são retornados sem informações de paginação (total de paginas, página atual, etc). 
        // Para incluir informações da paginação na resposta usamos getData() junto da collection.
        return (new LivroCollection($livros))->response()->getData(true);

    }



}

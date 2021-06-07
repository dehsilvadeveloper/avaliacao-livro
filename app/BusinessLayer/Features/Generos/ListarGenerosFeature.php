<?php
namespace App\BusinessLayer\Features\Generos;

use App\BusinessLayer\ResponseHttpCode;
use App\Exceptions\CamposObrigatoriosInvalidosException;

// Importo DTOs
use App\DataLayer\DTOs\ListarGenerosDto;

// Importo validators
use App\BusinessLayer\Validators\Generos\ListarGenerosValidator;

// Importo actions
use App\BusinessLayer\Actions\Generos\ListarGenerosAction;

// Importo resources
use App\Http\Resources\GeneroCollection;

class ListarGenerosFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $listarGenerosAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param ListarGenerosAction $listarGenerosAction
     * @return void
     * 
     */
    public function __construct(ListarGenerosAction $listarGenerosAction) {

        // Instancio actions
        $this->listarGenerosAction = $listarGenerosAction;

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @param ListarGenerosDto $listarGenerosDto
     * @return array
     * 
     */
    public function execute(ListarGenerosDto $listarGenerosDto) : array {

        // Converto objeto para array
        $dados = $listarGenerosDto->toArray();

        // Validação de dados obrigatórios
        $validador = new ListarGenerosValidator;
        $validador->execute($dados);

        // Caso os dados NÃO SEJAM válidos
        if (!$validador->estaLiberado()) {

            // Erro de validação
            throw new CamposObrigatoriosInvalidosException(
                'Dados informados são inválidos', 
                $validador->pegarErros()
            );

        }

        // Obtenho lista de gêneros
        $generos = $this->listarGenerosAction->execute($listarGenerosDto);

        // Retorno
        // Em caso de necessidade de paginação, caso esteja usando apenas collection, os dados são retornados sem informações de paginação (total de paginas, página atual, etc). 
        // Para incluir informações da paginação na resposta usamos getData() junto da collection.
        return (new GeneroCollection($generos))->response()->getData(true);

    }



}

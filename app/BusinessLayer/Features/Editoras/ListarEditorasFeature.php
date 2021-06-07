<?php
namespace App\BusinessLayer\Features\Editoras;

use App\BusinessLayer\ResponseHttpCode;
use App\Exceptions\CamposObrigatoriosInvalidosException;

// Importo DTOs
use App\DataLayer\DTOs\ListarEditorasDto;

// Importo validators
use App\BusinessLayer\Validators\Editoras\ListarEditorasValidator;

// Importo actions
use App\BusinessLayer\Actions\Editoras\ListarEditorasAction;

// Importo resources
use App\Http\Resources\EditoraCollection;

class ListarEditorasFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $listarEditorasAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param ListarEditorasAction $listarEditorasAction
     * @return void
     * 
     */
    public function __construct(ListarEditorasAction $listarEditorasAction) {

        // Instancio actions
        $this->listarEditorasAction = $listarEditorasAction;

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @param ListarEditorasDto $listarEditorasDto
     * @return array
     * 
     */
    public function execute(ListarEditorasDto $listarEditorasDto) : array {

        // Converto objeto para array
        $dados = $listarEditorasDto->toArray();

        // Validação de dados obrigatórios
        $validador = new ListarEditorasValidator;
        $validador->execute($dados);

        // Caso os dados NÃO SEJAM válidos
        if (!$validador->estaLiberado()) {

            // Erro de validação
            throw new CamposObrigatoriosInvalidosException(
                'Dados informados são inválidos', 
                $validador->pegarErros()
            );

        }

        // Obtenho lista de editoras
        $editoras = $this->listarEditorasAction->execute($listarEditorasDto);

        // Retorno
        // Em caso de necessidade de paginação, caso esteja usando apenas collection, os dados são retornados sem informações de paginação (total de paginas, página atual, etc). 
        // Para incluir informações da paginação na resposta usamos getData() junto da collection.
        return (new EditoraCollection($editoras))->response()->getData(true);

    }



}

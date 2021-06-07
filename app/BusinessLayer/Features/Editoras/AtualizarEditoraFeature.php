<?php
namespace App\BusinessLayer\Features\Editoras;

use App\BusinessLayer\ResponseHttpCode;
use App\Exceptions\CamposObrigatoriosInvalidosException;

// Importo DTOs
use App\DataLayer\DTOs\AtualizarEditoraDto;

// Importo validators
use App\BusinessLayer\Validators\Editoras\AtualizarEditoraValidator;

// Importo actions
use App\BusinessLayer\Actions\Editoras\AtualizarEditoraAction;

// Importo resources
use App\Http\Resources\EditoraResource;

class AtualizarEditoraFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $atualizarEditoraAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param AtualizarEditoraAction $atualizarEditoraAction
     * @return void
     * 
     */
    public function __construct(AtualizarEditoraAction $atualizarEditoraAction) {

        // Instancio actions
        $this->atualizarEditoraAction = $atualizarEditoraAction;

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @param AtualizarEditoraDto $atualizarEditoraDto
     * @return EditoraResource
     * 
     */
    public function execute(AtualizarEditoraDto $atualizarEditoraDto) : EditoraResource {

        // Converto objeto para array
        $dados = $atualizarEditoraDto->toArray();

        // Validação de dados obrigatórios
        $validador = new AtualizarEditoraValidator;
        $validador->execute($dados['cod_editora'], $dados);

        // Caso os dados NÃO SEJAM válidos
        if (!$validador->estaLiberado()) {

            // Erro de validação
            throw new CamposObrigatoriosInvalidosException(
                'Dados informados são inválidos', 
                $validador->pegarErros()
            );

        }

        // Atualizo informações da editora
        $editora = $this->atualizarEditoraAction->execute($atualizarEditoraDto);

        // Retorno
        return new EditoraResource($editora);

    }



}

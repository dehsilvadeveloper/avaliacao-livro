<?php
namespace App\BusinessLayer\Features\Editoras;

use App\BusinessLayer\ResponseHttpCode;
use App\Exceptions\CamposObrigatoriosInvalidosException;

// Importo DTOs
use App\DataLayer\DTOs\CriarEditoraDTO;

// Importo validators
use App\BusinessLayer\Validators\Editoras\CriarEditoraValidator;

// Importo actions
use App\BusinessLayer\Actions\Editoras\CriarEditoraAction;

// Importo resources
use App\Http\Resources\EditoraResource;

class CriarEditoraFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $criarEditoraAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param CriarEditoraAction $criarEditoraAction
     * @return void
     * 
     */
    public function __construct(CriarEditoraAction $criarEditoraAction) {

        // Instancio actions
        $this->criarEditoraAction = $criarEditoraAction;

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @param CriarEditoraDTO $criarEditoraDto
     * @return EditoraResource
     * 
     */
    public function execute(CriarEditoraDTO $criarEditoraDto) : EditoraResource {

        // Converto objeto para array
        $dados = $criarEditoraDto->toArray();

        // Validação de dados obrigatórios
        $validador = new CriarEditoraValidator;
        $validador->execute($dados);

        // Caso os dados NÃO SEJAM válidos
        if (!$validador->estaLiberado()) {

            // Erro de validação
            throw new CamposObrigatoriosInvalidosException(
                'Dados informados são inválidos', 
                $validador->pegarErros()
            );

        }

        // Crio nova editora
        $editora = $this->criarEditoraAction->execute($criarEditoraDto);

        // Retorno
        return new EditoraResource($editora);

    }



}

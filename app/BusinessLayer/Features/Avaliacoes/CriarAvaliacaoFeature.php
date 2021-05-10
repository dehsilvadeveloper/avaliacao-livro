<?php
namespace App\BusinessLayer\Features\Avaliacoes;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\CriarAvaliacaoDTO;

// Importo validators
use App\BusinessLayer\Validators\Avaliacoes\CriarAvaliacaoValidator;

// Importo actions
use App\BusinessLayer\Actions\Avaliacoes\CriarAvaliacaoAction;

// Importo resources
use App\Http\Resources\AvaliacaoResource;

class CriarAvaliacaoFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $criarAvaliacaoAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param CriarAvaliacaoAction $criarAvaliacaoAction
     * @return void
     * 
     */
    public function __construct(CriarAvaliacaoAction $criarAvaliacaoAction) {

        // Instancio actions
        $this->criarAvaliacaoAction = $criarAvaliacaoAction;

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @param CriarAvaliacaoDto $criarAvaliacaoDto
     * @return AvaliacaoResource
     * 
     */
    public function execute(CriarAvaliacaoDto $criarAvaliacaoDto) : AvaliacaoResource {

        // Converto objeto para array
        $dados = $criarAvaliacaoDto->toArray();

        // Validação de dados obrigatórios
        $validador = new CriarAvaliacaoValidator;
        $validador->execute($dados);

        // Caso os dados NÃO SEJAM válidos
        if (!$validador->estaLiberado()) {

            // Erro de validação
            throw new \InvalidArgumentException(
                $validador->pegarErros(),
                ResponseHttpCode::DATA_VALIDATION_FAILED
            );

        }

        // Crio nova avaliação
        $avaliacao = $this->criarAvaliacaoAction->execute($criarAvaliacaoDto);

        // Retorno
        return new AvaliacaoResource($avaliacao);

    }



}

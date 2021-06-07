<?php
namespace App\BusinessLayer\Features\Avaliacoes;

use App\BusinessLayer\ResponseHttpCode;
use App\Exceptions\CamposObrigatoriosInvalidosException;

// Importo DTOs
use App\DataLayer\DTOs\AtualizarAvaliacaoDto;

// Importo validators
use App\BusinessLayer\Validators\Avaliacoes\AtualizarAvaliacaoValidator;

// Importo actions
use App\BusinessLayer\Actions\Avaliacoes\AtualizarAvaliacaoAction;

// Importo resources
use App\Http\Resources\AvaliacaoResource;

class AtualizarAvaliacaoFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $atualizarAvaliacaoAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param AtualizarAvaliacaoAction $atualizarAvaliacaoAction
     * @return void
     * 
     */
    public function __construct(AtualizarAvaliacaoAction $atualizarAvaliacaoAction) {

        // Instancio actions
        $this->atualizarAvaliacaoAction = $atualizarAvaliacaoAction;

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @param AtualizarAvaliacaoDto $atualizarAvaliacaoDto
     * @return AvaliacaoResource
     * 
     */
    public function execute(AtualizarAvaliacaoDto $atualizarAvaliacaoDto) : AvaliacaoResource {

        // Converto objeto para array
        $dados = $atualizarAvaliacaoDto->toArray();

        // Validação de dados obrigatórios
        $validador = new AtualizarAvaliacaoValidator;
        $validador->execute($dados['cod_avaliacao'], $dados);

        // Caso os dados NÃO SEJAM válidos
        if (!$validador->estaLiberado()) {

            // Erro de validação
            throw new CamposObrigatoriosInvalidosException(
                'Dados informados são inválidos', 
                $validador->pegarErros()
            );

        }

        // Atualizo informações da avaliação
        $avaliacao = $this->atualizarAvaliacaoAction->execute($atualizarAvaliacaoDto);

        // Retorno
        return new AvaliacaoResource($avaliacao);

    }



}

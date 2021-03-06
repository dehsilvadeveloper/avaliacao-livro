<?php
namespace App\BusinessLayer\Features\Generos;

use App\BusinessLayer\ResponseHttpCode;
use App\Exceptions\CamposObrigatoriosInvalidosException;

// Importo DTOs
use App\DataLayer\DTOs\AtualizarGeneroDto;

// Importo validators
use App\BusinessLayer\Validators\Generos\AtualizarGeneroValidator;

// Importo actions
use App\BusinessLayer\Actions\Generos\AtualizarGeneroAction;

// Importo resources
use App\Http\Resources\GeneroResource;

class AtualizarGeneroFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $atualizarGeneroAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param AtualizarGeneroAction $atualizarGeneroAction
     * @return void
     * 
     */
    public function __construct(AtualizarGeneroAction $atualizarGeneroAction) {

        // Instancio actions
        $this->atualizarGeneroAction = $atualizarGeneroAction;

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @param AtualizarGeneroDto $atualizarGeneroDto
     * @return GeneroResource
     * 
     */
    public function execute(AtualizarGeneroDto $atualizarGeneroDto) : GeneroResource {

        // Converto objeto para array
        $dados = $atualizarGeneroDto->toArray();

        // Validação de dados obrigatórios
        $validador = new AtualizarGeneroValidator;
        $validador->execute($dados['cod_genero'], $dados);

        // Caso os dados NÃO SEJAM válidos
        if (!$validador->estaLiberado()) {

            // Erro de validação
            throw new CamposObrigatoriosInvalidosException(
                'Dados informados são inválidos', 
                $validador->pegarErros()
            );

        }

        // Atualizo informações do gênero
        $genero = $this->atualizarGeneroAction->execute($atualizarGeneroDto);

        // Retorno
        return new GeneroResource($genero);

    }



}

<?php
namespace App\BusinessLayer\Features\Generos;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\AtualizarGeneroDTO;

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
     * @param int $codGenero
     * @param AtualizarGeneroDTO $atualizarGeneroDto
     * @return GeneroResource
     * 
     */
    public function execute(int $codGenero, AtualizarGeneroDTO $atualizarGeneroDto) : GeneroResource {

        // Converto objeto para array
        $dados = $atualizarGeneroDto->toArray();

        // Validação de dados obrigatórios
        $validador = new AtualizarGeneroValidator;
        $validador->execute($codGenero, $dados);

        // Caso os dados NÃO SEJAM válidos
        if (!$validador->estaLiberado()) {

            // Erro de validação
            throw new \InvalidArgumentException(
                $validador->pegarErros(),
                ResponseHttpCode::DATA_VALIDATION_FAILED
            );

        }

        // Atualizo informações do gênero
        $genero = $this->atualizarGeneroAction->execute($codGenero, $atualizarGeneroDto);

        // Retorno
        return new GeneroResource($genero);

    }



}

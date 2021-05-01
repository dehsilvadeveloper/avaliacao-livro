<?php
namespace App\BusinessLayer\Features\Generos;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\CriarGeneroDTO;

// Importo validators
use App\BusinessLayer\Validators\Generos\CriarGeneroValidator;

// Importo actions
use App\BusinessLayer\Actions\Generos\CriarGeneroAction;

// Importo resources
use App\Http\Resources\GeneroResource;

class CriarGeneroFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $criarGeneroAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param CriarGeneroAction $criarGeneroAction
     * @return void
     * 
     */
    public function __construct(CriarGeneroAction $criarGeneroAction) {

        // Instancio actions
        $this->criarGeneroAction = $criarGeneroAction;

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @param CriarGeneroDTO $criarGeneroDto
     * @return GeneroResource
     * 
     */
    public function execute(CriarGeneroDTO $criarGeneroDto) : GeneroResource {

        // Converto objeto para array
        $dados = $criarGeneroDto->toArray();

        // Validação de dados obrigatórios
        $validador = new CriarGeneroValidator;
        $validador->execute($dados);

        // Caso os dados NÃO SEJAM válidos
        if (!$validador->estaLiberado()) {

            // Erro de validação
            throw new \InvalidArgumentException(
                $validador->pegarErros(),
                ResponseHttpCode::DATA_VALIDATION_FAILED
            );

        }

        // Crio novo gênero
        $genero = $this->criarGeneroAction->execute($criarGeneroDto);

        // Retorno
        return new GeneroResource($genero);

    }



}
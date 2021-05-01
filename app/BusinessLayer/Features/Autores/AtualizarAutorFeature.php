<?php
namespace App\BusinessLayer\Features\Autores;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\AtualizarAutorDTO;

// Importo validators
use App\BusinessLayer\Validators\Autores\AtualizarAutorValidator;

// Importo actions
use App\BusinessLayer\Actions\Autores\AtualizarAutorAction;

// Importo resources
use App\Http\Resources\AutorResource;

class AtualizarAutorFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $atualizarAutorAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param AtualizarAutorAction $atualizarAutorAction
     * @return void
     * 
     */
    public function __construct(AtualizarAutorAction $atualizarAutorAction) {

        // Instancio actions
        $this->atualizarAutorAction = $atualizarAutorAction;

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @param int $codAutor
     * @param AtualizarAutorDTO $atualizarAutorDto
     * @return AutorResource
     * 
     */
    public function execute(int $codAutor, AtualizarAutorDTO $atualizarAutorDto) : AutorResource {

        // Converto objeto para array
        $dados = $atualizarAutorDto->toArray();

        // Validação de dados obrigatórios
        $validador = new AtualizarAutorValidator;
        $validador->execute($codAutor, $dados);

        // Caso os dados NÃO SEJAM válidos
        if (!$validador->estaLiberado()) {

            // Erro de validação
            throw new \InvalidArgumentException(
                $validador->pegarErros(),
                ResponseHttpCode::DATA_VALIDATION_FAILED
            );

        }

        // Atualizo informações do autor
        $autor = $this->atualizarAutorAction->execute($codAutor, $atualizarAutorDto);

        // Retorno
        return new AutorResource($autor);

    }



}

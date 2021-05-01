<?php
namespace App\BusinessLayer\Features\Autores;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\CriarAutorDTO;

// Importo validators
use App\BusinessLayer\Validators\Autores\CriarAutorValidator;

// Importo actions
use App\BusinessLayer\Actions\Autores\CriarAutorAction;

// Importo resources
use App\Http\Resources\AutorResource;

class CriarAutorFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $criarAutorAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param CriarAutorAction $criarAutorAction
     * @return void
     * 
     */
    public function __construct(CriarAutorAction $criarAutorAction) {

        // Instancio actions
        $this->criarAutorAction = $criarAutorAction;

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @param CriarAutorDTO $criarAutorDto
     * @return AutorResource
     * 
     */
    public function execute(CriarAutorDTO $criarAutorDto) : AutorResource {

        // Converto objeto para array
        $dados = $criarAutorDto->toArray();

        // Validação de dados obrigatórios
        $validador = new CriarAutorValidator;
        $validador->execute($dados);

        // Caso os dados NÃO SEJAM válidos
        if (!$validador->estaLiberado()) {

            // Erro de validação
            throw new \InvalidArgumentException(
                $validador->pegarErros(),
                ResponseHttpCode::DATA_VALIDATION_FAILED
            );

        }

        // Crio novo autor
        $autor = $this->criarAutorAction->execute($criarAutorDto);

        // Retorno
        return new AutorResource($autor);

    }



}

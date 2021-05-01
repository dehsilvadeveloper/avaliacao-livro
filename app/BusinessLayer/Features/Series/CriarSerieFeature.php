<?php
namespace App\BusinessLayer\Features\Series;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\CriarSerieDTO;

// Importo validators
use App\BusinessLayer\Validators\Series\CriarSerieValidator;

// Importo actions
use App\BusinessLayer\Actions\Series\CriarSerieAction;

// Importo resources
use App\Http\Resources\SerieResource;

class CriarSerieFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $criarSerieAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param CriarSerieAction $criarSerieAction
     * @return void
     * 
     */
    public function __construct(CriarSerieAction $criarSerieAction) {

        // Instancio actions
        $this->criarSerieAction = $criarSerieAction;

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @param CriarSerieDTO $criarSerieDto
     * @return SerieResource
     * 
     */
    public function execute(CriarSerieDTO $criarSerieDto) : SerieResource {

        // Converto objeto para array
        $dados = $criarSerieDto->toArray();

        // Validação de dados obrigatórios
        $validador = new CriarSerieValidator;
        $validador->execute($dados);

        // Caso os dados NÃO SEJAM válidos
        if (!$validador->estaLiberado()) {

            // Erro de validação
            throw new \InvalidArgumentException(
                $validador->pegarErros(),
                ResponseHttpCode::DATA_VALIDATION_FAILED
            );

        }

        // Crio nova série
        $serie = $this->criarSerieAction->execute($criarSerieDto);

        // Retorno
        return new SerieResource($serie);

    }



}

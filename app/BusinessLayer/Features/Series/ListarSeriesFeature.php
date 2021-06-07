<?php
namespace App\BusinessLayer\Features\Series;

use App\BusinessLayer\ResponseHttpCode;
use App\Exceptions\CamposObrigatoriosInvalidosException;

// Importo DTOs
use App\DataLayer\DTOs\ListarSeriesDto;

// Importo validators
use App\BusinessLayer\Validators\Series\ListarSeriesValidator;

// Importo actions
use App\BusinessLayer\Actions\Series\ListarSeriesAction;

// Importo resources
use App\Http\Resources\SerieCollection;

class ListarSeriesFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $listarSeriesAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param ListarSeriesAction $listarSeriesAction
     * @return void
     * 
     */
    public function __construct(ListarSeriesAction $listarSeriesAction) {

        // Instancio actions
        $this->ListarSeriesAction = $listarSeriesAction;

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @param ListarSeriesDto $listarSeriesDto
     * @return array
     * 
     */
    public function execute(ListarSeriesDto $listarSeriesDto) : array {

        // Converto objeto para array
        $dados = $listarSeriesDto->toArray();

        // Validação de dados obrigatórios
        $validador = new ListarSeriesValidator;
        $validador->execute($dados);

        // Caso os dados NÃO SEJAM válidos
        if (!$validador->estaLiberado()) {

            // Erro de validação
            throw new CamposObrigatoriosInvalidosException(
                'Dados informados são inválidos', 
                $validador->pegarErros()
            );

        }

        // Obtenho lista de séries
        $series = $this->ListarSeriesAction->execute($listarSeriesDto);

        // Retorno
        // Em caso de necessidade de paginação, caso esteja usando apenas collection, os dados são retornados sem informações de paginação (total de paginas, página atual, etc). 
        // Para incluir informações da paginação na resposta usamos getData() junto da collection.
        return (new SerieCollection($series))->response()->getData(true);

    }



}

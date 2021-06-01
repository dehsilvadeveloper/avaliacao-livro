<?php
namespace App\BusinessLayer\Features\Series;

use App\BusinessLayer\ResponseHttpCode;
use App\Exceptions\CamposObrigatoriosInvalidosException;

// Importo DTOs
use App\DataLayer\DTOs\AtualizarSerieDTO;

// Importo validators
use App\BusinessLayer\Validators\Series\AtualizarSerieValidator;

// Importo actions
use App\BusinessLayer\Actions\Series\AtualizarSerieAction;

// Importo resources
use App\Http\Resources\SerieResource;

class AtualizarSerieFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $atualizarSerieAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param AtualizarSerieAction $atualizarSerieAction
     * @return void
     * 
     */
    public function __construct(AtualizarSerieAction $atualizarSerieAction) {

        // Instancio actions
        $this->atualizarSerieAction = $atualizarSerieAction;

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @param int $codSerie
     * @param AtualizarSerieDTO $atualizarSerieDto
     * @return SerieResource
     * 
     */
    public function execute(int $codSerie, AtualizarSerieDTO $atualizarSerieDto) : SerieResource {

        // Converto objeto para array
        $dados = $atualizarSerieDto->toArray();

        // Validação de dados obrigatórios
        $validador = new AtualizarSerieValidator;
        $validador->execute($codSerie, $dados);

        // Caso os dados NÃO SEJAM válidos
        if (!$validador->estaLiberado()) {

            // Erro de validação
            throw new CamposObrigatoriosInvalidosException(
                'Dados informados são inválidos', 
                $validador->pegarErros()
            );

        }

        // Atualizo informações da série
        $serie = $this->atualizarSerieAction->execute($codSerie, $atualizarSerieDto);

        // Retorno
        return new SerieResource($serie);

    }



}

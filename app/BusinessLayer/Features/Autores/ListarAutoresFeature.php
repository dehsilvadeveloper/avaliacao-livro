<?php
namespace App\BusinessLayer\Features\Autores;

use App\BusinessLayer\ResponseHttpCode;
use App\Exceptions\CamposObrigatoriosInvalidosException;

// Importo DTOs
use App\DataLayer\DTOs\ListarAutoresDto;

// Importo validators
use App\BusinessLayer\Validators\Autores\ListarAutoresValidator;

// Importo actions
use App\BusinessLayer\Actions\Autores\ListarAutoresAction;

// Importo resources
use App\Http\Resources\AutorCollection;

class ListarAutoresFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $listarAutoresAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param ListarAutoresAction $listarAutoresAction
     * @return void
     * 
     */
    public function __construct(ListarAutoresAction $listarAutoresAction) {

        // Instancio actions
        $this->listarAutoresAction = $listarAutoresAction;

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @param ListarAutoresDto $listarAutoresDto
     * @return array
     * 
     */
    public function execute(ListarAutoresDto $listarAutoresDto) : array {

        // Converto objeto para array
        $dados = $listarAutoresDto->toArray();

        // Validação de dados obrigatórios
        $validador = new ListarAutoresValidator;
        $validador->execute($dados);

        // Caso os dados NÃO SEJAM válidos
        if (!$validador->estaLiberado()) {

            // Erro de validação
            throw new CamposObrigatoriosInvalidosException(
                'Dados informados são inválidos', 
                $validador->pegarErros()
            );

        }

        // Obtenho lista de autores
        $autores = $this->listarAutoresAction->execute($listarAutoresDto);

        // Retorno
        // Em caso de necessidade de paginação, caso esteja usando apenas collection, os dados são retornados sem informações de paginação (total de paginas, página atual, etc). 
        // Para incluir informações da paginação na resposta usamos getData() junto da collection.
        return (new AutorCollection($autores))->response()->getData(true);

    }



}

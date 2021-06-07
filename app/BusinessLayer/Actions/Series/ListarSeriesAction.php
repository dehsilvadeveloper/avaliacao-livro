<?php
namespace App\BusinessLayer\Actions\Series;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\ListarSeriesDto;

// Importando models
use App\Models\Serie;

class ListarSeriesAction {

    // Defino variaveis
    private $definition = 'Responsável por executar uma única tarefa';

    /**
     * 
     * Método construtor
     *
     * @access public
     * @return void
     * 
     */
    public function __construct() {

        //

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @param ListarSeriesDto $listarSeriesDto
     * @return object
     * 
     */
    public function execute(ListarSeriesDto $listarSeriesDto) : object {

        // Converto objeto para array
        $dados = $listarSeriesDto->toArray();

        // Monto query
        $query = Serie::query();

        // Verificamos se devemos ordenar o resultado por alguma coluna (ou colunas) específica
        if ($dados['sort'] != '') {

            foreach ($dados['sort'] as $chave => $valor) :

                // Geramos ordenação de acordo com a coluna atual da iteração
                // Nesta caso chave é igual a coluna e valor é igual ao tipo de ordenação (asc ou desc)
                $query->orderBy($chave, $valor);

            endforeach;

        }

        // Obtenho resultado final, verificando se devemos paginá-lo ou não
        $series = ($dados['page_size'] != '') ? $query->paginate($dados['page_size']) : $query->get();

        // Retorno
        return $series;

    }



}

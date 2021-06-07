<?php
namespace App\BusinessLayer\Actions\Generos;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\ListarGenerosDto;

// Importando models
use App\Models\Genero;

class ListarGenerosAction {

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
     * @param ListarGenerosDto $listarGenerosDto
     * @return object
     * 
     */
    public function execute(ListarGenerosDto $listarGenerosDto) : object {

        // Converto objeto para array
        $dados = $listarGenerosDto->toArray();

        // Monto query
        $query = Genero::query();

        // Verificamos se devemos ordenar o resultado por alguma coluna (ou colunas) específica
        if ($dados['sort'] != '') {

            foreach ($dados['sort'] as $chave => $valor) :

                // Geramos ordenação de acordo com a coluna atual da iteração
                // Nesta caso chave é igual a coluna e valor é igual ao tipo de ordenação (asc ou desc)
                $query->orderBy($chave, $valor);

            endforeach;

        }

        // Obtenho resultado final, verificando se devemos paginá-lo ou não
        $generos = ($dados['page_size'] != '') ? $query->paginate($dados['page_size']) : $query->get();

        // Retorno
        return $generos;

    }



}

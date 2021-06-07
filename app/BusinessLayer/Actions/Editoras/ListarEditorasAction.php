<?php
namespace App\BusinessLayer\Actions\Editoras;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\ListarEditorasDto;

// Importando models
use App\Models\Editora;

class ListarEditorasAction {

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
     * @param ListarEditorasDto $listarEditorasDto
     * @return object
     * 
     */
    public function execute(ListarEditorasDto $listarEditorasDto) : object {

        // Converto objeto para array
        $dados = $listarEditorasDto->toArray();

        // Monto query
        $query = Editora::query();

        // Verificamos se devemos ordenar o resultado por alguma coluna (ou colunas) específica
        if ($dados['sort'] != '') {

            foreach ($dados['sort'] as $chave => $valor) :

                // Geramos ordenação de acordo com a coluna atual da iteração
                // Nesta caso chave é igual a coluna e valor é igual ao tipo de ordenação (asc ou desc)
                $query->orderBy($chave, $valor);

            endforeach;

        }

        // Obtenho resultado final, verificando se devemos paginá-lo ou não
        $editoras = ($dados['page_size'] != '') ? $query->paginate($dados['page_size']) : $query->get();

        // Retorno
        return $editoras;

    }



}

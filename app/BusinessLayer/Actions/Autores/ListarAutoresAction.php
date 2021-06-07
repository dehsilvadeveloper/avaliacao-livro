<?php
namespace App\BusinessLayer\Actions\Autores;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\ListarAutoresDto;

// Importando models
use App\Models\Autor;

class ListarAutoresAction {

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
     * @param ListarAutoresDto $listarAutoresDto
     * @return object
     * 
     */
    public function execute(ListarAutoresDto $listarAutoresDto) : object {

        // Converto objeto para array
        $dados = $listarAutoresDto->toArray();

        // Monto query
        $query = Autor::query();

        // Verificamos se devemos ordenar o resultado por alguma coluna (ou colunas) específica
        if ($dados['sort'] != '') {

            foreach ($dados['sort'] as $chave => $valor) :

                // Geramos ordenação de acordo com a coluna atual da iteração
                // Nesta caso chave é igual a coluna e valor é igual ao tipo de ordenação (asc ou desc)
                $query->orderBy($chave, $valor);

            endforeach;

        }

        // Obtenho resultado final, verificando se devemos paginá-lo ou não
        $autores = ($dados['page_size'] != '') ? $query->paginate($dados['page_size']) : $query->get();

        // Retorno
        return $autores;

    }



}

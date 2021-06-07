<?php
namespace App\BusinessLayer\Actions\Livros;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\ListarLivrosDto;

// Importando models
use App\Models\Livro;

class ListarLivrosAction {

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
     * @param ListarLivrosDto $listarLivrosDto
     * @return object
     * 
     */
    public function execute(ListarLivrosDto $listarLivrosDto) : object {

        // Converto objeto para array
        $dados = $listarLivrosDto->toArray();

        // Monto query
        $query = Livro::query();
        $query->with(['autores', 'generos', 'series']);
        $query->withCount('avaliacoes');

        // Verificamos se devemos ordenar o resultado por alguma coluna (ou colunas) específica
        if ($dados['sort'] != '') {

            foreach ($dados['sort'] as $chave => $valor) :

                // Geramos ordenação de acordo com a coluna atual da iteração
                // Nesta caso chave é igual a coluna e valor é igual ao tipo de ordenação (asc ou desc)
                $query->orderBy($chave, $valor);

            endforeach;

        }

        // Obtenho resultado final, verificando se devemos paginá-lo ou não
        $livros = ($dados['page_size'] != '') ? $query->paginate($dados['page_size']) : $query->get();

        // Retorno
        return $livros;

    }



}

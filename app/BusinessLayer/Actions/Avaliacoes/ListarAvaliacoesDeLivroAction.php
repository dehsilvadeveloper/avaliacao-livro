<?php
namespace App\BusinessLayer\Actions\Avaliacoes;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\ListarAvaliacoesDeLivroDto;

// Importando models
use App\Models\Avaliacao;

class ListarAvaliacoesDeLivroAction {

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
     * @param ListarAvaliacoesDeLivroDto $listarAvaliacoesDeLivroDto
     * @return object
     * 
     */
    public function execute(ListarAvaliacoesDeLivroDto $listarAvaliacoesDeLivroDto) : object {

        // Converto objeto para array
        $dados = $listarAvaliacoesDeLivroDto->toArray();

        // Monto query
        $query = Avaliacao::query();
        $query->where('cod_livro', '=', $dados['cod_livro']);

        // Verificamos se devemos ordenar o resultado por alguma coluna (ou colunas) específica
        if ($dados['sort'] != '') {

            foreach ($dados['sort'] as $chave => $valor) :

                // Geramos ordenação de acordo com a coluna atual da iteração
                // Nesta caso chave é igual a coluna e valor é igual ao tipo de ordenação (asc ou desc)
                $query->orderBy($chave, $valor);

            endforeach;

        }

        // Obtenho resultado final, verificando se devemos paginá-lo ou não
        $avaliacoes = ($dados['page_size'] != '') ? $query->paginate($dados['page_size']) : $query->get();

        return $avaliacoes;

    }



}

<?php
namespace App\BusinessLayer\Actions\Livros;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\PesquisarLivrosDto;

// Importando models
use App\Models\Livro;

class PesquisarLivrosAction {

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
     * @param PesquisarLivrosDto $pesquisarLivrosDto
     * @return object
     * 
     */
    public function execute(PesquisarLivrosDto $pesquisarLivrosDto) : object {

        // Converto objeto para array
        $dados = $pesquisarLivrosDto->toArray();

        // Monto query
        $query = Livro::query();
        $query->with(['autores', 'generos', 'series']);
        $query->withCount('avaliacoes');
        $query->filtro($dados);

        // Verificamos se devemos ordenar o resultado por alguma coluna (ou colunas) específica
        if ($dados['sort'] != '') {

            foreach ($dados['sort'] as $chave => $valor) :

                // Geramos ordenação de acordo com a coluna atual da iteração
                // Nesta caso chave é igual a coluna e valor é igual ao tipo de ordenação (asc ou desc)
                $query->orderBy($chave, $valor);

            endforeach;

        }

        // Verificamos se a opção "page_size" está vazia
        if ($dados['page_size'] == '') {

            // Limitamos o total de registros que podem ser obtidos
            // Se o total de registros no banco de dados for muito grande, isso vai evitar que a requisição falhe por causa de tempo de processamento
            $query->limit(1000);

        }

        // Obtenho resultado final, verificando se devemos paginá-lo ou não
        $livros = ($dados['page_size'] != '') ? $query->paginate($dados['page_size']) : $query->get();

        // Retorno
        return $livros;

    }



}

<?php
namespace App\BusinessLayer\Actions\Livros;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\AtualizarLivroDto;

// Importando models
use App\Models\Livro;

class AtualizarLivroAction {

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
     * @param AtualizarLivroDto $atualizarLivroDto
     * @return object
     * 
     */
    public function execute(AtualizarLivroDto $atualizarLivroDto) : object {

        // Converto objeto para array
        $dados = $atualizarLivroDto->toArray();

        // Localizo livro
        $livro = Livro::find($dados['cod_livro']);

        if (!$livro) {

            throw new \Exception('Livro não localizado', ResponseHttpCode::NOT_FOUND);

        }

        // Não precisamos mais do código, então o removemos
        unset($dados['cod_livro']);

        // Atualizo dados
        $livro->update($dados);

        // Recarrego model antes de retornarmos o mesmo para que possamos notar as atualizações
        $livro->refresh();

        return $livro;

    }



}

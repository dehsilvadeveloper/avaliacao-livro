<?php
namespace App\BusinessLayer\Actions\Livros;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\AtualizarLivroDTO;

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
     * @param int $codLivro
     * @param AtualizarLivroDTO $atualizarLivroDTO
     * @return object
     * 
     */
    public function execute(int $codLivro, AtualizarLivroDTO $atualizarLivroDTO) : object {

        // Converto objeto para array
        $dados = $atualizarLivroDTO->toArray();

        // Localizo livro
        $livro = Livro::find($codLivro);

        if (!$livro) {

            throw new \Exception('Livro não localizado', ResponseHttpCode::NOT_FOUND);

        }

        // Atualizo dados
        $livro->update($dados);

        // Recarrego model antes de retornarmos o mesmo para que possamos notar as atualizações
        $livro->refresh();

        return $livro;

    }



}

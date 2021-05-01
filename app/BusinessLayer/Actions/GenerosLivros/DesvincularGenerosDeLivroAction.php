<?php
namespace App\BusinessLayer\Actions\GenerosLivros;

use App\BusinessLayer\ResponseHttpCode;

// Importando models
use App\Models\Livro;

class DesvincularGenerosDeLivroAction {

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
     * @param array $generos
     * @return bool
     * 
     */
    public function execute(int $codLivro, array $generos) : bool {

        // Busco livro
        $livro = Livro::find($codLivro);

        if (!$livro) {

            throw new \Exception('Livro não localizado', ResponseHttpCode::NOT_FOUND);

        }

        // Desvinculo gêneros do livro
        $vinculo = $livro->generos()->detach($generos);

        // Retorno
        return true;

    }



}

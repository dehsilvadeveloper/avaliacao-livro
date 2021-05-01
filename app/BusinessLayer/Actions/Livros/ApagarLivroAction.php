<?php
namespace App\BusinessLayer\Actions\Livros;

use App\BusinessLayer\ResponseHttpCode;

// Importando models
use App\Models\Livro;

class ApagarLivroAction {

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
     * @return void
     * 
     */
    public function execute(int $codLivro) : void {

        $livro = Livro::find($codLivro);

        if (!$livro) {

            throw new \Exception('Livro não localizado', ResponseHttpCode::NOT_FOUND);

        }

        // Removemos relações
        $livro->autores()->detach();
        $livro->generos()->detach();
        $livro->series()->detach();

        // Removemos registro
        $livro->delete();

    }



}

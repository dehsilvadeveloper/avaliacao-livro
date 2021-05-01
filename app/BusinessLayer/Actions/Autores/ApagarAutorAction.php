<?php
namespace App\BusinessLayer\Actions\Autores;

use App\BusinessLayer\ResponseHttpCode;

// Importando models
use App\Models\Autor;

class ApagarAutorAction {

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
     * @param int $codAutor
     * @return void
     * 
     */
    public function execute(int $codAutor) : void {

        $autor = Autor::find($codAutor);

        if (!$autor) {

            throw new \Exception('Autor não localizado', ResponseHttpCode::NOT_FOUND);

        }

        // Removemos relações
        $autor->livros()->detach();

        // Removemos registro
        $autor->delete();

    }



}

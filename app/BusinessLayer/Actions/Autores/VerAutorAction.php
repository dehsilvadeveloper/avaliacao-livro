<?php
namespace App\BusinessLayer\Actions\Autores;

use App\BusinessLayer\ResponseHttpCode;

// Importando models
use App\Models\Autor;

class VerAutorAction {

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
     * @return object
     * 
     */
    public function execute(int $codAutor) : object {

        $autor = Autor::find($codAutor);

        if (!$autor) {

            throw new \Exception('Autor não localizado', ResponseHttpCode::NOT_FOUND);

        }

        return $autor;

    }



}

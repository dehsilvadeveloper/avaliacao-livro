<?php
namespace App\BusinessLayer\Actions\Editoras;

use App\BusinessLayer\ResponseHttpCode;

// Importando models
use App\Models\Editora;

class ListarEditorasAction {

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
     * @return object
     * 
     */
    public function execute() : object {

        $editoras = Editora::all();

        return $editoras;

    }



}

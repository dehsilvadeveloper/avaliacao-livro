<?php
namespace App\BusinessLayer\Actions\Editoras;

use App\BusinessLayer\ResponseHttpCode;

// Importando models
use App\Models\Editora;

class VerEditoraAction {

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
     * @param int $codEditora
     * @return object
     * 
     */
    public function execute(int $codEditora) : object {

        $editora = Editora::find($codEditora);

        if (!$editora) {

            throw new \Exception('Editora não localizada', ResponseHttpCode::NOT_FOUND);

        }

        return $editora;

    }



}

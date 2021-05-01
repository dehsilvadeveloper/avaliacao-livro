<?php
namespace App\BusinessLayer\Actions\Editoras;

use App\BusinessLayer\ResponseHttpCode;

// Importando models
use App\Models\Editora;

class ApagarEditoraAction {

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
     * @return void
     * 
     */
    public function execute(int $codEditora) : void {

        $editora = Editora::find($codEditora);

        if (!$editora) {

            throw new \Exception('Editora não localizada', ResponseHttpCode::NOT_FOUND);

        }

        // Removemos registro
        $editora->delete();

    }



}

<?php
namespace App\BusinessLayer\Actions\Editoras;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\CriarEditoraDto;

// Importando models
use App\Models\Editora;

class CriarEditoraAction {

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
     * @param CriarEditoraDto $criarEditoraDto
     * @return object
     * 
     */
    public function execute(CriarEditoraDto $criarEditoraDto) : object {

        // Converto objeto para array
        $dados = $criarEditoraDto->toArray();

        // Inserção do registro
        $editora = Editora::create($dados);

        return $editora;

    }



}

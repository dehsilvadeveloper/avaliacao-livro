<?php
namespace App\BusinessLayer\Actions\Editoras;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\CriarEditoraDTO;

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
     * @param CriarEditoraDTO $criarEditoraDTO
     * @return object
     * 
     */
    public function execute(CriarEditoraDTO $criarEditoraDTO) : object {

        // Converto objeto para array
        $dados = $criarEditoraDTO->toArray();

        // Inserção do registro
        $editora = Editora::create($dados);

        return $editora;

    }



}

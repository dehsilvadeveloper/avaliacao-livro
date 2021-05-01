<?php
namespace App\BusinessLayer\Actions\Editoras;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\AtualizarEditoraDTO;

// Importando models
use App\Models\Editora;

class AtualizarEditoraAction {

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
     * @param AtualizarEditoraDTO $atualizarEditoraDTO
     * @return object
     * 
     */
    public function execute(int $codEditora, AtualizarEditoraDTO $atualizarEditoraDTO) : object {

        // Converto objeto para array
        $dados = $atualizarEditoraDTO->toArray();

        // Localizo editora
        $editora = Editora::find($codEditora);

        if (!$editora) {

            throw new \Exception('Editora não localizada', ResponseHttpCode::NOT_FOUND);

        }

        // Atualizo dados
        $editora->update($dados);

        // Recarrego model antes de retornarmos o mesmo para que possamos notar as atualizações
        $editora->refresh();

        return $editora;

    }



}

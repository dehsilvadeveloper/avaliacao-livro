<?php
namespace App\BusinessLayer\Actions\Editoras;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\AtualizarEditoraDto;

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
     * @param AtualizarEditoraDto $atualizarEditoraDto
     * @return object
     * 
     */
    public function execute(AtualizarEditoraDto $atualizarEditoraDto) : object {

        // Converto objeto para array
        $dados = $atualizarEditoraDto->toArray();

        // Localizo editora
        $editora = Editora::find($dados['cod_editora']);

        if (!$editora) {

            throw new \Exception('Editora não localizada', ResponseHttpCode::NOT_FOUND);

        }

        // Não precisamos mais do código, então o removemos
        unset($dados['cod_editora']);

        // Atualizo dados
        $editora->update($dados);

        // Recarrego model antes de retornarmos o mesmo para que possamos notar as atualizações
        $editora->refresh();

        return $editora;

    }



}

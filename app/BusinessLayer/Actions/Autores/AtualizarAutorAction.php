<?php
namespace App\BusinessLayer\Actions\Autores;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\AtualizarAutorDTO;

// Importando models
use App\Models\Autor;

class AtualizarAutorAction {

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
     * @param AtualizarAutorDTO $atualizarAutorDTO
     * @return object
     * 
     */
    public function execute(int $codAutor, AtualizarAutorDTO $atualizarAutorDTO) : object {

        // Converto objeto para array
        $dados = $atualizarAutorDTO->toArray();

        // Localizo autor
        $autor = Autor::find($codAutor);

        if (!$autor) {

            throw new \Exception('Autor não localizado', ResponseHttpCode::NOT_FOUND);

        }

        // Atualizo dados
        $autor->update($dados);

        // Recarrego model antes de retornarmos o mesmo para que possamos notar as atualizações
        $autor->refresh();

        return $autor;

    }



}

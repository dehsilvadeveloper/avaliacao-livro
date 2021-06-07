<?php
namespace App\BusinessLayer\Actions\Autores;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\AtualizarAutorDto;

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
     * @param AtualizarAutorDto $atualizarAutorDto
     * @return object
     * 
     */
    public function execute(AtualizarAutorDto $atualizarAutorDto) : object {

        // Converto objeto para array
        $dados = $atualizarAutorDto->toArray();

        // Localizo autor
        $autor = Autor::find($dados['cod_autor']);

        if (!$autor) {

            throw new \Exception('Autor não localizado', ResponseHttpCode::NOT_FOUND);

        }

        // Não precisamos mais do código, então o removemos
        unset($dados['cod_autor']);

        // Atualizo dados
        $autor->update($dados);

        // Recarrego model antes de retornarmos o mesmo para que possamos notar as atualizações
        $autor->refresh();

        return $autor;

    }



}

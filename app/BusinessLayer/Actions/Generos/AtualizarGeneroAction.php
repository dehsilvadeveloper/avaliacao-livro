<?php
namespace App\BusinessLayer\Actions\Generos;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\AtualizarGeneroDTO;

// Importando models
use App\Models\Genero;

class AtualizarGeneroAction {

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
     * @param int $codGenero
     * @param AtualizarGeneroDTO $atualizarGeneroDTO
     * @return object
     * 
     */
    public function execute(int $codGenero, AtualizarGeneroDTO $atualizarGeneroDTO) : object {

        // Converto objeto para array
        $dados = $atualizarGeneroDTO->toArray();

        // Localizo gênero
        $genero = Genero::find($codGenero);

        if (!$genero) {

            throw new \Exception('Gênero não localizado', ResponseHttpCode::NOT_FOUND);

        }

        // Atualizo dados
        $genero->update($dados);

        // Recarrego model antes de retornarmos o mesmo para que possamos notar as atualizações
        $genero->refresh();

        return $genero;

    }



}

<?php
namespace App\BusinessLayer\Actions\Generos;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\AtualizarGeneroDto;

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
     * @param AtualizarGeneroDto $atualizarGeneroDto
     * @return object
     * 
     */
    public function execute(AtualizarGeneroDto $atualizarGeneroDto) : object {

        // Converto objeto para array
        $dados = $atualizarGeneroDto->toArray();

        // Localizo gênero
        $genero = Genero::find($dados['cod_genero']);

        if (!$genero) {

            throw new \Exception('Gênero não localizado', ResponseHttpCode::NOT_FOUND);

        }

        // Não precisamos mais do código, então o removemos
        unset($dados['cod_genero']);

        // Atualizo dados
        $genero->update($dados);

        // Recarrego model antes de retornarmos o mesmo para que possamos notar as atualizações
        $genero->refresh();

        return $genero;

    }



}

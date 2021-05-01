<?php
namespace App\BusinessLayer\Actions\Generos;

use App\BusinessLayer\ResponseHttpCode;

// Importando models
use App\Models\Genero;

class VerGeneroAction {

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
     * @return object
     * 
     */
    public function execute(int $codGenero) : object {

        $genero = Genero::find($codGenero);

        if (!$genero) {

            throw new \Exception('Gênero não localizado', ResponseHttpCode::NOT_FOUND);

        }

        return $genero;

    }



}

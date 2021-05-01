<?php
namespace App\BusinessLayer\Actions\Generos;

use App\BusinessLayer\ResponseHttpCode;

// Importando models
use App\Models\Genero;

class ApagarGeneroAction {

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
     * @return void
     * 
     */
    public function execute(int $codGenero) : void {

        $genero = Genero::find($codGenero);

        if (!$genero) {

            throw new \Exception('Gênero não localizado', ResponseHttpCode::NOT_FOUND);

        }

        // Removemos relações
        $genero->livros()->detach();

        // Removemos registro
        $genero->delete();

    }



}

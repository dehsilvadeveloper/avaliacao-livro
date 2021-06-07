<?php
namespace App\BusinessLayer\Actions\Generos;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\CriarGeneroDto;

// Importando models
use App\Models\Genero;

class CriarGeneroAction {

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
     * @param CriarGeneroDto $criarGeneroDto
     * @return object
     * 
     */
    public function execute(CriarGeneroDto $criarGeneroDto) : object {

        // Converto objeto para array
        $dados = $criarGeneroDto->toArray();

        // Inserção do registro
        $genero = Genero::create($dados);

        return $genero;

    }



}

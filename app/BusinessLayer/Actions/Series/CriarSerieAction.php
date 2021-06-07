<?php
namespace App\BusinessLayer\Actions\Series;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\CriarSerieDto;

// Importando models
use App\Models\Serie;

class CriarSerieAction {

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
     * @param CriarSerieDto $criarSerieDto
     * @return object
     * 
     */
    public function execute(CriarSerieDto $criarSerieDto) : object {

        // Converto objeto para array
        $dados = $criarSerieDto->toArray();

        // Inserção do registro
        $serie = Serie::create($dados);

        return $serie;

    }



}

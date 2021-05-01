<?php
namespace App\BusinessLayer\Actions\Autores;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\CriarAutorDTO;

// Importando models
use App\Models\Autor;

class CriarAutorAction {

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
     * @param CriarAutorDTO $criarAutorDTO
     * @return object
     * 
     */
    public function execute(CriarAutorDTO $criarAutorDTO) : object {

        // Converto objeto para array
        $dados = $criarAutorDTO->toArray();

        // Inserção do registro
        $autor = Autor::create($dados);

        return $autor;

    }



}

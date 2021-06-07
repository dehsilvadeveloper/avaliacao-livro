<?php
namespace App\BusinessLayer\Actions\Livros;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\CriarLivroDto;

// Importando models
use App\Models\Livro;

class CriarLivroAction {

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
    public function __construct( ) {

        //

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @param CriarLivroDto $criarLivroDto
     * @return object
     * 
     */
    public function execute(CriarLivroDto $criarLivroDto) : object {

        // Converto objeto para array
        $dados = $criarLivroDto->toArray();

        // Inserção do registro
        $livro = Livro::create($dados);

        return $livro;

    }



}

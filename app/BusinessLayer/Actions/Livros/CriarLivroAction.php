<?php
namespace App\BusinessLayer\Actions\Livros;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\CriarLivroDTO;

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
     * @param CriarLivroDTO $criarLivroDTO
     * @return object
     * 
     */
    public function execute(CriarLivroDTO $criarLivroDTO) : object {

        // Converto objeto para array
        $dados = $criarLivroDTO->toArray();

        // Inserção do registro
        $livro = Livro::create($dados);

        return $livro;

    }



}

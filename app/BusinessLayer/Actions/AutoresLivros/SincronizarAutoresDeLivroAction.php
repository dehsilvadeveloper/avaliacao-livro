<?php
namespace App\BusinessLayer\Actions\AutoresLivros;

use App\BusinessLayer\ResponseHttpCode;

// Importando models
use App\Models\Livro;

class SincronizarAutoresDeLivroAction {

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
     * @param int $codLivro
     * @param array $autores - contém IDs e dados extras de pivot
     * @return array
     * 
     */
    public function execute(int $codLivro, array $autores) : array {

        // Busco livro
        $livro = Livro::find($codLivro);

        if (!$livro) {

            throw new \Exception('Livro não localizado', ResponseHttpCode::NOT_FOUND);

        }

        // Sincronizo autores do livro
        $sincronizacao = $livro->autores()->sync($autores);

        // Retorno
        return $sincronizacao;

    }



}

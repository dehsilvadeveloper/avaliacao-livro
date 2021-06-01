<?php
namespace App\BusinessLayer\Actions\Livros;

use App\BusinessLayer\ResponseHttpCode;

// Importando models
use App\Models\Livro;

class PesquisarLivrosAction {

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
     * @param array $criterio
     * @return object|null
     * 
     */
    public function execute(array $criterio) {

        $query = Livro::query();

        if ($criterio != '' and !is_array($criterio)) {

            throw new \Exception('Critérios de pesquisa inválidos', ResponseHttpCode::BAD_REQUEST);

        }

        if (count($criterio) == 1) {

            $query->where($criterio[0][0], $criterio[0][1], $criterio[0][2]);

        } elseif (count($criterio) > 1) {

            foreach ($criterio as $c) :

                $query->where($c[0], $c[1], $c[2]);

            endforeach;

        } else {

            throw new \Exception('Nenhum critério de pesquisa foi informado', ResponseHttpCode::BAD_REQUEST);

        }

        //$livros = $query->get();
        $livros = $query->paginate();

        //return Livro::filter($filters)->get();
        return $livros;

    }



}

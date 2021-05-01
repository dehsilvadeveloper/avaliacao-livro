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
     * @return object
     * 
     */
    public function execute(array $criterio) : object {

        $query = Livro::query();

        if ($criterio != '' and !is_array($criterio)) {

            throw new \Exception('Critérios de pesquisa inválidos', ResponseHttpCode::BAD_REQUEST);

        }

        if (count($criterio) == 1) {

            $query->where($criterio[0], $criterio[1], $criterio[2]);

        } elseif (count($criterio > 1)) {

            foreach ($criterio as $c) :

                $query->where($c[0], $c[1], $c[2]);

            endforeach;

        }

        $query->get();

        return $query;

    }



}

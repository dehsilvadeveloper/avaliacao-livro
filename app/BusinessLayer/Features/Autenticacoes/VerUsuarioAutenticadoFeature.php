<?php
namespace App\BusinessLayer\Features\Autenticacoes;

// Importo resources
use App\Http\Resources\UsuarioResource;

class VerUsuarioAutenticadoFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';

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
     * @return UsuarioResource
     * 
     */
    public function execute() : UsuarioResource {

        // Localiza usuário autenticado
        $usuarioAutenticado = auth()->user();

        // Retorno
        return new UsuarioResource($usuarioAutenticado);

    }



}

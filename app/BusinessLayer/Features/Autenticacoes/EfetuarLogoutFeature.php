<?php
namespace App\BusinessLayer\Features\Autenticacoes;

class EfetuarLogoutFeature {

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
     * @return void
     * 
     */
    public function execute() : void {

        // Localiza usuário autenticado
        $usuarioAutenticado = auth()->user();

        // Remove token atual do usuário, deslogando-o
        $usuarioAutenticado->tokens()->where('id', $usuarioAutenticado->currentAccessToken()->id)->delete();

    }



}

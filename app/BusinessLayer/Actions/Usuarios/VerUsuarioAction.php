<?php
namespace App\BusinessLayer\Actions\Usuarios;

use App\BusinessLayer\ResponseHttpCode;

// Importando models
use App\Models\Usuario;

class VerUsuarioAction {

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
     * @param int $codUsuario
     * @return object
     * 
     */
    public function execute(int $codUsuario) : object {

        $usuario = Usuario::find($codUsuario);

        if (!$usuario) {

            throw new \Exception('Usuário não localizado', ResponseHttpCode::NOT_FOUND);

        }

        return $usuario;

    }



}

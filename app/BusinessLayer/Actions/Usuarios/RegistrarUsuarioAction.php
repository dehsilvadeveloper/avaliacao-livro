<?php
namespace App\BusinessLayer\Actions\Usuarios;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\RegistrarUsuarioDto;

// Importando models
use App\Models\Usuario;

class RegistrarUsuarioAction {

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
     * @param RegistrarUsuarioDto $registrarUsuarioDto
     * @return object
     * 
     */
    public function execute(RegistrarUsuarioDto $registrarUsuarioDto) : object {

        // Converto objeto para array
        $dados = $registrarUsuarioDto->toArray();

        // Criptografo senha de acesso antes de inserção
        $dados['password'] = bcrypt($dados['password']);

        // Inserção do registro
        $usuario = Usuario::create($dados);

        return $usuario;

    }



}

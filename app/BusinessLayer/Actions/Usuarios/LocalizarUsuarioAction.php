<?php
namespace App\BusinessLayer\Actions\Usuarios;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\EfetuarLoginDto;

// Importando models
use App\Models\Usuario;

class LocalizarUsuarioAction {

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
     * @param EfetuarLoginDto $efetuarLoginDto
     * @return object|null
     * 
     */
    public function execute(EfetuarLoginDto $efetuarLoginDto) {

        // Converto objeto para array
        $dados = $efetuarLoginDto->toArray();

        // Removo colunas desnecessárias para pesquisa
        unset($dados['password']);

        // Monto query
        $query = Usuario::query();
        $query->filtro($dados);

        // Obtenho resultado final
        $usuario = $query->first();

        // Retorno
        return $usuario;

    }



}

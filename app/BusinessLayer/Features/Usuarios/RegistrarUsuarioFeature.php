<?php
namespace App\BusinessLayer\Features\Usuarios;

use App\BusinessLayer\ResponseHttpCode;
use App\Exceptions\CamposObrigatoriosInvalidosException;

// Importo DTOs
use App\DataLayer\DTOs\RegistrarUsuarioDto;

// Importo validators
use App\BusinessLayer\Validators\Usuarios\RegistrarUsuarioValidator;

// Importo actions
use App\BusinessLayer\Actions\Usuarios\RegistrarUsuarioAction;

// Importo resources
use App\Http\Resources\UsuarioResource;

class RegistrarUsuarioFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $registrarUsuarioAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param RegistrarUsuarioAction $registrarUsuarioAction
     * @return void
     * 
     */
    public function __construct(RegistrarUsuarioAction $registrarUsuarioAction) {

        // Instancio actions
        $this->registrarUsuarioAction = $registrarUsuarioAction;

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @param RegistrarUsuarioDto $registrarUsuarioDto
     * @return UsuarioResource
     * 
     */
    public function execute(RegistrarUsuarioDto $registrarUsuarioDto) : UsuarioResource {

        // Converto objeto para array
        $dados = $registrarUsuarioDto->toArray();

        // Validação de dados obrigatórios
        $validador = new RegistrarUsuarioValidator;
        $validador->execute($dados);

        // Caso os dados NÃO SEJAM válidos
        if (!$validador->estaLiberado()) {

            // Erro de validação
            throw new CamposObrigatoriosInvalidosException(
                'Dados informados são inválidos', 
                $validador->pegarErros()
            );

        }

        // Registrar novo usuário
        $usuario = $this->registrarUsuarioAction->execute($registrarUsuarioDto);

        // Retorno
        return new UsuarioResource($usuario);

    }



}

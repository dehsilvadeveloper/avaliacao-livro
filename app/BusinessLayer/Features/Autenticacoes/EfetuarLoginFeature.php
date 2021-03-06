<?php
namespace App\BusinessLayer\Features\Autenticacoes;

use App\BusinessLayer\ResponseHttpCode;
use App\Exceptions\CamposObrigatoriosInvalidosException;

// Importo DTOs
use App\DataLayer\DTOs\EfetuarLoginDto;

// Importo validators
use App\BusinessLayer\Validators\Autenticacoes\EfetuarLoginValidator;

// Importo actions
use App\BusinessLayer\Actions\Usuarios\LocalizarUsuarioAction;

// Importo resources
use App\Http\Resources\UsuarioResource;

class EfetuarLoginFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $localizarUsuarioAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param LocalizarUsuarioAction $localizarUsuarioAction
     * @return void
     * 
     */
    public function __construct(LocalizarUsuarioAction $localizarUsuarioAction) {

        // Instancio actions
        $this->localizarUsuarioAction = $localizarUsuarioAction;

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @param EfetuarLoginDto $efetuarLoginDto
     * @return object
     * 
     */
    public function execute(EfetuarLoginDto $efetuarLoginDto) : object {

        // Converto objeto para array
        $dados = $efetuarLoginDto->toArray();

        // Validação de dados obrigatórios
        $validador = new EfetuarLoginValidator;
        $validador->execute($dados);

        // Caso os dados NÃO SEJAM válidos
        if (!$validador->estaLiberado()) {

            // Erro de validação
            throw new CamposObrigatoriosInvalidosException(
                'Dados informados são inválidos', 
                $validador->pegarErros()
            );

        }

        // Busco usuário no BD
        $usuario = $this->localizarUsuarioAction->execute($efetuarLoginDto);

        // Verifico se o usuário existe
        if (!$usuario) {

            throw new \Exception('Usuário de API não pôde ser localizado', ResponseHttpCode::AUTHENTICATION_FAILED);

        }

        // Executo tentativa de autenticação
        $autenticacao = auth()->attempt($dados);

        // Verifica se houve problemas na autenticação
        if (!$autenticacao) {

            throw new \Exception('Dados de acesso para uso da API são inválidos', ResponseHttpCode::AUTHENTICATION_FAILED);

        }

        // Crio TOKEN para o usuário autenticado
        $token = $usuario->createToken('livro_rating')->plainTextToken;

        // Retorno
        return (object) array(
            'token' => $token,
            'usuario' => new UsuarioResource($usuario)
        );
        
    }



}

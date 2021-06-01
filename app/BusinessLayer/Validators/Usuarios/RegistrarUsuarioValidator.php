<?php
namespace App\BusinessLayer\Validators\Usuarios;

use Validator;
use App\Rules\ForcaDaSenhaRule;

class RegistrarUsuarioValidator {

    // Defino propriedades
    private $sucesso;
    private $errosValidacao;
    private $regras = [
        'usuario' => 'required|unique:usuario,usuario',
        'email' => 'required'
    ];
    private $mensagens = [
        'usuario.required' => 'É obrigatório informar o campo USUÁRIO.',
        'usuario.unique' => 'Este USUÁRIO já foi utilizado.',
        'password.required' => 'É obrigatório informar o campo SENHA.',
        'password.confirmed' => 'Os campos SENHA e CONFIRMAÇÃO DE SENHA devem possuir informações idênticas.',
        'email.required' => 'É obrigatório informar o campo E-MAIL.'
    ];

    /**
     * 
     * Executamos validação
     *
     * @access public
     * @param array $dados
     * @return void
     * 
     */
    public function execute(array $dados) : void {

        // Adiciono regras para coluna password, incluindo regra customizada
        $this->regras['password'] = ['required', new ForcaDaSenhaRule(8), 'confirmed'];

        /***************************************
        ::: VERIFICANDO CAMPOS OBRIGATÓRIOS :::
        ****************************************/
        $validacao = Validator::make($dados, $this->regras, $this->mensagens);

        /***************************************
        ::: DEFININDO RESULTADO DA VALIDAÇÃO :::
        ****************************************/
        // Verificamos se algum erro de validação foi obtido
        if ($validacao->fails()) {

            // Indicamos que dados NÃO SÃO VÁLIDOS
            $this->sucesso = false;

            // Colocamos as mensagens de erro obtidas em propriedade da classe. 
            // As mensagens são obtidas no formato array
            $this->errosValidacao = $validacao->errors()->all();

        } else {

            // Indicamos que dados SÃO VÁLIDOS
            $this->sucesso = true;

        }

    }



    /**
     * 
     * Retorna valor da propriedade SUCESSO
     *
     * @access public
     * @return bool
     * 
     */
    public function estaLiberado() : bool {

        return $this->sucesso;

    }



    /**
     * 
     * Retorna valor da propriedade JSON ERROS VALIDAÇÃO
     *
     * @access public
     * @return array
     * 
     */
    public function pegarErros() : array {

        return $this->errosValidacao;

    }



}

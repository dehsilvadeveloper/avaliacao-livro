<?php
namespace App\BusinessLayer\Validators\Autores;

use Validator;

class AtualizarAutorValidator {

    // Defino propriedades
    private $sucesso;
    private $errosValidacao;
    private $regras = [
        'cod_pais' => 'required'
    ];
    private $mensagens = [
        'nome.required' => 'É obrigatório informar o campo NOME.',
        'nome.unique' => 'Este NOME já foi utilizado por outro item.',
        'cod_pais.required' => 'É obrigatório informar o campo PAÍS.'
    ];

    /**
     * 
     * Executamos validação
     *
     * @access public
     * @param int $codAutor
     * @param array $dados
     * @return void
     * 
     */
    public function execute(int $codAutor, array $dados) : void {

        // Criamos regra de nome único, desconsiderando nome atual do registro
        $this->regras['nome'] = 'required|unique:autor,nome,' . $codAutor . ',cod_autor';

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

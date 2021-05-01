<?php
namespace App\BusinessLayer\Validators\Series;

use Validator;

class CriarSerieValidator {

    // Defino propriedades
    private $sucesso;
    private $jsonErrosValidacao;
    private $regras = [
        'titulo' => 'required|unique:serie',
    ];
    private $mensagens = [
        'titulo.required' => 'É obrigatório informar o campo TITULO.',
        'titulo.unique' => 'Este TITULO já foi utilizado por outro item.',
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
            // As mensagens são obtidas no formato array que é modificado para formato json
            $this->jsonErrosValidacao = json_encode(array(
                'validacao' => $validacao->errors()->all()
            ));

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
     * @return string
     * 
     */
    public function pegarErros() : string {

        return $this->jsonErrosValidacao;

    }



}

<?php
namespace App\BusinessLayer\Validators\Avaliacoes;

use Validator;

class AtualizarAvaliacaoValidator {

    // Defino propriedades
    private $sucesso;
    private $errosValidacao;
    private $regras = [
        'nota' => 'required|numeric|min:0|max:5',
        'review' => 'required|string|min:5'
    ];
    private $mensagens = [
        'nota.required' => 'É obrigatório informar o campo NOTA.',
        'nota.numeric' => 'O campo NOTA deve conter um número entre 0 e 5.',
        'nota.min' => 'O valor mínimo do campo NOTA é 0.',
        'nota.max' => 'O valor máximo do campo NOTA é 5.',
        'review.required' => 'É obrigatório informar o campo REVIEW.',
        'review.string' => 'O campo REVIEW deve conter apenas texto.',
        'review.min' => 'O campo REVIEW deve conter no mínimo 5 caracteres.'
    ];

    /**
     * 
     * Executamos validação
     *
     * @access public
     * @param int $codAvaliacao
     * @param array $dados
     * @return void
     * 
     */
    public function execute(int $codAvaliacao, array $dados) : void {

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

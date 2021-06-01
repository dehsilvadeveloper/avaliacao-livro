<?php
namespace App\BusinessLayer\Validators\Avaliacoes;

use Validator;
use Illuminate\Validation\Rule;

class CriarAvaliacaoValidator {

    // Defino propriedades
    private $sucesso;
    private $errosValidacao;
    private $regras = [
        'cod_usuario' => 'required||exists:usuario,cod_usuario',
        'nota' => 'required|numeric|min:0|max:5',
        'review' => 'required|string|min:5'
    ];
    private $mensagens = [
        'cod_livro.required' => 'É obrigatório informar o campo LIVRO.',
        'cod_livro.exists' => 'O LIVRO informado não pôde ser localizado. É necessário informar um LIVRO válido.',
        'cod_livro.unique' => 'Já existe uma avaliação deste USUÁRIO para este LIVRO',
        'cod_usuario.required' => 'É obrigatório informar o campo USUÁRIO.',
        'cod_usuario.exists' => 'O USUÁRIO informado não pôde ser localizado. É necessário informar um USUÁRIO válido.',
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
     * @param array $dados
     * @return void
     * 
     */
    public function execute(array $dados) : void {

        // Definimos regra especial, combinando cod_livro e cod_usuario como tendo que ser obrigatoriamente únicos em conjunto
        $uniqueRuleParaLivroComUsuario = Rule::unique('avaliacao')->where(function ($query) use ($dados) {
            return $query->where('cod_usuario', '=', $dados['cod_usuario']);
        });

        // Aplicamos regras para coluna 'cod_livro', incluindo a regra especial entre elas
        $this->regras['cod_livro'] = ['required', 'exists:livro,cod_livro', $uniqueRuleParaLivroComUsuario];

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

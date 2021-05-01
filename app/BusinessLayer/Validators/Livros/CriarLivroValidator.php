<?php
namespace App\BusinessLayer\Validators\Livros;

use Validator;

class CriarLivroValidator {

    // Defino propriedades
    private $sucesso;
    private $jsonErrosValidacao;
    private $regras = [
        'titulo' => 'required|unique:livro',
        'titulo_original' => 'required',
        'idioma' => 'required|min:3',
        'data_publicacao' => 'required|date',
        'sinopse' => 'required|min:10',
        'total_paginas' => 'required|numeric',
        'cod_editora' => 'required',
        'autores' => 'required|array',
        'generos' => 'required|array'
    ];
    private $mensagens = [
        'titulo.required' => 'É obrigatório informar o campo TITULO.',
        'titulo.unique' => 'Este TITULO já foi utilizado por outro item.',
        'titulo_original.required' => 'É obrigatório informar o campo TITULO ORIGINAL.',
        'idioma.required' => 'É obrigatório informar o campo IDIOMA.',
        'idioma.min' => 'O campo IDIOMA precisa ter no mínimo 3 caracteres.',
        'data_publicacao.required' => 'É obrigatório informar o campo DATA DA PUBLICAÇÃO',
        'data_publicacao.date' => 'O campo DATA DA PUBLICAÇÃO dve conter uma data válida.',
        'sinopse.required' => 'É obrigatório informar o campo SINOPSE.',
        'sinopse.min' => 'O campo SINOPSE precisa ter no mínimo 10 caracteres.',
        'total_paginas.required' => 'É obrigatório informar o campo TOTAL DE PÁGINAS',
        'total_paginas.numeric'=> 'O campo TOTAL DE PÁGINAS deve conter apenas números.',
        'cod_editora.required' => 'É obrigatório informar o campo EDITORA.',
        'autores.required' => 'É obrigatório informar o campo AUTORES',
        'autores.array'=> 'O campo AUTORES deve conter apenas um vetor com identificadores dos autores',
        'generos.required' => 'É obrigatório informar o campo AUTORES',
        'generos.array'=> 'O campo AUTORES deve conter apenas um vetor com identificadores dos autores'
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
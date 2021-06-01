<?php
namespace App\BusinessLayer\Validators\Livros;

use Validator;

class CriarLivroValidator {

    // Defino propriedades
    private $sucesso;
    private $errosValidacao;
    private $regras = [
        'titulo' => 'required|unique:livro',
        'titulo_original' => 'required',
        'idioma' => 'required|min:3',
        'data_publicacao' => 'required|date',
        'sinopse' => 'required|min:10',
        'total_paginas' => 'required|numeric',
        'cod_editora' => 'required|exists:editora,cod_editora',

        // Gera mensagem geral de validação
        //'autores' => 'required|array|exists:autor,cod_autor',

        // Gera mensagem de validação para cada item do array
        'autores' => 'required|array',
        'autores.*' => 'required|exists:autor,cod_autor',

        // Gera mensagem geral de validação
        //'generos' => 'required|array|exists:genero,cod_genero',

        // Gera mensagem de validação para cada item do array
        'generos' => 'required|array',
        'generos.*' => 'required|exists:genero,cod_genero',

        //'series.*' => 'sometimes|required|exists:serie,cod_serie'
        'series.*' => 'filled',
        'series.*.cod_serie' => 'required|exists:serie,cod_serie'
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
        'cod_editora.exists' => 'A EDITORA informada não pôde ser localizada. É necessário informar uma EDITORA válida.',

        'autores.required' => 'É obrigatório informar o campo AUTORES',
        'autores.array'=> 'O campo AUTORES deve conter apenas um vetor com identificadores dos autores',
        // Mensagem geral de validação
        //'autores.exists' => 'Um ou mais dos AUTORES informados não puderam ser localizados. É necessário informar uma lista de AUTORES válida.',
        // Mensagem de validação para cada item do array
        'autores.*.exists' => 'O AUTOR de identificação :input não pôde ser localizado. É necessário informar uma lista de AUTORES válida.',

        'generos.required' => 'É obrigatório informar o campo GÊNEROS',
        'generos.array'=> 'O campo GÊNEROS deve conter apenas um vetor com identificadores dos gêneros',
        // Mensagem geral de validação
        //'generos.exists' => 'Um ou mais dos GÊNEROS informados não puderam ser localizados. É necessário informar uma lista de GÊNEROS válida.',
        // Mensagem de validação para cada item do array
        'generos.*.exists' => 'O GÊNERO de identificação :input não pôde ser localizado. É necessário informar uma lista de GÊNEROS válida.',
        
        // Mensagem geral de validação
        //'series.*.cod_serie.exists' => 'Um ou mais dos SÉRIES informadas não puderam ser localizadas. É necessário informar uma lista de SÉRIES válida.'
        // Mensagem de validação para cada item do array
        'series.*.cod_serie.exists' => 'A SÉRIE de identificação :input não pôde ser localizada. É necessário informar uma lista de SÉRIES válida.'
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
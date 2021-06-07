<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\Dtos\PesquisarLivrosDto;

// Importo features
use App\BusinessLayer\Features\Livros\PesquisarLivrosFeature;

// Importo helpers
use App\Helpers\ValidacaoHelper;
use App\Helpers\QueryHelper;

class PesquisaLivroController extends Controller {

    // Defino variaveis
    private $pesquisarLivrosFeature;

    /**
     * 
     * Método construtor
     * 
     * @access public
     * @param PesquisarLivrosFeature $pesquisarLivrosFeature
     * @return void
     * 
     */
    public function __construct(
        PesquisarLivrosFeature $pesquisarLivrosFeature
    ) {

        // Instancio features
        $this->pesquisarLivrosFeature = $pesquisarLivrosFeature;

    }



    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        // Capto dados da requisição
        $dados = $request->only([     
            'page',  
            'page_size',
            'sort',
            'cod_editora',  
            'titulo',
            'titulo_original',
            'idioma',
            'isbn_10',
            'isbn_13',
            'data_publicacao',
            'sinopse',
            'total_paginas',
            'tipo_capa',
            'foto_capa'
        ]); 
 
        try {

            // Convertemos de string para array de ordenação de query
            $dados['sort'] = QueryHelper::converterStringParaArrayDeOrdenacaoDeQuery($dados['sort']);

            // Gero DTO para pesquisa de livros
            $pesquisarLivrosDto = PesquisarLivrosDto::fromArray($dados);

            // Pesquisa por livros utilizando critério informado
            $livros = $this->pesquisarLivrosFeature->execute($pesquisarLivrosDto);

        } catch (\Exception | \Error $e) {
              
            $codigoErro = ValidacaoHelper::validarHttpStatusCode($e->getCode());

            // Retorno Erro
            return response()->json(array(
                'success' => false,
                'message' => $e->getMessage(),
                'errors' => method_exists($e, 'getErrors') ? $e->getErrors() : null,
                'data' => null
            ), $codigoErro);

        }

        // Monto estrutura da resposta, adicionando os recursos recebidos da feature
        // Para isso fazemos um merge de uma collection com dados básicos com a collection recebida
        $resposta = collect([
            'success' => true,
            'message' => null
        ])->merge($livros);

        // Retorno Sucesso
        return response()->json($resposta, ResponseHttpCode::OK);

    }



}

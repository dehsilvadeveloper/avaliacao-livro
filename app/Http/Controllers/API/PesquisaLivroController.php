<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BusinessLayer\ResponseHttpCode;

// Importo features
use App\BusinessLayer\Features\Livros\PesquisarLivrosFeature;

// Importo helpers
use App\Helpers\ValidacaoHelper;

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
        $dadosParaCriterio = $request->only([     
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

            // Pesquisa por livros utilizando critério informado
            $livros = $this->pesquisarLivrosFeature->execute($dadosParaCriterio);

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

        // Retorno Sucesso
        return response()->json(array(
            'success' => true,
            'message' => null,
            'data' => array(
                'livros' => $livros
            )
        ), ResponseHttpCode::OK);

    }



}

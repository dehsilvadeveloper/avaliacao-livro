<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\CriarLivroDTO;
use App\DataLayer\DTOs\AtualizarLivroDTO;

// Importo features
use App\BusinessLayer\Features\Livros\CriarLivroFeature;
use App\BusinessLayer\Features\Livros\AtualizarLivroFeature;
use App\BusinessLayer\Features\Livros\ListarLivrosFeature;
use App\BusinessLayer\Features\Livros\VerLivroFeature;
use App\BusinessLayer\Features\Livros\ApagarLivroFeature;

// Importo helpers
use App\Helpers\ValidacaoHelper;

class LivroController extends Controller {

    // Defino variaveis
    private $criarLivroFeature;
    private $atualizarLivroFeature;
    private $listarLivrosFeature;
    private $verLivroFeature;
    private $apagarLivroFeature;

    /**
     * 
     * Método construtor
     * 
     * @access public
     * @param CriarLivroFeature $criarLivroFeature
     * @param AtualizarLivroFeature $atualizarLivroFeature
     * @param ListarLivrosFeature $listarLivrosFeature
     * @param VerLivroFeature $verLivroFeature
     * @param ApagarLivroFeature $apagarLivroFeature
     * @return void
     * 
     */
    public function __construct(
        CriarLivroFeature $criarLivroFeature,
        AtualizarLivroFeature $atualizarLivroFeature,
        ListarLivrosFeature $listarLivrosFeature,
        VerLivroFeature $verLivroFeature,
        ApagarLivroFeature $apagarLivroFeature
    ) {

        // Instancio features
        $this->criarLivroFeature = $criarLivroFeature;
        $this->atualizarLivroFeature = $atualizarLivroFeature;
        $this->listarLivrosFeature = $listarLivrosFeature;
        $this->verLivroFeature = $verLivroFeature;
        $this->apagarLivroFeature = $apagarLivroFeature;

    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
 
        try {

            // Obtenho lista de livros
            $livros = $this->listarLivrosFeature->execute();

        } catch (\Exception | \Error $e) {
              
            $codigoErro = ValidacaoHelper::validarHttpStatusCode($e->getCode());

            // Retorno Erro
            return response()->json(array(
                'success' => false,
                'message' => $e->getMessage(),
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



    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        // Capto dados da requisição
        $dados = $request->only([      
            'titulo',
            'titulo_original',
            'idioma',
            'isbn_10',
            'isbn_13',
            'data_publicacao',
            'sinopse',
            'total_paginas',
            'tipo_capa',
            'foto_capa',
            'cod_editora',
            'autores',
            'generos',
            'series'
        ]);

        try {

            // Gero DTO para criação do livro
            $criarLivroDto = CriarLivroDto::fromArray($dados);

            // Crio um novo livro
            $livro = $this->criarLivroFeature->execute($criarLivroDto);

        } catch (\Exception | \Error $e) {
              
            $codigoErro = ValidacaoHelper::validarHttpStatusCode($e->getCode());

            // Retorno Erro
            return response()->json(array(
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null
            ), $codigoErro);

        }

        // Retorno Sucesso
        return response()->json(array(
            'success' => true,
            'message' => 'Livro criado com sucesso',
            'data' => array(
                'livro' => $livro
            )
        ), ResponseHttpCode::OK);

    }



    /**
     * Display the specified resource.
     *
     * @param int $codLivro
     * @return \Illuminate\Http\Response
     */
    public function show($codLivro) {
        
        try {

            // Obtenho dados de livro especifico
            $livro = $this->verLivroFeature->execute($codLivro);

        } catch (\Exception | \Error $e) {
              
            $codigoErro = ValidacaoHelper::validarHttpStatusCode($e->getCode());

            // Retorno Erro
            return response()->json(array(
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null
            ), $codigoErro);

        }

        // Retorno Sucesso
        return response()->json(array(
            'success' => true,
            'message' => null,
            'data' => array(
                'livro' => $livro
            )
        ), ResponseHttpCode::OK);

    }



    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $codLivro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $codLivro) {
        
        // Capto dados da requisição
        $dados = $request->only([       
            'titulo',
            'titulo_original',
            'idioma',
            'isbn_10',
            'isbn_13',
            'data_publicacao',
            'sinopse',
            'total_paginas',
            'tipo_capa',
            'cod_editora',
            'autores',
            'generos',
            'series'
        ]); 

        try {

            // Gero DTO para atualização do livro
            $atualizarLivroDto = AtualizarLivroDto::fromArray($dados);

            // Atualizo informações do livro
            $livro = $this->atualizarLivroFeature->execute($codLivro, $atualizarLivroDto);

        } catch (\Exception | \Error $e) {
              
            $codigoErro = ValidacaoHelper::validarHttpStatusCode($e->getCode());

            // Retorno Erro
            return response()->json(array(
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null
            ), $codigoErro);

        }

        // Retorno Sucesso
        return response()->json(array(
            'success' => true,
            'message' => 'Livro atualizado com sucesso',
            'data' => array(
                'livro' => $livro
            )
        ), ResponseHttpCode::OK);

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param int $codLivro
     * @return \Illuminate\Http\Response
     */
    public function destroy($codLivro) {
        
        try {

            // Apago livro especifico
            $apagar = $this->apagarLivroFeature->execute($codLivro);

        } catch (\Exception | \Error $e) {
              
            $codigoErro = ValidacaoHelper::validarHttpStatusCode($e->getCode());

            // Retorno Erro
            return response()->json(array(
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null
            ), $codigoErro);

        }

        // Retorno Sucesso
        return response()->json(array(
            'success' => true,
            'message' => 'Livro removido com sucesso',
            'data' => null
        ), ResponseHttpCode::OK);

    }


}
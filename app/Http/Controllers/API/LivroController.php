<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\CriarLivroDto;
use App\DataLayer\DTOs\AtualizarLivroDto;
use App\DataLayer\DTOs\ListarLivrosDto;

// Importo features
use App\BusinessLayer\Features\Livros\CriarLivroFeature;
use App\BusinessLayer\Features\Livros\AtualizarLivroFeature;
use App\BusinessLayer\Features\Livros\ListarLivrosFeature;
use App\BusinessLayer\Features\Livros\VerLivroFeature;
use App\BusinessLayer\Features\Livros\ApagarLivroFeature;

// Importo helpers
use App\Helpers\ValidacaoHelper;
use App\Helpers\QueryHelper;

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

        // Defino que todas as rotas/métodos deste controller estarão protegidas pelo middleware de autenticação
        // Quaisquer rotas dentro da opção EXCEPT() ficarão FORA da proteção do middleware, ou seja, serão PÚBLICAS
        $this->middleware('auth:sanctum')->except(['index','show']);

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
            'sort'
        ]); 

        try {

            // Convertemos de string para array de ordenação de query
            $dados['sort'] = QueryHelper::converterStringParaArrayDeOrdenacaoDeQuery($dados['sort']);

            // Gero DTO para listagem de livros
            $listarLivrosDto = ListarLivrosDto::fromArray($dados);

            // Obtenho lista de livros
            $livros = $this->listarLivrosFeature->execute($listarLivrosDto);

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

            // Convertemos de JSON para array associativo
            $dados['autores'] = json_decode($dados['autores'], true);
            $dados['generos'] = json_decode($dados['generos'], true);
            $dados['series'] = json_decode($dados['series'], true);

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
                'errors' => method_exists($e, 'getErrors') ? $e->getErrors() : null,
                'data' => null
            ), $codigoErro);

        }

        // Retorno Sucesso
        return response()->json(array(
            'success' => true,
            'message' => 'Livro criado com sucesso',
            'data' => $livro
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
                'errors' => method_exists($e, 'getErrors') ? $e->getErrors() : null,
                'data' => null
            ), $codigoErro);

        }

        // Retorno Sucesso
        return response()->json(array(
            'success' => true,
            'message' => null,
            'data' => $livro
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

            // Adicionamos código ao array
            $dados['cod_livro'] = $codLivro;

            // Convertemos de JSON para array associativo
            $dados['autores'] = json_decode($dados['autores'], true);
            $dados['generos'] = json_decode($dados['generos'], true);
            $dados['series'] = json_decode($dados['series'], true);

            // Gero DTO para atualização do livro
            $atualizarLivroDto = AtualizarLivroDto::fromArray($dados);

            // Atualizo informações do livro
            $livro = $this->atualizarLivroFeature->execute($atualizarLivroDto);

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
            'message' => 'Livro atualizado com sucesso',
            'data' => $livro
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
                'errors' => method_exists($e, 'getErrors') ? $e->getErrors() : null,
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

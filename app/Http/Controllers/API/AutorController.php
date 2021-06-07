<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\CriarAutorDto;
use App\DataLayer\DTOs\AtualizarAutorDto;
use App\DataLayer\DTOs\ListarAutoresDto;

// Importo features
use App\BusinessLayer\Features\Autores\CriarAutorFeature;
use App\BusinessLayer\Features\Autores\AtualizarAutorFeature;
use App\BusinessLayer\Features\Autores\ListarAutoresFeature;
use App\BusinessLayer\Features\Autores\VerAutorFeature;
use App\BusinessLayer\Features\Autores\ApagarAutorFeature;

// Importo helpers
use App\Helpers\ValidacaoHelper;
use App\Helpers\QueryHelper;

class AutorController extends Controller {

    // Defino variaveis
    private $criarAutorFeature;
    private $atualizarAutorFeature;
    private $listarAutoresFeature;
    private $verAutorFeature;
    private $apagarAutorFeature;

    /**
     * 
     * Método construtor
     * 
     * @access public
     * @param CriarAutorFeature $criarAutorFeature
     * @param AtualizarAutorFeature $atualizarAutorFeature
     * @param ListarAutoresFeature $listarAutoresFeature
     * @param VerAutorFeature $verAutorFeature
     * @param ApagarAutorFeature $apagarAutorFeature
     * @return void
     * 
     */
    public function __construct(
        CriarAutorFeature $criarAutorFeature,
        AtualizarAutorFeature $atualizarAutorFeature,
        ListarAutoresFeature $listarAutoresFeature,
        VerAutorFeature $verAutorFeature,
        ApagarAutorFeature $apagarAutorFeature
    ) {

        // Instancio features
        $this->criarAutorFeature = $criarAutorFeature;
        $this->atualizarAutorFeature = $atualizarAutorFeature;
        $this->listarAutoresFeature = $listarAutoresFeature;
        $this->verAutorFeature = $verAutorFeature;
        $this->apagarAutorFeature = $apagarAutorFeature;

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

            // Gero DTO para listagem de autores
            $listarAutoresDto = ListarAutoresDto::fromArray($dados);

            // Obtenho lista de autores
            $autores = $this->listarAutoresFeature->execute($listarAutoresDto);

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
        ])->merge($autores);

        // Retorno Sucesso
        return response()->json($resposta, ResponseHttpCode::OK);

    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        // Capto dados da requisição
        $dados = $request->only([      
            'nome',
            'data_nascimento',
            'website',
            'twitter',
            'cod_pais'
        ]);

        try {

            // Gero DTO para criação do autor
            $criarAutorDto = CriarAutorDto::fromArray($dados);

            // Crio um novo autor
            $autor = $this->criarAutorFeature->execute($criarAutorDto);

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
            'message' => 'Autor criado com sucesso',
            'data' => $autor
        ), ResponseHttpCode::OK);

    }



    /**
     * Display the specified resource.
     *
     * @param int $codAutor
     * @return \Illuminate\Http\Response
     */
    public function show($codAutor) {

        try {

            // Obtenho dados de autor especifico
            $autor = $this->verAutorFeature->execute($codAutor);

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
            'data' => $autor
        ), ResponseHttpCode::OK);

    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $codAutor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $codAutor) {

        // Capto dados da requisição
        $dados = $request->only([       
            'nome',
            'data_nascimento',
            'website',
            'twitter',
            'cod_pais'
        ]); 

        try {

            // Adicionamos código ao array
            $dados['cod_autor'] = $codAutor;

            // Gero DTO para atualização do autor
            $atualizarAutorDto = AtualizarAutorDto::fromArray($dados);

            // Atualizo informações do autor
            $autor = $this->atualizarAutorFeature->execute($atualizarAutorDto);

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
            'message' => 'Autor atualizado com sucesso',
            'data' => $autor
        ), ResponseHttpCode::OK);

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param int $codAutor
     * @return \Illuminate\Http\Response
     */
    public function destroy($codAutor) {
        
        try {

            // Apago autor especifico
            $apagar = $this->apagarAutorFeature->execute($codAutor);

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
            'message' => 'Autor removido com sucesso',
            'data' => null
        ), ResponseHttpCode::OK);

    }



}

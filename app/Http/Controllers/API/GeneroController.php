<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\CriarGeneroDto;
use App\DataLayer\DTOs\AtualizarGeneroDto;
use App\DataLayer\DTOs\ListarGenerosDto;

// Importo features
use App\BusinessLayer\Features\Generos\CriarGeneroFeature;
use App\BusinessLayer\Features\Generos\AtualizarGeneroFeature;
use App\BusinessLayer\Features\Generos\ListarGenerosFeature;
use App\BusinessLayer\Features\Generos\VerGeneroFeature;
use App\BusinessLayer\Features\Generos\ApagarGeneroFeature;

// Importo helpers
use App\Helpers\ValidacaoHelper;
use App\Helpers\QueryHelper;

class GeneroController extends Controller {

    // Defino variaveis
    private $criarGeneroFeature;
    private $atualizarGeneroFeature;
    private $listarGenerosFeature;
    private $verGeneroFeature;
    private $apagarGeneroFeature;

    /**
     * 
     * Método construtor
     * 
     * @access public
     * @param CriarGeneroFeature $criarGeneroFeature
     * @param AtualizarGeneroFeature $atualizarGeneroFeature
     * @param ListarGenerosFeature $listarGenerosFeature
     * @param VerGeneroFeature $verGeneroFeature
     * @param ApagarGeneroFeature $apagarGeneroFeature
     * @return void
     * 
     */
    public function __construct(
        CriarGeneroFeature $criarGeneroFeature,
        AtualizarGeneroFeature $atualizarGeneroFeature,
        ListarGenerosFeature $listarGenerosFeature,
        VerGeneroFeature $verGeneroFeature,
        ApagarGeneroFeature $apagarGeneroFeature
    ) {

        // Instancio features
        $this->criarGeneroFeature = $criarGeneroFeature;
        $this->atualizarGeneroFeature = $atualizarGeneroFeature;
        $this->listarGenerosFeature = $listarGenerosFeature;
        $this->verGeneroFeature = $verGeneroFeature;
        $this->apagarGeneroFeature = $apagarGeneroFeature;

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

            // Gero DTO para listagem de gêneros
            $listarGenerosDto = ListarGenerosDto::fromArray($dados);

            // Obtenho lista de gêneros
            $generos = $this->listarGenerosFeature->execute($listarGenerosDto);

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
        ])->merge($generos);

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
            'nome'
        ]);

        try {

            // Gero DTO para criação do gênero
            $criarGeneroDto = CriarGeneroDto::fromArray($dados);

            // Crio um novo gênero
            $genero = $this->criarGeneroFeature->execute($criarGeneroDto);

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
            'message' => 'Gênero criado com sucesso',
            'data' => $genero
        ), ResponseHttpCode::OK);

    }



    /**
     * Display the specified resource.
     *
     * @param int $codGenero
     * @return \Illuminate\Http\Response
     */
    public function show($codGenero) {

        try {

            // Obtenho dados de gênero especifico
            $genero = $this->verGeneroFeature->execute($codGenero);

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
            'data' => $genero
        ), ResponseHttpCode::OK);

    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $codGenero
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $codGenero) {

        // Capto dados da requisição
        $dados = $request->only([       
            'nome'
        ]); 

        try {

            // Adicionamos código ao array
            $dados['cod_genero'] = $codGenero;

            // Gero DTO para atualização do gênero
            $atualizarGeneroDto = AtualizarGeneroDto::fromArray($dados);

            // Atualizo informações do gênero
            $genero = $this->atualizarGeneroFeature->execute($atualizarGeneroDto);

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
            'message' => 'Gênero atualizado com sucesso',
            'data' => $genero
        ), ResponseHttpCode::OK);

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param int $codGenero
     * @return \Illuminate\Http\Response
     */
    public function destroy($codGenero) {
        
        try {

            // Apago gênero especifico
            $apagar = $this->apagarGeneroFeature->execute($codGenero);

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
            'message' => 'Gênero removido com sucesso',
            'data' => null
        ), ResponseHttpCode::OK);

    }



}

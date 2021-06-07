<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\CriarSerieDto;
use App\DataLayer\DTOs\AtualizarSerieDto;
use App\DataLayer\DTOs\ListarSeriesDto;

// Importo features
use App\BusinessLayer\Features\Series\CriarSerieFeature;
use App\BusinessLayer\Features\Series\AtualizarSerieFeature;
use App\BusinessLayer\Features\Series\ListarSeriesFeature;
use App\BusinessLayer\Features\Series\VerSerieFeature;
use App\BusinessLayer\Features\Series\ApagarSerieFeature;

// Importo helpers
use App\Helpers\ValidacaoHelper;
use App\Helpers\QueryHelper;

class SerieController extends Controller {

    // Defino variaveis
    private $criarSerieFeature;
    private $atualizarSerieFeature;
    private $listarSeriesFeature;
    private $verSerieFeature;
    private $apagarSerieFeature;

    /**
     * 
     * Método construtor
     * 
     * @access public
     * @param CriarSerieFeature $criarSerieFeature
     * @param AtualizarSerieFeature $atualizarSerieFeature
     * @param ListarSeriesFeature $listarSeriesFeature
     * @param VerSerieFeature $verSerieFeature
     * @param ApagarSerieFeature $apagarSerieFeature
     * @return void
     * 
     */
    public function __construct(
        CriarSerieFeature $criarSerieFeature,
        AtualizarSerieFeature $atualizarSerieFeature,
        ListarSeriesFeature $listarSeriesFeature,
        VerSerieFeature $verSerieFeature,
        ApagarSerieFeature $apagarSerieFeature
    ) {

        // Instancio features
        $this->criarSerieFeature = $criarSerieFeature;
        $this->atualizarSerieFeature = $atualizarSerieFeature;
        $this->listarSeriesFeature = $listarSeriesFeature;
        $this->verSerieFeature = $verSerieFeature;
        $this->apagarSerieFeature = $apagarSerieFeature;

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
            $listarSeriesDto = ListarSeriesDto::fromArray($dados);

            // Obtenho lista de séries
            $series = $this->listarSeriesFeature->execute($listarSeriesDto);

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
        ])->merge($series);

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
            'titulo'
        ]);

        try {

            // Gero DTO para criação da série
            $criarSerieDto = CriarSerieDto::fromArray($dados);

            // Crio uma nova série
            $serie = $this->criarSerieFeature->execute($criarSerieDto);

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
            'message' => 'Série criada com sucesso',
            'data' => $serie
        ), ResponseHttpCode::OK);

    }



    /**
     * Display the specified resource.
     *
     * @param int $codSerie
     * @return \Illuminate\Http\Response
     */
    public function show($codSerie) {

        try {

            // Obtenho dados de série especifica
            $serie = $this->verSerieFeature->execute($codSerie);

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
            'data' => $serie
        ), ResponseHttpCode::OK);

    }



    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request  $request
     * @param int $codSerie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $codSerie) {

        // Capto dados da requisição
        $dados = $request->only([       
            'titulo'
        ]); 

        try {

            // Adicionamos código ao array
            $dados['cod_serie'] = $codSerie;

            // Gero DTO para atualização da série
            $atualizarSerieDto = AtualizarSerieDto::fromArray($dados);

            // Atualizo informações da série
            $serie = $this->atualizarSerieFeature->execute($atualizarSerieDto);

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
            'message' => 'Série atualizada com sucesso',
            'data' => $serie
        ), ResponseHttpCode::OK);

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param int $codSerie
     * @return \Illuminate\Http\Response
     */
    public function destroy($codSerie) {
        
        try {

            // Apago série especifica
            $apagar = $this->apagarSerieFeature->execute($codSerie);

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
            'message' => 'Série removida com sucesso',
            'data' => null
        ), ResponseHttpCode::OK);

    }



}

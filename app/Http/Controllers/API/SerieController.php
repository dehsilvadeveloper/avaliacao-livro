<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\CriarSerieDTO;
use App\DataLayer\DTOs\AtualizarSerieDTO;

// Importo features
use App\BusinessLayer\Features\Series\CriarSerieFeature;
use App\BusinessLayer\Features\Series\AtualizarSerieFeature;
use App\BusinessLayer\Features\Series\ListarSeriesFeature;
use App\BusinessLayer\Features\Series\VerSerieFeature;
use App\BusinessLayer\Features\Series\ApagarSerieFeature;

// Importo helpers
use App\Helpers\ValidacaoHelper;

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
     * @return \Illuminate\Http\Response
     */
    public function index() {
        
        try {

            // Obtenho lista de séries
            $series = $this->listarSeriesFeature->execute();

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
                'series' => $series
            )
        ), ResponseHttpCode::OK);

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
                'data' => null
            ), $codigoErro);

        }

        // Retorno Sucesso
        return response()->json(array(
            'success' => true,
            'message' => 'Série criada com sucesso',
            'data' => array(
                'serie' => $serie
            )
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
                'data' => null
            ), $codigoErro);

        }

        // Retorno Sucesso
        return response()->json(array(
            'success' => true,
            'message' => null,
            'data' => array(
                'serie' => $serie
            )
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

            // Gero DTO para atualização da série
            $atualizarSerieDto = AtualizarSerieDto::fromArray($dados);

            // Atualizo informações da série
            $serie = $this->atualizarSerieFeature->execute($codSerie, $atualizarSerieDto);

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
            'message' => 'Série atualizada com sucesso',
            'data' => array(
                'serie' => $serie
            )
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

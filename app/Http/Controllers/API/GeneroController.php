<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\CriarGeneroDTO;
use App\DataLayer\DTOs\AtualizarGeneroDTO;

// Importo features
use App\BusinessLayer\Features\Generos\CriarGeneroFeature;
use App\BusinessLayer\Features\Generos\AtualizarGeneroFeature;
use App\BusinessLayer\Features\Generos\ListarGenerosFeature;
use App\BusinessLayer\Features\Generos\VerGeneroFeature;
use App\BusinessLayer\Features\Generos\ApagarGeneroFeature;

// Importo helpers
use App\Helpers\ValidacaoHelper;

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

    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        try {

            // Obtenho lista de gêneros
            $generos = $this->listarGenerosFeature->execute();

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
                'generos' => $generos
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
                'data' => null
            ), $codigoErro);

        }

        // Retorno Sucesso
        return response()->json(array(
            'success' => true,
            'message' => 'Gênero criado com sucesso',
            'data' => array(
                'genero' => $genero
            )
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
                'data' => null
            ), $codigoErro);

        }

        // Retorno Sucesso
        return response()->json(array(
            'success' => true,
            'message' => null,
            'data' => array(
                'genero' => $genero
            )
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

            // Gero DTO para atualização do gênero
            $atualizarGeneroDto = AtualizarGeneroDto::fromArray($dados);

            // Atualizo informações do gênero
            $genero = $this->atualizarGeneroFeature->execute($codGenero, $atualizarGeneroDto);

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
            'message' => 'Gênero atualizado com sucesso',
            'data' => array(
                'genero' => $genero
            )
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

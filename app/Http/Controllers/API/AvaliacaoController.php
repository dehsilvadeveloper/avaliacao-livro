<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\AtualizarAvaliacaoDto;

// Importo features
use App\BusinessLayer\Features\Avaliacoes\AtualizarAvaliacaoFeature;
use App\BusinessLayer\Features\Avaliacoes\VerAvaliacaoFeature;
use App\BusinessLayer\Features\Avaliacoes\ApagarAvaliacaoFeature;

// Importo helpers
use App\Helpers\ValidacaoHelper;

class AvaliacaoController extends Controller {

    // Defino variaveis
    private $atualizarAvaliacaoFeature;
    private $verAvaliacaoFeature;
    private $apagarAvaliacaoFeature;

    /**
     * 
     * Método construtor
     * 
     * @access public
     * @param AtualizarAvaliacaoFeature $atualizarAvaliacaoFeature
     * @param VerAvaliacaoFeature $verAvaliacaoFeature
     * @param ApagarAvaliacaoFeature $apagarAvaliacaoFeature
     * @return void
     * 
     */
    public function __construct(
        AtualizarAvaliacaoFeature $atualizarAvaliacaoFeature,
        VerAvaliacaoFeature $verAvaliacaoFeature,
        ApagarAvaliacaoFeature $apagarAvaliacaoFeature
    ) {

        // Instancio features
        $this->atualizarAvaliacaoFeature = $atualizarAvaliacaoFeature;
        $this->verAvaliacaoFeature = $verAvaliacaoFeature;
        $this->apagarAvaliacaoFeature = $apagarAvaliacaoFeature;

        // Defino que todas as rotas/métodos deste controller estarão protegidas pelo middleware de autenticação
        // Quaisquer rotas dentro da opção EXCEPT() ficarão FORA da proteção do middleware, ou seja, serão PÚBLICAS
        $this->middleware('auth:sanctum')->except(['show']);

    }



    /**
     * Display the specified resource.
     *
     * @param int $codAvaliacao
     * @return \Illuminate\Http\Response
     */
    public function show($codAvaliacao) {

        try {

            // Obtenho dados de avaliação especifica
            $avaliacao = $this->verAvaliacaoFeature->execute($codAvaliacao);

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
            'data' => $avaliacao
        ), ResponseHttpCode::OK);

    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $codAvaliacao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $codAvaliacao) {

        // Capto dados da requisição
        $dados = $request->only([       
            'nota',
            'review'
        ]); 

        try {

            // Adicionamos código ao array
            $dados['cod_avaliacao'] = $codAvaliacao;

            // Gero DTO para atualização da avaliação
            $atualizarAvaliacaoDto = AtualizarAvaliacaoDto::fromArray($dados);

            // Atualizo informações da avaliação
            $avaliacao = $this->atualizarAvaliacaoFeature->execute($atualizarAvaliacaoDto);

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
            'message' => 'Avaliação atualizada com sucesso',
            'data' => $avaliacao
        ), ResponseHttpCode::OK);

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param int $codAvaliacao
     * @return \Illuminate\Http\Response
     */
    public function destroy($codAvaliacao) {
        
        try {

            // Apago avaliação especifica
            $apagar = $this->apagarAvaliacaoFeature->execute($codAvaliacao);

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
            'message' => 'Avaliação removida com sucesso',
            'data' => null
        ), ResponseHttpCode::OK);

    }



}

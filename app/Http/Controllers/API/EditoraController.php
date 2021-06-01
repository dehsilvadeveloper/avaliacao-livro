<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\CriarEditoraDTO;
use App\DataLayer\DTOs\AtualizarEditoraDTO;

// Importo features
use App\BusinessLayer\Features\Editoras\CriarEditoraFeature;
use App\BusinessLayer\Features\Editoras\AtualizarEditoraFeature;
use App\BusinessLayer\Features\Editoras\ListarEditorasFeature;
use App\BusinessLayer\Features\Editoras\VerEditoraFeature;
use App\BusinessLayer\Features\Editoras\ApagarEditoraFeature;

// Importo helpers
use App\Helpers\ValidacaoHelper;

class EditoraController extends Controller {

    // Defino variaveis
    private $criarEditoraFeature;
    private $atualizarEditoraFeature;
    private $listarEditorasFeature;
    private $verEditoraFeature;
    private $apagarEditoraFeature;

    /**
     * 
     * Método construtor
     * 
     * @access public
     * @param CriarEditoraFeature $criarEditoraFeature
     * @param AtualizarEditoraFeature $atualizarEditoraFeature
     * @param ListarEditorasFeature $listarEditorasFeature
     * @param VerEditoraFeature $verEditoraFeature
     * @param ApagarEditoraFeature $apagarEditoraFeature
     * @return void
     * 
     */
    public function __construct(
        CriarEditoraFeature $criarEditoraFeature,
        AtualizarEditoraFeature $atualizarEditoraFeature,
        ListarEditorasFeature $listarEditorasFeature,
        VerEditoraFeature $verEditoraFeature,
        ApagarEditoraFeature $apagarEditoraFeature
    ) {

        // Instancio features
        $this->criarEditoraFeature = $criarEditoraFeature;
        $this->atualizarEditoraFeature = $atualizarEditoraFeature;
        $this->listarEditorasFeature = $listarEditorasFeature;
        $this->verEditoraFeature = $verEditoraFeature;
        $this->apagarEditoraFeature = $apagarEditoraFeature;

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

            // Obtenho lista de editoras
            $editoras = $this->listarEditorasFeature->execute();

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
                'editoras' => $editoras
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
            'nome_fantasia',
            'website'
        ]);

        try {

            // Gero DTO para criação da editora
            $criarEditoraDto = CriarEditoraDto::fromArray($dados);

            // Crio uma nova editora
            $editora = $this->criarEditoraFeature->execute($criarEditoraDto);

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
            'message' => 'Editora criada com sucesso',
            'data' => array(
                'editora' => $editora
            )
        ), ResponseHttpCode::OK);

    }



    /**
     * Display the specified resource.
     *
     * @param int $codEditora
     * @return \Illuminate\Http\Response
     */
    public function show($codEditora) {

        try {

            // Obtenho dados de editora especifica
            $editora = $this->verEditoraFeature->execute($codEditora);

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
                'editora' => $editora
            )
        ), ResponseHttpCode::OK);

    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $codEditora
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $codEditora) {

        // Capto dados da requisição
        $dados = $request->only([       
            'nome_fantasia',
            'website'
        ]); 

        try {

            // Gero DTO para atualização da editora
            $atualizarEditoraDto = AtualizarEditoraDto::fromArray($dados);

            // Atualizo informações da editora
            $editora = $this->atualizarEditoraFeature->execute($codEditora, $atualizarEditoraDto);

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
            'message' => 'Editora atualizada com sucesso',
            'data' => array(
                'editora' => $editora
            )
        ), ResponseHttpCode::OK);

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param int $codEditora
     * @return \Illuminate\Http\Response
     */
    public function destroy($codEditora) {
        
        try {

            // Apago editora especifica
            $apagar = $this->apagarEditoraFeature->execute($codEditora);

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
            'message' => 'Editora removida com sucesso',
            'data' => null
        ), ResponseHttpCode::OK);

    }



}

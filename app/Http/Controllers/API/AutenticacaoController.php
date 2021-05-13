<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\EfetuarLoginDTO;

// Importo features
use App\BusinessLayer\Features\Autenticacoes\EfetuarLoginFeature;
use App\BusinessLayer\Features\Autenticacoes\EfetuarLogoutFeature;
use App\BusinessLayer\Features\Autenticacoes\VerUsuarioAutenticadoFeature;

// Importo helpers
use App\Helpers\ValidacaoHelper;

class AutenticacaoController extends Controller {

    // Defino variaveis
    private $efetuarLoginFeature;
    private $efetuarLogoutFeature;
    private $verUsuarioAutenticadoFeature;

    /**
     * 
     * Método construtor
     * 
     * @access public
     * @param EfetuarLoginFeature $efetuarLoginFeature,
     * @param EfetuarLogoutFeature $efetuarLogoutFeature,
     * @param VerUsuarioAutenticadoFeature $verUsuarioAutenticadoFeature
     * @return void
     * 
     */
    public function __construct(
        EfetuarLoginFeature $efetuarLoginFeature,
        EfetuarLogoutFeature $efetuarLogoutFeature,
        VerUsuarioAutenticadoFeature $verUsuarioAutenticadoFeature
    ) {

        // Instancio features
        $this->efetuarLoginFeature = $efetuarLoginFeature;
        $this->efetuarLogoutFeature = $efetuarLogoutFeature;
        $this->verUsuarioAutenticadoFeature = $verUsuarioAutenticadoFeature;

        // Defino que todas as rotas/métodos deste controller estarão protegidas pelo middleware de autenticação
        // Quaisquer rotas dentro da opção EXCEPT() ficarão FORA da proteção do middleware, ou seja, serão PÚBLICAS
        $this->middleware('auth:sanctum')->except(['store']);

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
            'usuario',
            'password'
        ]);

        try {

            // Gero DTO para autenticação de usuário
            $efetuarLoginDto = EfetuarLoginDTO::fromArray($dados);

            // Executo autenticação
            $autenticacao = $this->efetuarLoginFeature->execute($efetuarLoginDto);

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
            'message' => 'Autenticado com sucesso',
            'data' => array(
                'token' => $autenticacao->token,
                'token_type' => 'Bearer',
                'usuario' => $autenticacao->usuario
            )
        ), ResponseHttpCode::OK);

    }



    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show() {

        try {

            // Localizo informações do usuário autenticado
            $usuarioAutenticado = $this->verUsuarioAutenticadoFeature->execute();

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
                'usuario' => $usuarioAutenticado
            )
        ), ResponseHttpCode::OK);

    }



    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy() {

        try {

            // Efetuo logout
            $logout = $this->efetuarLogoutFeature->execute();

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
            'message' => 'Desconectado com sucesso',
            'data' => null
        ), ResponseHttpCode::OK);

    }



}

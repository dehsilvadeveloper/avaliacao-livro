<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\CriarAutorDTO;
use App\DataLayer\DTOs\AtualizarAutorDTO;

// Importo features
use App\BusinessLayer\Features\Autores\CriarAutorFeature;
use App\BusinessLayer\Features\Autores\AtualizarAutorFeature;
use App\BusinessLayer\Features\Autores\ListarAutoresFeature;
use App\BusinessLayer\Features\Autores\VerAutorFeature;
use App\BusinessLayer\Features\Autores\ApagarAutorFeature;

// Importo helpers
use App\Helpers\ValidacaoHelper;

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

    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        
        try {

            // Obtenho lista de autores
            $autores = $this->listarAutoresFeature->execute();

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
                'autores' => $autores
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
                'data' => null
            ), $codigoErro);

        }

        // Retorno Sucesso
        return response()->json(array(
            'success' => true,
            'message' => 'Autor criado com sucesso',
            'data' => array(
                'autor' => $autor
            )
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
                'data' => null
            ), $codigoErro);

        }

        // Retorno Sucesso
        return response()->json(array(
            'success' => true,
            'message' => null,
            'data' => array(
                'autor' => $autor
            )
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

            // Gero DTO para atualização do autor
            $atualizarAutorDto = AtualizarAutorDto::fromArray($dados);

            // Atualizo informações do autor
            $autor = $this->atualizarAutorFeature->execute($codAutor, $atualizarAutorDto);

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
            'message' => 'Autor atualizado com sucesso',
            'data' => array(
                'autor' => $autor
            )
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

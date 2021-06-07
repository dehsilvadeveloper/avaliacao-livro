<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\CriarAvaliacaoDto;
use App\DataLayer\DTOs\ListarAvaliacoesDeLivroDto;

// Importo features
use App\BusinessLayer\Features\Avaliacoes\CriarAvaliacaoFeature;
use App\BusinessLayer\Features\Avaliacoes\ListarAvaliacoesDeLivroFeature;

// Importo helpers
use App\Helpers\ValidacaoHelper;
use App\Helpers\QueryHelper;

class AvaliacaoDeLivroController extends Controller {

    // Defino variaveis
    private $criarAvaliacaoFeature;
    private $listarAvaliacoesDeLivroFeature;

    /**
     * 
     * Método construtor
     * 
     * @access public
     * @param CriarAvaliacaoFeature $criarAvaliacaoFeature
     * @param ListarAvaliacoesDeLivroFeature $listarAvaliacoesDeLivroFeature
     * @return void
     * 
     */
    public function __construct(
        CriarAvaliacaoFeature $criarAvaliacaoFeature,
        ListarAvaliacoesDeLivroFeature $listarAvaliacoesDeLivroFeature
    ) {

        // Instancio features
        $this->criarAvaliacaoFeature = $criarAvaliacaoFeature;
        $this->listarAvaliacoesDeLivroFeature = $listarAvaliacoesDeLivroFeature;

        // Defino que todas as rotas/métodos deste controller estarão protegidas pelo middleware de autenticação
        // Quaisquer rotas dentro da opção EXCEPT() ficarão FORA da proteção do middleware, ou seja, serão PÚBLICAS
        $this->middleware('auth:sanctum')->except(['index']);

    }



    /**
     * Display a listing of the resource.
     *
     * @param int $codLivro
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index($codLivro, Request $request) {

        // Capto dados da requisição
        $dados = $request->only([     
            'page',  
            'page_size',
            'sort'
        ]); 

        try {

            // Adicionamos código ao array
            $dados['cod_livro'] = $codLivro;

            // Convertemos de string para array de ordenação de query
            $dados['sort'] = QueryHelper::converterStringParaArrayDeOrdenacaoDeQuery($dados['sort']);

            // Gero DTO para listagem de avaliações de livros
            $listarAvaliacoesDeLivroDto = ListarAvaliacoesDeLivroDto::fromArray($dados);

            // Obtenho lista de avaliações de livro
            $avaliacoes = $this->listarAvaliacoesDeLivroFeature->execute($listarAvaliacoesDeLivroDto);

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
        ])->merge($avaliacoes);

        // Retorno Sucesso
        return response()->json($resposta, ResponseHttpCode::OK);
        
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $codLivro
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $codLivro) {

        // Capto dados da requisição
        $dados = $request->only([
            'cod_usuario',
            'nota',
            'review'
        ]);

        // Adicionamos o código do livro ao array
        $dados['cod_livro'] = $codLivro;

        try {

            // Gero DTO para criação de avaliação
            $criarAvaliacaoDto = CriarAvaliacaoDto::fromArray($dados);

            // Crio uma nova avaliação de livro
            $avaliacao = $this->criarAvaliacaoFeature->execute($criarAvaliacaoDto);

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
            'message' => 'Avaliação criada com sucesso',
            'data' => $avaliacao
        ), ResponseHttpCode::OK);

    }



}

<?php
namespace App\BusinessLayer\Features\Livros;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\CriarLivroDTO;

// Importo validators
use App\BusinessLayer\Validators\Livros\CriarLivroValidator;

// Importo actions
use App\BusinessLayer\Actions\Livros\CriarLivroAction;
use App\BusinessLayer\Actions\AutoresLivros\VincularAutoresDeLivroAction;
use App\BusinessLayer\Actions\GenerosLivros\VincularGenerosDeLivroAction;
use App\BusinessLayer\Actions\SeriesLivros\VincularSeriesDeLivroAction;

// Importo resources
use App\Http\Resources\LivroResource;

class CriarLivroFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $criarLivroAction;
    private $vincularAutoresDeLivroAction;
    private $vincularGenerosDeLivroAction;
    private $vincularSeriesDeLivroAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param CriarLivroAction $criarLivroAction
     * @param VincularAutoresDeLivroAction $vincularAutoresDeLivroAction
     * @param VincularGenerosDeLivroAction $vincularGenerosDeLivroAction
     * @param VincularSeriesDeLivroAction $vincularSeriesDeLivroAction
     * @return void
     */
    public function __construct(
        CriarLivroAction $criarLivroAction,
        VincularAutoresDeLivroAction $vincularAutoresDeLivroAction,
        VincularGenerosDeLivroAction $vincularGenerosDeLivroAction,
        VincularSeriesDeLivroAction $vincularSeriesDeLivroAction
    ) {

        // Instancio actions
        $this->criarLivroAction = $criarLivroAction;
        $this->vincularAutoresDeLivroAction = $vincularAutoresDeLivroAction;
        $this->vincularGenerosDeLivroAction = $vincularGenerosDeLivroAction;
        $this->vincularSeriesDeLivroAction = $vincularSeriesDeLivroAction;

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @param CriarLivroDTO $criarLivroDto
     * @return LivroResource
     */
    public function execute(CriarLivroDTO $criarLivroDto) : LivroResource {

        // Converto objeto para array
        $dados = $criarLivroDto->toArray();

        // Validação de dados obrigatórios
        $validador = new CriarLivroValidator;
        $validador->execute($dados);

        // Caso os dados NÃO SEJAM válidos
        if (!$validador->estaLiberado()) {

            // Erro de validação
            throw new \InvalidArgumentException(
                $validador->pegarErros(),
                ResponseHttpCode::DATA_VALIDATION_FAILED
            );

        }

        // Crio novo livro
        $livro = $this->criarLivroAction->execute($criarLivroDto);

        // Vinculo AUTORES do livro
        $vinculoAutoresLivro = $this->vincularAutoresDeLivroAction->execute($livro->cod_livro, $dados['autores']);

        // Vinculo GÊNEROS do livro
        $vinculoGenerosLivro = $this->vincularGenerosDeLivroAction->execute($livro->cod_livro, $dados['generos']);

        // Caso tenham sido informadas SÉRIES para serem vinculadas ao livro
        if (isset($dados['series']) and $dados['series'] != '') {

            // Vinculo SÉRIES do livro
            $vinculoSeriesLivro = $this->vincularSeriesDeLivroAction->execute($livro->cod_livro, $dados['series']);

        }

        // Retorno
        return new LivroResource($livro);

    }



}

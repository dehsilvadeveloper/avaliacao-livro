<?php
namespace App\BusinessLayer\Features\Livros;

use App\BusinessLayer\ResponseHttpCode;

// Importo DTOs
use App\DataLayer\DTOs\AtualizarLivroDTO;

// Importo validators
use App\BusinessLayer\Validators\Livros\AtualizarLivroValidator;

// Importo actions
use App\BusinessLayer\Actions\Livros\AtualizarLivroAction;
use App\BusinessLayer\Actions\AutoresLivros\SincronizarAutoresDeLivroAction;
use App\BusinessLayer\Actions\GenerosLivros\SincronizarGenerosDeLivroAction;
use App\BusinessLayer\Actions\SeriesLivros\SincronizarSeriesDeLivroAction;

// Importo resources
use App\Http\Resources\LivroResource;

class AtualizarLivroFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $atualizarLivroAction;
    private $sincronizarAutoresDeLivroAction;
    private $sincronizarGenerosDeLivroAction;
    private $sincronizarSeriesDeLivroAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param AtualizarLivroAction $atualizarLivroAction
     * @param SincronizarAutoresDeLivroAction $sincronizarAutoresDeLivroAction
     * @param SincronizarGenerosDeLivroAction $sincronizarGenerosDeLivroAction
     * @param SincronizarSeriesDeLivroAction $sincronizarSeriesDeLivroAction
     * @return void
     * 
     */
    public function __construct(
        AtualizarLivroAction $atualizarLivroAction,
        SincronizarAutoresDeLivroAction $sincronizarAutoresDeLivroAction,
        SincronizarGenerosDeLivroAction $sincronizarGenerosDeLivroAction,
        SincronizarSeriesDeLivroAction $sincronizarSeriesDeLivroAction
    ) {

        // Instancio actions
        $this->atualizarLivroAction = $atualizarLivroAction;
        $this->sincronizarAutoresDeLivroAction = $sincronizarAutoresDeLivroAction;
        $this->sincronizarGenerosDeLivroAction = $sincronizarGenerosDeLivroAction;
        $this->sincronizarSeriesDeLivroAction = $sincronizarSeriesDeLivroAction;

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @param int $codLivro
     * @param AtualizarLivroDTO $atualizarLivroDto
     * @return LivroResource
     * 
     */
    public function execute(int $codLivro, AtualizarLivroDTO $atualizarLivroDto) : LivroResource {

        // Converto objeto para array
        $dados = $atualizarLivroDto->toArray();

        // Validação de dados obrigatórios
        $validador = new AtualizarLivroValidator;
        $validador->execute($codLivro, $dados);

        // Caso os dados NÃO SEJAM válidos
        if (!$validador->estaLiberado()) {

            // Erro de validação
            throw new \InvalidArgumentException(
                $validador->pegarErros(),
                ResponseHttpCode::DATA_VALIDATION_FAILED
            );

        }

        // Atualizo informações do livro
        $livro = $this->atualizarLivroAction->execute($codLivro, $atualizarLivroDto);

        // Sincronizo AUTORES do livro
        $sincroniaAutoresLivro = $this->sincronizarAutoresDeLivroAction->execute($livro->cod_livro, $dados['autores']);

        // Sincronizo GÊNEROS do livro
        $sincroniaGenerosLivro = $this->sincronizarGenerosDeLivroAction->execute($livro->cod_livro, $dados['generos']);

        // Sincronizo SÉRIES do livro
        $sincroniaSeriesLivro = $this->sincronizarSeriesDeLivroAction->execute($livro->cod_livro, $dados['series']);

        // Retorno
        return new LivroResource($livro);

    }



}
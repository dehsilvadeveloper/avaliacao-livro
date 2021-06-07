<?php
namespace App\BusinessLayer\Features\Livros;

use App\BusinessLayer\ResponseHttpCode;
use App\Exceptions\CamposObrigatoriosInvalidosException;

// Importo DTOs
use App\DataLayer\DTOs\AtualizarLivroDto;

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
     * @param AtualizarLivroDto $atualizarLivroDto
     * @return LivroResource
     * 
     */
    public function execute(AtualizarLivroDto $atualizarLivroDto) : LivroResource {

        // Converto objeto para array
        $dados = $atualizarLivroDto->toArray();

        // Validação de dados obrigatórios
        $validador = new AtualizarLivroValidator;
        $validador->execute($dados['cod_livro'], $dados);

        // Caso os dados NÃO SEJAM válidos
        if (!$validador->estaLiberado()) {

            // Erro de validação
            throw new CamposObrigatoriosInvalidosException(
                'Dados informados são inválidos', 
                $validador->pegarErros()
            );

        }

        // Atualizo informações do livro
        $livro = $this->atualizarLivroAction->execute($atualizarLivroDto);

        // Sincronizo AUTORES do livro
        $sincroniaAutoresLivro = $this->sincronizarAutoresDeLivroAction->execute($livro->cod_livro, $dados['autores']);

        // Sincronizo GÊNEROS do livro
        $sincroniaGenerosLivro = $this->sincronizarGenerosDeLivroAction->execute($livro->cod_livro, $dados['generos']);

        // Caso tenham sido informadas SÉRIES para serem vinculadas ao livro
        if (isset($dados['series']) and $dados['series'] != '') {

            // Faço loop pela lista de séries
            foreach ($dados['series'] as $s) :

                // Formato array que possibilita inserção das séries e de seus dados de extras de pivot de maneira conjunta
                $seriesParaSincronizar[$s['cod_serie']] = [
                    'numero_na_serie' => $s['numero_na_serie']
                ];

            endforeach;

            // Sincronizo SÉRIES do livro
            $sincroniaSeriesLivro = $this->sincronizarSeriesDeLivroAction->execute($livro->cod_livro, $seriesParaSincronizar);

        }

        // Retorno
        return new LivroResource($livro);

    }



}

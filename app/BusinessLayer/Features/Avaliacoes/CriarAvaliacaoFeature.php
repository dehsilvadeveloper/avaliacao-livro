<?php
namespace App\BusinessLayer\Features\Avaliacoes;

use App\BusinessLayer\ResponseHttpCode;
use App\Exceptions\CamposObrigatoriosInvalidosException;

// Importo DTOs
use App\DataLayer\DTOs\CriarAvaliacaoDTO;

// Importo validators
use App\BusinessLayer\Validators\Avaliacoes\CriarAvaliacaoValidator;

// Importo actions
use App\BusinessLayer\Actions\Avaliacoes\CriarAvaliacaoAction;
use App\BusinessLayer\Actions\Livros\VerLivroAction;
use App\BusinessLayer\Actions\Usuarios\VerUsuarioAction;

// Importo resources
use App\Http\Resources\AvaliacaoResource;

class CriarAvaliacaoFeature {

    // Defino variaveis
    private $definition = 'Responsável por agrupar e executar uma ou mais ações que serão utilizadas num determinado propósito';
    private $criarAvaliacaoAction;
    private $verLivroAction;
    private $verUsuarioAction;

    /**
     * 
     * Método construtor
     *
     * @access public
     * @param CriarAvaliacaoAction $criarAvaliacaoAction
     * @param VerLivroAction $verLivroAction
     * @param VerUsuarioAction $verUsuarioAction
     * @return void
     * 
     */
    public function __construct(
        CriarAvaliacaoAction $criarAvaliacaoAction,
        VerLivroAction $verLivroAction,
        VerUsuarioAction $verUsuarioAction
    ) {

        // Instancio actions
        $this->criarAvaliacaoAction = $criarAvaliacaoAction;
        $this->verLivroAction = $verLivroAction;
        $this->verUsuarioAction = $verUsuarioAction;

    }



    /**
     * 
     * Executa tarefa única da classe
     *
     * @access public
     * @param CriarAvaliacaoDto $criarAvaliacaoDto
     * @return AvaliacaoResource
     * 
     */
    public function execute(CriarAvaliacaoDto $criarAvaliacaoDto) : AvaliacaoResource {

        // Converto objeto para array
        $dados = $criarAvaliacaoDto->toArray();

        // Validação de dados obrigatórios
        $validador = new CriarAvaliacaoValidator;
        $validador->execute($dados);

        // Caso os dados NÃO SEJAM válidos
        if (!$validador->estaLiberado()) {

            // Erro de validação
            throw new CamposObrigatoriosInvalidosException(
                'Dados informados são inválidos', 
                $validador->pegarErros()
            );

        }

        // Crio nova avaliação
        $avaliacao = $this->criarAvaliacaoAction->execute($criarAvaliacaoDto);

        // Retorno
        return new AvaliacaoResource($avaliacao);

    }



}

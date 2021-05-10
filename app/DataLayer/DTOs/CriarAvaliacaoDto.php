<?php
namespace App\DataLayer\DTOs;

class CriarAvaliacaoDTO {

    /**
     * @var int
     */
    private $codUsuario;

    /**
     * @var int
     */
    private $codLivro;

    /**
     * @var int
     */
    private $nota;

    /**
     * @var string
     */
    private $review;

    /**
     * Dinamicamente preenche propriedades do objeto a partir de um array
     *
     * @access public
     * @param array $dados
     * @return self
     */
    public static function fromArray(array $dados) : self {

        $self = new self();
        $self->codUsuario = $dados['cod_usuario'];
        $self->codLivro = $dados['cod_livro'];
        $self->nota = $dados['nota'];
        $self->review = $dados['review'];

        return $self;

    }



    /**
     * Retorna propriedades do objeto no formato array
     *
     * @access public
     * @return array
     */
    public function toArray() : array {

        return [
            'cod_usuario' => $this->codUsuario,
            'cod_livro' => $this->codLivro,
            'nota' => $this->nota,
            'review' => $this->review
        ];

    }



}
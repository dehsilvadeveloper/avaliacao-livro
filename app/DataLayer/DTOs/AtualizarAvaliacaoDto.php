<?php
namespace App\DataLayer\DTOs;

class AtualizarAvaliacaoDto {

    /**
     * @var int
     */
    private $codAvaliacao;

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
        $self->codAvaliacao = $dados['cod_avaliacao'];
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
            'cod_avaliacao' => $this->codAvaliacao,
            'nota' => $this->nota,
            'review' => $this->review
        ];

    }



}
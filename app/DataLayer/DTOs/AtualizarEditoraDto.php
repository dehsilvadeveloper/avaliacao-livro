<?php
namespace App\DataLayer\DTOs;

class AtualizarEditoraDto {

    /**
     * @var int
     */
    private $codEditora;

    /**
     * @var string
     */
    private $nomeFantasia;

    /**
     * @var string
     */
    private $website;

    /**
     * Dinamicamente preenche propriedades do objeto a partir de um array
     *
     * @access public
     * @param array $dados
     * @return self
     */
    public static function fromArray(array $dados) : self {

        $self = new self();
        $self->codEditora = $dados['cod_editora'];
        $self->nomeFantasia = $dados['nome_fantasia'];
        $self->website = $dados['website'];

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
            'cod_editora' => $this->codEditora,
            'nome_fantasia' => $this->nomeFantasia,
            'website' => $this->website
        ];

    }



}
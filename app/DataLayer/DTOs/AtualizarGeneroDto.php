<?php
namespace App\DataLayer\DTOs;

class AtualizarGeneroDTO {

    /**
     * @var string
     */
    private $nome;

    /**
     * Dinamicamente preenche propriedades do objeto a partir de um array
     *
     * @access public
     * @param array $dados
     * @return self
     */
    public static function fromArray(array $dados) : self {

        $self = new self();
        $self->nome = $dados['nome'];

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
            'nome' => $this->nome
        ];

    }



}
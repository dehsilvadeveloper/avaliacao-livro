<?php
namespace App\DataLayer\DTOs;

class CriarAutorDTO {

    /**
     * @var string
     */
    private $nome;

    /**
     * @var date
     */
    private $dataNascimento;

    /**
     * @var string
     */
    private $website;

    /**
     * @var string
     */
    private $twitter;

    /**
     * @var int
     */
    private $codPais;

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
        $self->dataNascimento = $dados['data_nascimento'];
        $self->website = $dados['website'];
        $self->twitter = $dados['twitter'];
        $self->codPais = $dados['cod_pais'];

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
            'nome' => $this->nome,
            'data_nascimento' => $this->dataNascimento,
            'website' => $this->website,
            'twitter' => $this->twitter,
            'cod_pais' => $this->codPais
        ];

    }



}
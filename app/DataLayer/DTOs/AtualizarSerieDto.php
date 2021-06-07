<?php
namespace App\DataLayer\DTOs;

class AtualizarSerieDto {

    /**
     * @var int
     */
    private $codSerie;

    /**
     * @var string
     */
    private $titulo;

    /**
     * Dinamicamente preenche propriedades do objeto a partir de um array
     *
     * @access public
     * @param array $dados
     * @return self
     */
    public static function fromArray(array $dados) : self {

        $self = new self();
        $self->codSerie = $dados['cod_serie'];
        $self->titulo = $dados['titulo'];

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
            'cod_serie' => $this->codSerie,
            'titulo' => $this->titulo
        ];

    }



}
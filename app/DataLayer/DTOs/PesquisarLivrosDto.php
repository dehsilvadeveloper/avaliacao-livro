<?php
namespace App\DataLayer\DTOs;

class PesquisarLivrosDto {

    /**
     * @var string
     */
    private $titulo;

    /**
     * @var string
     */
    private $tituloOriginal;

    /**
     * @var string
     */
    private $idioma;

    /**
     * @var string
     */
    private $isbn10;

    /**
     * @var string
     */
    private $isbn13;

    /**
     * @var date
     */
    private $dataPublicacao;

    /**
     * @var string
     */
    private $sinopse;

    /**
     * @var int
     */
    private $totalPaginas;

    /**
     * @var int
     */
    private $tipoCapa;

    /**
     * @var string
     */
    private $fotoCapa;

    /**
     * @var int
     */
    private $codEditora;

    /**
     * @var array - vetor simples com ids dos autores
     * @sample array(2, 3)
     */
    private $autores;

    /**
     * @var array - vetor com ids dos gêneros
     * @sample array(1, 9, 11)
     */
    private $generos;

    /**
     * @var array - vetor com ids das séries. Pode ser simples ou multidimensional, sendo que o multidimensional possui a coluna "numero_na_serie" dentro de um vetor filho
     * @sample array(1, 8)
     * @sample array(
     *      1 => ['numero_na_serie' => 2],
     *      8 => ['numero_na_serie' => 9]
     * )
     */
    private $series;

    /**
     * Dinamicamente preenche propriedades do objeto a partir de um array
     *
     * @access public
     * @param array $dados
     * @return self
     */
    public static function fromArray(array $dados) : self {

        $self = new self();
        $self->titulo = $dados['titulo'];
        $self->tituloOriginal = $dados['titulo_original'];
        $self->idioma = $dados['idioma'];
        $self->isbn10 = $dados['isbn_10'];
        $self->isbn13 = $dados['isbn_13'];
        $self->dataPublicacao = $dados['data_publicacao'];
        $self->sinopse = $dados['sinopse'];
        $self->totalPaginas = $dados['total_paginas'];
        $self->tipoCapa = $dados['tipo_capa'];
        $self->fotoCapa = $dados['foto_capa'];
        $self->codEditora = $dados['cod_editora'];
        /*$self->autores = json_decode($dados['autores'], true);
        $self->generos = json_decode($dados['generos'], true);
        $self->series = json_decode($dados['series'], true);*/

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
            'titulo' => $this->titulo,
            'titulo_original' => $this->tituloOriginal,
            'idioma' => $this->idioma,
            'isbn_10' => $this->isbn10,
            'isbn_13' => $this->isbn13,
            'data_publicacao' => $this->dataPublicacao,
            'sinopse' => $this->sinopse,
            'total_paginas' => $this->totalPaginas,
            'tipo_capa' => $this->tipoCapa,
            'foto_capa' => $this->fotoCapa,
            'cod_editora' => $this->codEditora,
            /*'autores' => $this->autores,
            'generos' => $this->generos,
            'series' => $this->series*/
        ];

    }



}
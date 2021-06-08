<?php
namespace App\DataLayer\DTOs;

class PesquisarLivrosDto {

    /**
     * @var int
     */
    private $page;

    /**
     * @var int
     */
    private $pageSize;

    /**
     * @var array - vetor com dados para ordenação
     * @sample array(
     *      "titulo" => "asc",
     *      "idioma" => "desc"
     * )
     */
    private $sort;

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
    private $editora;

    /**
     * @var string
     */
    private $autor;

    /**
     * @var string
     */
    private $genero;

    /**
     * @var string
     */
    private $serie;

    /**
     * Dinamicamente preenche propriedades do objeto a partir de um array
     *
     * @access public
     * @param array $dados
     * @return self
     */
    public static function fromArray(array $dados) : self {

        $self = new self();
        $self->page = $dados['page'];
        $self->pageSize = $dados['page_size'];
        $self->sort = $dados['sort'];
        $self->titulo = $dados['titulo'];
        $self->tituloOriginal = $dados['titulo_original'];
        $self->idioma = $dados['idioma'];
        $self->isbn10 = $dados['isbn_10'];
        $self->isbn13 = $dados['isbn_13'];
        $self->dataPublicacao = $dados['data_publicacao'];
        $self->sinopse = $dados['sinopse'];
        $self->totalPaginas = $dados['total_paginas'];
        $self->tipoCapa = $dados['tipo_capa'];
        $self->editora = $dados['editora'];
        $self->autor = $dados['autor'];
        $self->genero = $dados['genero'];
        $self->serie = $dados['serie'];

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
            'page' => $this->page,
            'page_size' => $this->pageSize,
            'sort' => $this->sort,
            'titulo' => $this->titulo,
            'titulo_original' => $this->tituloOriginal,
            'idioma' => $this->idioma,
            'isbn_10' => $this->isbn10,
            'isbn_13' => $this->isbn13,
            'data_publicacao' => $this->dataPublicacao,
            'sinopse' => $this->sinopse,
            'total_paginas' => $this->totalPaginas,
            'tipo_capa' => $this->tipoCapa,
            'editora' => $this->editora,
            'autor' => $this->autor,
            'genero' => $this->genero,
            'serie' => $this->serie
        ];

    }



}
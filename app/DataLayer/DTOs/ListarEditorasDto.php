<?php
namespace App\DataLayer\DTOs;

class ListarEditorasDto {

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
            'sort' => $this->sort
        ];

    }



}
<?php
namespace App\DataLayer\DTOs;

class EfetuarLoginDto {

    /**
     * @var string
     */
    private $usuario;

    /**
     * @var string
     */
    private $password;

    /**
     * Dinamicamente preenche propriedades do objeto a partir de um array
     *
     * @access public
     * @param array $dados
     * @return self
     */
    public static function fromArray(array $dados) : self {

        $self = new self();
        $self->usuario = $dados['usuario'];
        $self->password = $dados['password'];

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
            'usuario' => $this->usuario,
            'password' => $this->password
        ];

    }



}
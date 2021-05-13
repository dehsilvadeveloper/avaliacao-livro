<?php
namespace App\DataLayer\DTOs;

class RegistrarUsuarioDto {

    /**
     * @var string
     */
    private $usuario;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $passwordConfirmation;

    /**
     * @var string
     */
    private $email;

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
        $self->passwordConfirmation = $dados['password_confirmation'];
        $self->email = $dados['email'];

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
            'password' => $this->password,
            'password_confirmation' => $this->passwordConfirmation,
            'email' => $this->email
        ];

    }



}
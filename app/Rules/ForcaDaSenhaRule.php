<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class ForcaDaSenhaRule implements Rule {

    public $tamanho = 10;
    public $checagemTamanho = false;
    public $checagemLetraMaiuscula = false;
    public $checagemNumero = false;
    public $checagemCaracterEspecial = false;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($tamanho) {

        $this->tamanho = $tamanho;
        
    }



    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value) {

        $this->checagemTamanho = Str::length($value) >= $this->tamanho;
        $this->checagemLetraMaiuscula = Str::lower($value) !== $value;
        $this->checagemNumero = (bool) preg_match('/[0-9]/', $value);
        $this->checagemCaracterEspecial = (bool) preg_match('/[^A-Za-z0-9]/', $value);

        return ($this->checagemTamanho && $this->checagemLetraMaiuscula && $this->checagemNumero && $this->checagemCaracterEspecial);

    }



    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message() {

        return 'O campo SENHA deve conter pelo menos ' . $this->tamanho . ' caracteres e conter pelo menos uma letra maiúscula, um número e um caracter especial.';

    }



}

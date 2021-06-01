<?php
namespace App\Exceptions;

use Exception;
use App\BusinessLayer\ResponseHttpCode;

class CamposObrigatoriosInvalidosException extends Exception {

    // Defino variaveis
    private $erros;

    /**
     * 
     * Método construtor
     * 
     * @access public
     * @param string $mensagem
     * @param array $erros
     * @return void
     * 
     */
    public function __construct($mensagem, $erros) {

        $this->erros = $erros;

        parent::__construct($mensagem, ResponseHttpCode::DATA_VALIDATION_FAILED);

    }



    /**
     * Retorna lista de erros da validação obtida pela exception
     *
     * @return array
     */
    public function getErrors() {

        return $this->erros;

    }
    


}

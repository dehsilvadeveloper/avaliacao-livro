<?php
namespace App\Helpers;

class ValidacaoHelper {

    /**
     *
     * Função: Verifico se o código passado é um HTTP STATUS CODE válido. 
     * Em caso negativo, retorna o código padrão (500). Em caso positivo, simplesmente retorna o código testado.
     * @param int $status_code
     * @return int
     *
     * */
    public static function validarHttpStatusCode($status_code) {

        $status_code_valid = array("100","101","200","201","202","203","204","205","206","300","301","302","303","304","305","306","307","400","401","402","403","404","405","406","407","408","409","410","411","412","413","414","415","416","417","422","500","501","502","503","504","505");

        if (in_array($status_code, $status_code_valid)) {

            return $status_code;

        } else {
        
            return 500;

        }

    }



    /**
     *
     * Função: Validação se CPF é verdadeiro ou não em PHP
     * @param string $cpf
     * @return string  
     *
     * */
    public static function validarCpf($cpf) {

        // Extrai somente os números
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {

            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;

            if ($cpf[$c] != $d) {
                return false;
            }

        }

        return true;

    }



    /**
     *
     * Função: Validar endereço de email
     * @param string $email
     * @return bool  
     *
     * */
    public static function validarEnderecoEmail($email) {

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {

            return false;

        } else {

            /*list($alias, $domain) = explode("@", $email);

            if (checkdnsrr($domain, "MX")) {

              return true;

            } else {

              return false;

            }*/

            return true;

        }

    }

} // Fecha classe
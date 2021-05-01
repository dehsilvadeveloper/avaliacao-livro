<?php
namespace App\Helpers;

class CalculoHelper {

    /**
     *
     * Função: Cálculo de regra de 3 
     * @param number $a
     * @param number $b
     * @param number $d
     * @return number
     *
     * */
    public static function regraDeTres($a, $b, $d) {

        /*****************************************
        /*****************************************
            Modelo do cruzamento de informações

            $a <=> $b
                x
            X  <=> $d
        /*****************************************
        *****************************************/

        // Cálculo do cruzamento 1
        $cruzamento_1 = $a * $d;

        // Cálculo do cruzamento 2
        $cruzamento_2 = $b;

        // Cálculo final
        $total = $cruzamento_1 / $cruzamento_2;

        // Retorno
        return $total;

    }

}
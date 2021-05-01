<?php
namespace App\Helpers;

class DataHoraHelper {

    /**
     *
     * Função: Validar se data 1 é maior que data 2 
     * @param string $data_1
     * @param string $data_2
     * @return bool
     *
     * */
    public static function dataMaiorQue($data_1, $data_2) {
        
        $data_1 = DateTime::createFromFormat('Y-m-d', $data_1);
        $data_2 = DateTime::createFromFormat('Y-m-d', $data_2);

        if ($data_1 > $data_2) {
    
            return true;
            
        } else {

            return false;

        } 
            
    }



    /**
     *
     * Função: Validar se data 1 é maior ou igual que data 2 
     * @param string $data_1
     * @param string $data_2
     * @return bool
     *
     * */
    public static function dataMaiorIgualQue($data_1, $data_2) {
        
        $data_1 = DateTime::createFromFormat('Y-m-d', $data_1);
        $data_2 = DateTime::createFromFormat('Y-m-d', $data_2);

        if ($data_1 >= $data_2) {
    
            return true;
            
        } else {

            return false;

        } 
            
    }



    /**
     *
     * Função: Validar se data 1 é menor que data 2 
     * @param string $data_1
     * @param string $data_2
     * @return bool 
     *
     * */
    public static function dataMenorQue($data_1, $data_2) {
        
        $data_1 = DateTime::createFromFormat('Y-m-d', $data_1);
        $data_2 = DateTime::createFromFormat('Y-m-d', $data_2);

        if ($data_1 < $data_2) {
    
            return true;
            
        } else {

            return false;

        } 
            
    } 



    /**
     *
     * Função: Validar se data 1 é menor ou igual que data 2 
     * @param string $data_1
     * @param string $data_2
     * @return bool
     *
     * */
    public static function dataMenorIgualQue($data_1, $data_2) {
        
        $data_1 = DateTime::createFromFormat('Y-m-d', $data_1);
        $data_2 = DateTime::createFromFormat('Y-m-d', $data_2);

        if ($data_1 <= $data_2) {
    
            return true;
            
        } else {

            return false;

        } 
            
    } 



    /**
     *
     * Função: Validar se data 1 é igual a data 2 
     * @param string $data_1
     * @param string $data_2
     * @return bool 
     *
     * */
    public static function dataIgual($data_1, $data_2) {
        
        $data_1 = DateTime::createFromFormat('Y-m-d', $data_1);
        $data_2 = DateTime::createFromFormat('Y-m-d', $data_2);

        if ($data_1 == $data_2) {
    
            return true;
            
        } else {

            return false;

        } 
            
    }



    /**
     *
     * Função: Checa a diferença em horas entre data 1 e data 2
     * @param string $data_1
     * @param string $data_2
     * @return number
     *
     * */
    public static function quantasHorasPassou($data_1, $data_2) {

        // Instancia 2 objetos Datetime
        $data_1 = new DateTime($data_1); // menor
        $data_2 = new DateTime($data_2); // maior

        // Calcula diferença entre datas
        $diff = $data_2->diff($data_1);

        // Capto valor de horas
        $horas = $diff->h;

        // Uno valor de horas e de dias passados
        $horas_passadas = $horas + ($diff->days * 24);

        // Retorno
        return $horas_passadas;

    }



    /**
     *
     * Função: Checa a diferença em dias entre data 1 e data 2
     * @param string $data_1
     * @param string $data_2
     * @return number
     *
     * */
    public static function quantasDiasPassou($data_1, $data_2) {

        // Instancia 2 objetos Datetime
        $data_1 = new DateTime($data_1); // menor
        $data_2 = new DateTime($data_2); // maior

        // Calcula diferença entre datas
        $diff = $data_2->diff($data_1);

        // Capto valor de dias
        $dias_passados = $diff->days;

        // Retorno
        return $dias_passados;

    }

} // Fecha classe
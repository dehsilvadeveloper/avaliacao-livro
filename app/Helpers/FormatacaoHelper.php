<?php
namespace App\Helpers;

class FormatacaoHelper {

    /**
     *
     * Função: Máscara para telefone fixo e celular
     * @param string $numero
     * @return string
     *
     * */
    public static function mascaraTelefone($numero) {
        
        // Limpeza de espaços vazios
        $numero = trim($numero);

        // Limpeza de caracteres que não sejam números
        $numero = preg_replace('/[^0-9]/', '', $numero);
     
        // Total de caracteres
        $qtd_caracteres = strlen($numero);

        if ($qtd_caracteres == 11) { 

            $parte_um = substr($numero,0,2);
            $parte_dois = substr($numero,2,1);
            $parte_tres = substr($numero,3,5);
            $parte_quatro = substr($numero,7,4);

            $numero = "($parte_um) $parte_dois$parte_tres-$parte_quatro";

        } elseif ($qtd_caracteres == 10) {

            $parte_um = substr($numero,0,2);
            $parte_dois = substr($numero,2,4);
            $parte_tres = substr($numero,6,4);

            $numero = "($parte_um) $parte_dois-$parte_tres";

        }
        
        return $numero;

    }



    /**
     *
     * Função: Máscara CPF
     * @return valor formatado 
     *
     * */
    public static function mascaraCpf($valor) {
        
        $valor = trim($valor);
        $cont = strlen($valor);

        if ($cont == 11) {

            $parte_um = substr($valor, 0, 3);
            $parte_dois = substr($valor, 3, 3);
            $parte_tres = substr($valor, 6, 3);
            $parte_quatro = substr($valor, 9, 2);

            $valor = "$parte_um.$parte_dois.$parte_tres-$parte_quatro";

        }
         
        return $valor;

    }



    /**
     *
     * Função: Formatar valor monetário para possibilitar inclusão correta no BD, deixando apenas os separadores decimais no valor
     * @param mixed $variavel
     * @return string
     *
     * */
    public static function formatarMoedaParaDatabase($variavel) {

        $source = array('.', ',');
        $replace = array('', '.');
        $final = str_replace($source, $replace, $variavel); // Remove os pontos e substitui a virgula pelo ponto
        
        return $final;

    }



    /**
     *
     * Função: Resumir texto com três (...) pontos  
     * @param string $texto
     * @param int $limite 
     * @return string
     *
     * */
    public static function resumirTexto(string $texto, int $limite) {

        // Se o texto for maior que o limite, ele corta o texto e adiciona 3 pontinhos.	
        if (strlen($texto) > $limite) {

            $saida = substr($texto, 0, $limite);
            $saida = trim($saida) . "...";

        } else { // caso contrário

            // Mantemos o texto como está
            $saida = $texto;

        }

        return $saida;

    }

} // Fecha classe
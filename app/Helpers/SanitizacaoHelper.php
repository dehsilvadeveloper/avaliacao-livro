<?php
namespace App\Helpers;

class SanitizacaoHelper {

	/**
     *
     * Função: Sanitizar número inteiro
	 * @param mixed $number
     * @return string
     *
     * */
    public static function sanitizarNumero($number) {

        return filter_var($number, FILTER_SANITIZE_NUMBER_INT);

    }



    /**
     *
     * Função: Sanitizar decimal
	 * @param mixed $decimal
     * @return string
     *
     * */
    public static function sanitizarDecimal($decimal) {

        return filter_var($decimal, FILTER_SANITIZE_NUMBER_FLOAT);

    }



	/**
     *
     * Função: Sanitizar url
	 * @param string $url
     * @return string
     *
     * */
    public static function sanitizarUrl($url) {

        return filter_var($url, FILTER_SANITIZE_URL);

    }



    /**
     *
     * Função: Removendo determinados caracteres de uma variavel, independente do tipo
     * @param mixed $variavel
     * @return string
     *
     * */
    public static function removerCaracteresEspeciais($variavel) {

        $new_variavel = $variavel;

        $new_variavel = str_replace(".", "", $new_variavel);
        $new_variavel = str_replace(",", "", $new_variavel);
        $new_variavel = str_replace(";", "", $new_variavel);
        $new_variavel = str_replace(":", "", $new_variavel);
        $new_variavel = str_replace("-", "", $new_variavel);
        $new_variavel = str_replace("/", "", $new_variavel);
        $new_variavel = str_replace("|", "", $new_variavel);
        $new_variavel = str_replace("(", "", $new_variavel);
        $new_variavel = str_replace(")", "", $new_variavel);
        $new_variavel = str_replace("<", "", $new_variavel);
        $new_variavel = str_replace(">", "", $new_variavel);

        return $new_variavel;

    }



	/**
     *
     * Função: Remover virgula de uma svariavel, independente do tipo
	 * @param mixed $variavel
     * @return string
     *
     * */
    public static function removerVirgula($variavel) {

		$new_variavel = $variavel;

        $new_variavel = str_replace(",", "", $new_variavel);

        return $new_variavel;

    }

} // Fecha classe
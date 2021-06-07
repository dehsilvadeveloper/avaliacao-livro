<?php
namespace App\Helpers;

class QueryHelper {

    /**
     *
     * Função: Gero array para usar na ordenação de queries a partir de uma string dividida por vírgulas
     * 
     * @param string $sortString
     * @param_sample: titulo, -idioma
     * 
     * @return array|null
     * @return_sample: array(
     *      "titulo" => "asc",
     *      "idioma" => "desc"
     * )
     *
     * */
    public static function converterStringParaArrayDeOrdenacaoDeQuery($sortString) {

        if ($sortString == '') { return; }
        
        // Quebro a string nas vírgulas encontradas
        $colunasParaSort = explode(',', $sortString);

        // Verifico se existem valores no array gerado pelo explode()
        if (count($colunasParaSort) > 0) {

            // Faço loop pelas colunas
            foreach ($colunasParaSort as $coluna) :

                // Caso exista o hifen (-) na string
                if (strpos($coluna, '-') !== false) {

                    $colunaEmPartes = explode('-', $coluna);

                    $colunaFormatada = trim($colunaEmPartes[1]);

                    $sort[$colunaFormatada] = 'desc';

                } else { // Não existe o hífen (-)

                    $sort[$coluna] = 'asc';

                }

                unset($colunaEmPartes);
                unset($colunaFormatada);

            endforeach;

            // Retorno
            return $sort;

        }

    }

} // Fecha classe
<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Schema;

class ColunaExisteEmTabelaRule implements Rule {

    public $tabela = null;
    public $colunaChecada = null;
    public $checagemExistenciaColuna = false;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($tabela) {

        $this->tabela = $tabela;
        
    }



    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value) {

        // Registro qual termo será checado como coluna
        $atributo = trim(explode('.', $attribute)[1]);
        $this->colunaChecada = $atributo;

        // Executo verificação de existência
        $this->checagemExistenciaColuna = Schema::hasColumn($this->tabela, $atributo);

        // Retorno
        return $this->checagemExistenciaColuna;

    }



    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message() {

        return 'A coluna ' . mb_strtoupper($this->colunaChecada) . ' não existe na tabela de dados, logo não é possível ordenar o resultado por ela. Ajuste sua opção SORT.';

    }



}

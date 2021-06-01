<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class IdadeLegalRule implements Rule {

    public $idadeLegal = 18;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($idade) {

         $this->idadeLegal = $idade;
        
    }



    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value) {

        $valorFormatado = new Carbon($value);
        $idadeLegal = Carbon::now()->subYears($this->idadeLegal);

        return $valorFormatado < $idadeLegal;

    }



    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message() {

        return 'Deve possuir pelo menos ' . $this->idadeLegal . ' anos de idade!';

    }



}

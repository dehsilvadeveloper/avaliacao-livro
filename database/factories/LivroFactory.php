<?php
namespace Database\Factories;

use App\Models\Livro;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LivroFactory extends Factory {

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Livro::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {

        return [
            'titulo' => $this->faker->sentence(),
            'titulo_original' => $this->faker->sentence(),
            'idioma' => $this->faker->randomElement(['Português', 'Inglês', 'Alemão', 'Japonês', 'Italiano', 'Chinês', 'Francês']),
            'isbn_10' => $this->faker->isbn10,
            'isbn_13' => $this->faker->isbn13,
            'data_publicacao' => $this->faker->dateTime(),
            'sinopse' => $this->faker->text(300),
            'total_paginas' => $this->faker->numberBetween(1000, 8000),
            'tipo_capa' => $this->faker->randomElement([1, 2]),
            'foto_capa' => date('YmdHis') . '.' . $this->faker->randomElement(['jpg', 'png']),
            'status' => $this->faker->randomElement([1, 0])
        ];
        
    }



    /**
     * Indica que o status é igual a 1 (ativo)
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function ativo() {

        return $this->state(function (array $attributes) {
            return [
                'status' => 1
            ];
        });

    }



    /**
     * Indica que o status é igual a 0 (inativo)
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function inativo() {

        return $this->state(function (array $attributes) {
            return [
                'status' => 0
            ];
        });

    }



}

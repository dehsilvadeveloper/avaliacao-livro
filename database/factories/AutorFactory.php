<?php
namespace Database\Factories;

use App\Models\Autor;
use Illuminate\Database\Eloquent\Factories\Factory;

class AutorFactory extends Factory {

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Autor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {

        return [
            'nome' => $this->faker->name(),
            'data_nascimento' => $this->faker->dateTimeBetween('1990-01-01', '2014-12-31')->format('Y-m-d'),
            'website' => $this->faker->url,
            'twitter' => $this->faker->url,
        ];
        
    }



}

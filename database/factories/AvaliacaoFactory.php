<?php
namespace Database\Factories;

use App\Models\Avaliacao;
use Illuminate\Database\Eloquent\Factories\Factory;

class AvaliacaoFactory extends Factory {

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Avaliacao::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {

        return [
            'nota' => $this->faker->randomElement([1, 2, 3, 4, 5]),
            'review' => $this->faker->text(200)
        ];
        
    }



}

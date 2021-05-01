<?php
namespace Database\Factories;

use App\Models\Serie;
use Illuminate\Database\Eloquent\Factories\Factory;

class SerieFactory extends Factory {

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Serie::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {

        return [
            'titulo' => $this->faker->sentence()
        ];
        
    }



}

<?php
namespace Database\Factories;

use App\Models\Pais;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaisFactory extends Factory {

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pais::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {

        return [
            'nome' => $this->faker->country(),
            'codigo' => $this->faker->countryCode()
        ];
        
    }



}

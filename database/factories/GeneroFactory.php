<?php
namespace Database\Factories;

use App\Models\Genero;
use Illuminate\Database\Eloquent\Factories\Factory;

class GeneroFactory extends Factory {

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Genero::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {

        return [
            'nome' => $this->faker->randomElement(['Romance', 'Ficção Científica', 'Terror', 'Suspense', 'Auto-Ajuda', 'Economia'])
        ];
        
    }



}

<?php
namespace Database\Factories;

use App\Models\Categories;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoriesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Categories::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $categories = [
            'Full Stack Web Development',
            'Mobile Development',
            'Backend Development',
            'Frontend Development',
            'AI and Machine Learning',
            'Data Science and Big Data',
            'Game Development',
            'Embedded Systems and IoT',
            'Cybersecurity',
            'Cloud Computing',
            'DevOps and Automation',
            'Database Systems',
        ];

        return [
            'categoryName' => $this->faker->unique()->randomElement($categories),
        ];
    }
}

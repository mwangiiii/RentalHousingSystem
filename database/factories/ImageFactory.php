<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\House;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    protected $model = Image::class;

    public function definition()
    {
        return [
            'house_id' => House::factory(),
            'image_path' => $this->faker->imageUrl(), // Example of generating a fake image URL
            'is_main' => false, // Initially set to false for all images
        ];
    }

    /**
     * Indicate that the image is the main thumbnail image.
     *
     * @return \Database\Factories\ImageFactory
     */
    public function mainThumbnail()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_main' => true,
            ];
        });
    }
}

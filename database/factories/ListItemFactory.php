<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\ListItem;
use App\Models\ToDoList;
use Illuminate\Database\Eloquent\Factories\Factory;

class ListItemFactory extends Factory
{
    protected $model = ListItem::class;

    public function definition()
    {
        return [
            'content' => $this->faker->words(8, true),
            'completed' => false,
        ];
    }

    public function withList()
    {
        return $this->state(function (array $attributes) {
            return [
                'list_id' => ToDoList::factory()->create()->id,
            ];
        });
    }
}

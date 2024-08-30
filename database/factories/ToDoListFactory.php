<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\ToDoList;
use Illuminate\Database\Eloquent\Factories\Factory;

class ToDoListFactory extends Factory
{
    protected $model = ToDoList::class;

    public function definition()
    {
        return [];
    }
}

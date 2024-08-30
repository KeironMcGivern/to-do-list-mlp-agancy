<?php

declare(strict_types=1);

namespace App\Domain\ToDoList\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->guid,
            'content' => $this->content,
            'completed' => $this->completed,
        ];
    }
}

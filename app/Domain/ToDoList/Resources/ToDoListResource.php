<?php

declare(strict_types=1);

namespace App\Domain\ToDoList\Resources;

use App\Domain\Shared\Resources\ResourceFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ToDoListResource extends JsonResource
{
    protected function getListItems(): ?JsonResource
    {
        if ($this->listItems->count() === 0) {
            return null;
        }

        return ResourceFactory::make($this->listItems);
    }

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->guid,
            'listItems' => $this->getListItems(),
        ];
    }
}

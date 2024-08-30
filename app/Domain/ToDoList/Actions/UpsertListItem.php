<?php

declare(strict_types=1);

namespace App\Domain\ToDoList\Actions;

use App\Models\ListItem;
use App\Models\ToDoList;
use Illuminate\Support\Arr;

class UpsertListItem
{
    protected ToDoList $list;

    protected array $data;

    protected ?ListItem $item;

    public function __construct(ToDoList $list, array $data = null, ?ListItem $item = null)
    {
        $this->list = $list;
        $this->data = $data;
        $this->item = $item;
    }

    public function execute(): ListItem
    {
        $item = $this->item ? $this->item : new ListItem();

        if (filled($this->data)) {
            $item->fill([
                'content' => Arr::get($this->data, 'content', $item->content),
                'completed' => Arr::get($this->data, 'completed', false),
                'list_id' => $this->list->id,
            ]);
        }

        $item->save();

        return $item;
    }
}

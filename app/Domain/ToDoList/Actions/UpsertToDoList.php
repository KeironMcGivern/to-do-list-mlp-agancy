<?php

declare(strict_types=1);

namespace App\Domain\ToDoList\Actions;

use App\Models\ToDoList;

class UpsertToDoList
{
    protected ?array $data;

    protected ?ToDoList $list;

    public function __construct(?array $data = null, ?ToDoList $list = null)
    {
        $this->data = $data;
        $this->list = $list;
    }

    public function execute(): ToDoList
    {
        $list = $this->list ? $this->list : new ToDoList();

        if (filled($this->data)) {
            $list->fill($this->data);
        }

        $list->save();

        return $list;
    }
}

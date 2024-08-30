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

        // I know we store no data in the To Do List itself but leaving the space for expansion
        // could save time and pain down the line
        if (filled($this->data)) {
            $list->fill($this->data);
        }

        $list->save();

        return $list;
    }
}

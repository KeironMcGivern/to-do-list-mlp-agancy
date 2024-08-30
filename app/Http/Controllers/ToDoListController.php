<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domain\Shared\Resources\ResourceFactory;
use App\Domain\ToDoList\Actions\UpsertListItem;
use App\Domain\ToDoList\Actions\UpsertToDoList;
use App\Http\Requests\DeleteListItemRequest;
use App\Http\Requests\StoreListItemRequest;
use App\Http\Requests\UpdateListItemRequest;
use App\Models\ListItem;
use App\Models\ToDoList;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ToDoListController
{
    public function index(): Response
    {
        $list = ToDoList::get()->first() ?? (new UpsertToDoList())->execute();

        return Inertia::render('ToDoList', [
            'list' => ResourceFactory::make($list),
        ]);
    }

    public function store(StoreListItemRequest $request, ToDoList $list): RedirectResponse
    {
        (new UpsertListItem($list, $request->validated()))->execute();

        return to_route('toDoList')
            ->with('success', trans('app.messages.list-item-created'));
    }


    public function update(UpdateListItemRequest $request, ListItem $item): RedirectResponse
    {
        (new UpsertListItem($item->list, ['completed' => true], $item))->execute();

        return to_route('toDoList')
            ->with('success', trans('app.messages.list-item-updated'));
    }

    public function delete(DeleteListItemRequest $request, ListItem $item): RedirectResponse
    {
        $item->delete();

        return to_route('toDoList')
            ->with('success', trans('app.messages.list-item-delete'));
    }
}
